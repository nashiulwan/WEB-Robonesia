<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PrestasiSertifikatModel;
use App\Models\UserPrestasiModel;
use App\Models\Manage_kelasModel;
use App\Models\GradeImagesModel;
use App\Models\UserModel;

class PrestasiSertifikatController extends BaseController
{
  protected $prestasiSertifikatModel;
  protected $userPrestasiModel;
  protected $manageKelasModel;
  protected $userModel;
  protected $gradeImagesModel;

  public function __construct()
  {
    $this->prestasiSertifikatModel = new PrestasiSertifikatModel();
    $this->userPrestasiModel = new UserPrestasiModel();
    $this->userModel      = new UserModel();
    $this->manageKelasModel = new Manage_kelasModel();
    $this->gradeImagesModel        = new GradeImagesModel();
  }

  // Menampilkan halaman utama dengan dua tab:
  // 1. Daftar Prestasi
  // 2. Daftar Akun (untuk memilih akun terlebih dahulu)

  public function index()
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }
    $data['title']     = 'Kelola Prestasi';
    $data['prestasis'] = $this->prestasiSertifikatModel->findAll();
    // Hanya ambil user dengan role siswa (group_id = 2)
    $data['users']     = $this->prestasiSertifikatModel->getUsersByRole(2);
    return view('admin/prestasi_sertifikat/prestasi/index', $data);
  }


  //===============================================================================//
  //===============================================================================//
  //===============================================================================//
  //Prestasi Perorangan Mulai
  //===============================================================================//

  public function prestasiDetail($user_id)
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    // Ambil data user berdasarkan user_id
    $user = $this->userModel->find($user_id);
    if (!$user) {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('User tidak ditemukan.');
    }

    // Ambil prestasi yang terkait dengan user
    $prestasis = $this->prestasiSertifikatModel
      ->select('prestasi.*')
      ->join('user_prestasi', 'user_prestasi.prestasi_id = prestasi.id')
      ->where('user_prestasi.user_id', $user_id)
      ->findAll();

    $data = [
      'title'     => 'Prestasi ' . $user['fullname'],
      'user'      => $user,
      'prestasis' => $prestasis,
    ];

    return view('admin/prestasi_sertifikat/prestasi/prestasi_user', $data);
  }


  // Menampilkan form tambah prestasi untuk user tertentu
  public function prestasiDetailTambah($userId)
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    // Ambil data user berdasarkan ID
    $user = $this->userModel->find($userId);
    if (!$user) {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('User tidak ditemukan.');
    }

    $users = $this->prestasiSertifikatModel->getUsersByRole('2');

    $data = [
      'title' => 'Tambah Prestasi ' . $user['fullname'],
      'user'  => $user,
      'users' => $users,
    ];

    return view('admin/prestasi_sertifikat/prestasi/prestasi_user_tambah', $data);
  }

  public function prestasiDetailSimpan()
  {
    $post = $this->request->getPost();

    // Validasi input dengan rules
    $validationRules = [
      'nama_kegiatan' => 'required',
      'jenis'         => 'required|in_list[Individual,Kelompok]',
      'tingkat'       => 'required',
      'tahun'         => 'required|numeric',
      'pencapaian'    => 'required',
    ];

    if (! $this->validate($validationRules)) {
      session()->setFlashdata('error', 'Semua field harus diisi dengan benar.');
      return redirect()->back()->withInput();
    }

    // Jika nilai tingkat adalah 'lainnya', gunakan nilai dari input tingkat_lainnya
    $tingkat = $post['tingkat'];
    if ($tingkat == 'Lainnya') {
      $tingkat = $post['tingkat_lainnya'];
    }

    // Mulai database transaction
    $db = \Config\Database::connect();
    $db->transStart();

    // Siapkan data prestasi, dengan field 'tingkat' sudah disesuaikan
    $prestasiData = [
      'nama_kegiatan' => $post['nama_kegiatan'],
      'jenis'         => $post['jenis'],
      'tingkat'       => $tingkat,
      'tahun'         => $post['tahun'],
      'pencapaian'    => $post['pencapaian'],
    ];

    // Simpan data prestasi
    $this->prestasiSertifikatModel->insert($prestasiData);
    $prestasiId = $this->prestasiSertifikatModel->getInsertID();

    // Tentukan user yang terhubung dengan prestasi berdasarkan jenisnya
    $userIds = [];
    if ($post['jenis'] === 'Individual') {
      $userIds[] = $post['user_id']; // Pastikan user yang sedang menginput masuk
    } elseif ($post['jenis'] === 'Kelompok' && isset($post['user_ids'])) {
      $userIds = $post['user_ids'];
      if (!in_array($post['user_id'], $userIds)) {
        $userIds[] = $post['user_id']; // Tambahkan user_id dari view jika belum ada
      }
    }
    // Cek apakah user_id valid sebelum dimasukkan ke pivot table
    $validUserIds = $this->userModel->whereIn('id', $userIds)->findColumn('id');

    if (!empty($validUserIds)) {
      $userPrestasiModel = new UserPrestasiModel();
      foreach ($validUserIds as $uid) {
        $userPrestasiModel->insert([
          'user_id'     => $uid,
          'prestasi_id' => $prestasiId,
        ]);
      }
    }

    // Selesaikan transaksi
    $db->transComplete();

    if ($db->transStatus() === false) {
      session()->setFlashdata('error', 'Terjadi kesalahan saat menyimpan prestasi.');
      return redirect()->back()->withInput();
    }

    session()->setFlashdata('success', 'Prestasi berhasil ditambahkan.');
    return redirect()->to(base_url('admin/prestasi/prestasi_detail/' . esc($post['user_id'])));
  }

  public function prestasiDetailInfo($user_id, $prestasiId)
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    // Gunakan $user_id yang dikirim sebagai owner
    $owner = $this->userModel->find($user_id);
    if (!$owner) {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Owner tidak ditemukan.');
    }

    // Ambil data prestasi
    $prestasi = $this->prestasiSertifikatModel->find($prestasiId);
    if (!$prestasi) {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Prestasi tidak ditemukan.');
    }

    // Ambil semua record pivot untuk prestasi ini beserta data user-nya
    $pivotRecords = $this->userPrestasiModel
      ->select('user_prestasi.id as pivot_id, user_prestasi.user_id, user_prestasi.prestasi_id, 
                  users.username, users.fullname, users.email, users.asal_sekolah, users.kelas, 
                  users.alamat, users.nomor_telepon')
      ->join('users', 'users.id = user_prestasi.user_id')
      ->where('user_prestasi.prestasi_id', $prestasiId)
      ->findAll();

    // Filter anggota: ambil semua record pivot yang user_id-nya tidak sama dengan owner
    $anggotaLainnya = [];
    if (!empty($pivotRecords)) {
      foreach ($pivotRecords as $record) {
        if ($record['user_id'] != $user_id) {
          $anggotaLainnya[] = $record;
        }
      }
    }

    $data = [
      'title'     => 'Detail Prestasi',
      'prestasi'  => $prestasi,
      'owner'     => $owner,
      'anggota'   => ($prestasi['jenis'] === 'Kelompok') ? $anggotaLainnya : []
    ];

    return view('admin/prestasi_sertifikat/prestasi/prestasi_user_info', $data);
  }


  // Menampilkan form edit prestasi
  public function prestasiDetailEdit($userId, $prestasiId)
  {
    // Pastikan user sudah login
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    // Ambil data user
    $user = $this->userModel->find($userId);
    if (!$user) {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('User tidak ditemukan.');
    }

    // Ambil data prestasi
    $prestasi = $this->prestasiSertifikatModel->find($prestasiId);
    if (!$prestasi) {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Prestasi tidak ditemukan.');
    }

    // Ambil semua record pivot untuk prestasi ini beserta data user-nya
    $pivotRecords = $this->userPrestasiModel
      ->select('user_prestasi.id as pivot_id, user_prestasi.user_id, user_prestasi.prestasi_id, 
                users.username, users.fullname, users.email, users.asal_sekolah, users.kelas, 
                users.alamat, users.nomor_telepon')
      ->join('users', 'users.id = user_prestasi.user_id')
      ->where('user_prestasi.prestasi_id', $prestasiId)
      ->findAll();

    // Filter anggota: ambil record pivot yang user_id-nya tidak sama dengan owner
    $anggotaLainnya = [];
    if (!empty($pivotRecords)) {
      foreach ($pivotRecords as $record) {
        if ($record['user_id'] != $userId) {
          $anggotaLainnya[] = $record;
        }
      }
    }

    // Ambil data akun lain (misalnya berdasarkan role tertentu)
    $users = $this->prestasiSertifikatModel->getUsersByRole('2');

    $data = [
      'title'         => 'Edit Prestasi',
      'prestasi'      => $prestasi,
      'user'          => $user,
      'users'         => $users,
      'anggotaLainnya' => $anggotaLainnya
    ];

    return view('admin/prestasi_sertifikat/prestasi/prestasi_user_edit', $data);
  }

  // Memproses update data prestasi (POST)
  public function prestasiDetailUpdate($userId, $prestasiId)
  {
    $post = $this->request->getPost();

    // Validasi input dengan rules
    $validationRules = [
      'nama_kegiatan' => 'required',
      'jenis'         => 'required|in_list[Individual,Kelompok]',
      'tingkat'       => 'required',
      'tahun'         => 'required|numeric',
      'pencapaian'    => 'required',
    ];

    if (! $this->validate($validationRules)) {
      session()->setFlashdata('error', 'Semua field harus diisi dengan benar.');
      return redirect()->back()->withInput();
    }

    // Jika nilai tingkat adalah 'lainnya', gunakan nilai dari input tingkat_lainnya
    $tingkat = $post['tingkat'];
    if ($tingkat == 'Lainnya') {
      $tingkat = $post['tingkat_lainnya'];
    }

    // Mulai database transaction
    $db = \Config\Database::connect();
    $db->transStart();

    // Siapkan data prestasi
    $prestasiData = [
      'nama_kegiatan' => $post['nama_kegiatan'],
      'jenis'         => $post['jenis'],
      'tingkat'       => $tingkat,
      'tahun'         => $post['tahun'],
      'pencapaian'    => $post['pencapaian'],
    ];

    // Update data prestasi
    $this->prestasiSertifikatModel->update($prestasiId, $prestasiData);

    // Update pivot table: hapus semua data lama untuk prestasi ini
    $userPrestasiModel = new UserPrestasiModel();
    $userPrestasiModel->where('prestasi_id', $prestasiId)->delete();

    // Tentukan user yang terhubung dengan prestasi berdasarkan jenisnya
    $userIds = [];
    if ($post['jenis'] === 'Individual') {
      // Hanya satu user (individu), yaitu user yang sedang login
      $userIds[] = $post['user_id'];
    } elseif ($post['jenis'] === 'Kelompok' && isset($post['user_ids'])) {
      // Ambil semua user yang dipilih dari form
      $userIds = $post['user_ids'];
      // Pastikan user yang sedang login juga masuk ke daftar anggota
      if (!in_array($post['user_id'], $userIds)) {
        $userIds[] = $post['user_id'];
      }
    }

    // Cek apakah user_id valid sebelum dimasukkan ke pivot table
    $validUserIds = $this->userModel->whereIn('id', $userIds)->findColumn('id');

    if (!empty($validUserIds)) {
      foreach ($validUserIds as $uid) {
        $userPrestasiModel->insert([
          'user_id'     => $uid,
          'prestasi_id' => $prestasiId,
        ]);
      }
    }

    // Selesaikan transaksi
    $db->transComplete();

    if ($db->transStatus() === false) {
      session()->setFlashdata('error', 'Terjadi kesalahan saat memperbarui prestasi.');
      return redirect()->back()->withInput();
    }

    session()->setFlashdata('success', 'Prestasi berhasil diperbarui.');
    return redirect()->to(base_url('admin/prestasi/prestasi_detail/' . esc($userId)));
  }

  // Menghapus prestasi dan data relasinya di pivot table
  public function prestasiDetailDelete($prestasi_id)
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    // Hapus relasi di pivot table
    $this->userPrestasiModel->where('prestasi_id', $prestasi_id)->delete();
    // Hapus record prestasi
    $this->prestasiSertifikatModel->delete($prestasi_id);

    session()->setFlashdata('success', 'Prestasi berhasil dihapus.');
    // Redirect kembali ke halaman sebelumnya
    return redirect()->back();
  }
  //===============================================================================//
  //Prestasi Perorang Selesai
  //===============================================================================//
  //===============================================================================//
  //===============================================================================//



  //===============================================================================//
  //===============================================================================//
  //===============================================================================//
  //Prestasi Umum Mulai
  //===============================================================================//

  public function prestasiInfo($prestasiId)
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    // Ambil data prestasi
    $prestasi = $this->prestasiSertifikatModel->find($prestasiId);
    if (!$prestasi) {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Prestasi tidak ditemukan.');
    }

    // Ambil semua record pivot untuk prestasi ini beserta data user-nya
    $pivotRecords = $this->userPrestasiModel
      ->select('user_prestasi.id as pivot_id, user_prestasi.user_id, user_prestasi.prestasi_id, 
                  users.username, users.fullname, users.email, users.asal_sekolah, users.kelas, 
                  users.alamat, users.nomor_telepon')
      ->join('users', 'users.id = user_prestasi.user_id')
      ->where('user_prestasi.prestasi_id', $prestasiId)
      ->findAll();

    $anggota = [];
    if (!empty($pivotRecords)) {
      foreach ($pivotRecords as $record) {
        $anggota[] = $record;
      }
    }

    $data = [
      'title'     => 'Detail Prestasi',
      'prestasi'  => $prestasi,
      'anggota'   => $anggota,
    ];

    return view('admin/prestasi_sertifikat/prestasi/prestasi_info', $data);
  }
  // Menampilkan form tambah prestasi untuk user tertentu
  public function prestasiTambah()
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    $users = $this->prestasiSertifikatModel->getUsersByRole('2');

    $data = [
      'title' => 'Tambah Prestasi',
      'users' => $users,
    ];

    return view('admin/prestasi_sertifikat/prestasi/prestasi_tambah', $data);
  }
  public function prestasiSimpan()
  {
    $post = $this->request->getPost();

    // Validasi input dengan rules
    $validationRules = [
      'nama_kegiatan' => 'required',
      'jenis'         => 'required|in_list[Individual,Kelompok]',
      'tingkat'       => 'required',
      'tahun'         => 'required|numeric',
      'pencapaian'    => 'required',
    ];

    if (!$this->validate($validationRules)) {
      session()->setFlashdata('error', 'Semua field harus diisi dengan benar.');
      return redirect()->back()->withInput();
    }

    // Jika tingkat adalah 'Lainnya', gunakan nilai dari input tingkat_lainnya
    $tingkat = ($post['tingkat'] == 'Lainnya') ? $post['tingkat_lainnya'] : $post['tingkat'];

    // Mulai database transaction
    $db = \Config\Database::connect();
    $db->transStart();

    // Siapkan data prestasi
    $prestasiData = [
      'nama_kegiatan' => $post['nama_kegiatan'],
      'jenis'         => $post['jenis'],
      'tingkat'       => $tingkat,
      'tahun'         => $post['tahun'],
      'pencapaian'    => $post['pencapaian'],
    ];

    // Simpan data prestasi
    $this->prestasiSertifikatModel->insert($prestasiData);
    $prestasiId = $this->prestasiSertifikatModel->getInsertID();

    // Pastikan user_ids selalu berupa array (jika ada)
    $userIds = [];
    if (isset($post['user_ids'])) {
      $userIds = is_array($post['user_ids']) ? $post['user_ids'] : [$post['user_ids']];
    }

    // Jika Individual, wajib memilih satu akun
    if ($post['jenis'] === 'Individual' && empty($userIds)) {
      session()->setFlashdata('error', 'Untuk prestasi Individual, pilih satu akun.');
      return redirect()->back()->withInput();
    }

    // Cek apakah user_ids valid sebelum dimasukkan ke pivot table
    if (!empty($userIds)) {
      $validUserIds = $this->userModel->whereIn('id', $userIds)->findColumn('id');

      if (!empty($validUserIds)) {
        $userPrestasiModel = new UserPrestasiModel();
        foreach ($validUserIds as $uid) {
          $userPrestasiModel->insert([
            'user_id'     => $uid,
            'prestasi_id' => $prestasiId,
          ]);
        }
      }
    }

    // Selesaikan transaksi
    $db->transComplete();

    if ($db->transStatus() === false) {
      session()->setFlashdata('error', 'Terjadi kesalahan saat menyimpan prestasi.');
      return redirect()->back()->withInput();
    }

    session()->setFlashdata('success', 'Prestasi berhasil ditambahkan.');
    return redirect()->to(base_url('admin/prestasi'));
  }


  // Menampilkan form edit prestasi
  public function prestasiEdit($prestasiId)
  {
    // Pastikan user sudah login
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    // Ambil data prestasi
    $prestasi = $this->prestasiSertifikatModel->find($prestasiId);
    if (!$prestasi) {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Prestasi tidak ditemukan.');
    }

    // Ambil semua record pivot untuk prestasi ini beserta data user-nya
    $pivotRecords = $this->userPrestasiModel
      ->select('user_prestasi.id as pivot_id, user_prestasi.user_id, user_prestasi.prestasi_id, 
                users.username, users.fullname, users.email, users.asal_sekolah, users.kelas, 
                users.alamat, users.nomor_telepon')
      ->join('users', 'users.id = user_prestasi.user_id')
      ->where('user_prestasi.prestasi_id', $prestasiId)
      ->findAll();

    // Filter anggota: ambil record pivot yang user_id-nya tidak sama dengan owner
    $anggota = [];
    if (!empty($pivotRecords)) {
      foreach ($pivotRecords as $record) {
        $anggota[] = $record;
      }
    }

    $users = $this->prestasiSertifikatModel->getUsersByRole('2');

    $data = [
      'title'         => 'Edit Prestasi',
      'prestasi'      => $prestasi,
      'users'         => $users,
      'anggota' => $anggota
    ];

    return view('admin/prestasi_sertifikat/prestasi/prestasi_edit', $data);
  }

  public function prestasiUpdate($prestasiId)
  {
    $post = $this->request->getPost();

    // Validasi input
    $validationRules = [
      'nama_kegiatan' => 'required',
      'jenis'         => 'required|in_list[Individual,Kelompok]',
      'tingkat'       => 'required',
      'tahun'         => 'required|numeric',
      'pencapaian'    => 'required',
    ];

    if (! $this->validate($validationRules)) {
      session()->setFlashdata('error', 'Semua field harus diisi dengan benar.');
      return redirect()->back()->withInput();
    }

    // Menyesuaikan nilai tingkat jika "Lainnya" dipilih
    $tingkat = $post['tingkat'] === 'Lainnya' ? $post['tingkat_lainnya'] : $post['tingkat'];

    // Ambil data prestasi saat ini
    $currentPrestasi = $this->prestasiSertifikatModel->find($prestasiId);

    // Data baru dari form
    $newPrestasiData = [
      'nama_kegiatan' => $post['nama_kegiatan'],
      'jenis'         => $post['jenis'],
      'tingkat'       => $tingkat,
      'tahun'         => $post['tahun'],
      'pencapaian'    => $post['pencapaian'],
    ];

    // Cek apakah data utama telah berubah
    $dataChanged = false;
    foreach ($newPrestasiData as $key => $value) {
      if ($currentPrestasi[$key] != $value) {
        $dataChanged = true;
        break;
      }
    }

    // Tentukan user_ids berdasarkan jenis prestasi
    $userIds = [];
    if ($post['jenis'] === 'Individual') {
      $userIds[] = $post['user_id'] ?? session()->get('id');
    } elseif ($post['jenis'] === 'Kelompok' && isset($post['user_ids'])) {
      $userIds = $post['user_ids'];
      // Pastikan user yang sedang login termasuk
      $currentUserId = $post['user_id'] ?? session()->get('id');
      if (!in_array($currentUserId, $userIds)) {
        $userIds[] = $currentUserId;
      }
    }
    sort($userIds);

    // Ambil data pivot (user-prestasi) saat ini
    $userPrestasiModel = new UserPrestasiModel();
    $currentPivot = $userPrestasiModel->where('prestasi_id', $prestasiId)->findAll();
    $currentUserIds = [];
    foreach ($currentPivot as $row) {
      $currentUserIds[] = $row['user_id'];
    }
    sort($currentUserIds);

    // Cek apakah data pivot berubah
    if ($userIds != $currentUserIds) {
      $dataChanged = true;
    }

    // Jika tidak ada perubahan, jangan lakukan eksekusi update
    if (!$dataChanged) {
      session()->setFlashdata('info', 'Tidak ada perubahan data.');
      return redirect()->back();
    }

    // Mulai transaksi database
    $db = \Config\Database::connect();
    $db->transStart();

    // Update data prestasi
    $this->prestasiSertifikatModel->update($prestasiId, $newPrestasiData);

    // Update pivot table: hapus data lama jika ada perubahan pada user_ids
    if ($userIds != $currentUserIds) {
      $userPrestasiModel->where('prestasi_id', $prestasiId)->delete();
      $validUserIds = $this->userModel->whereIn('id', $userIds)->findColumn('id');
      if (!empty($validUserIds)) {
        foreach ($validUserIds as $uid) {
          $userPrestasiModel->insert([
            'user_id'     => $uid,
            'prestasi_id' => $prestasiId,
          ]);
        }
      }
    }

    $db->transComplete();

    if ($db->transStatus() === false) {
      session()->setFlashdata('error', 'Terjadi kesalahan saat memperbarui prestasi.');
      return redirect()->back()->withInput();
    }

    session()->setFlashdata('success', 'Prestasi berhasil diperbarui.');
    return redirect()->to(base_url('admin/prestasi'));
  }


  public function prestasiDelete($prestasiId)
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    // Hapus relasi di pivot table
    $this->userPrestasiModel->where('prestasi_id', $prestasiId)->delete();
    // Hapus record prestasi
    $this->prestasiSertifikatModel->delete($prestasiId);

    session()->setFlashdata('success', 'Prestasi berhasil dihapus.');
    // Redirect kembali ke halaman sebelumnya
    return redirect()->back();
  }
  //===============================================================================//
  //Prestasi Umum Selesai
  //===============================================================================//
  //===============================================================================//
  //===============================================================================//


  //===============================================================================//
  //Grade Kelas Mulai
  //===============================================================================//
  //===============================================================================//
  //===============================================================================//
  // Menampilkan daftar kelas
  public function gradeIndex()
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    $classes = $this->manageKelasModel->getAllClassesWithMemberCount();

    // Untuk tiap kelas, ambil semua gambar dari tabel pivot grade_images
    foreach ($classes as &$class) {
      $images = $this->gradeImagesModel->where('kelas_id', $class['id'])->findAll();
      // Simpan data gambar sebagai array di key 'images'
      $class['images'] = $images;
    }
    unset($class); // hapus reference

    $data = [
      'title'   => 'Daftar Kelas',
      'classes' => $classes,
    ];

    return view('admin/prestasi_sertifikat/grade_level/index', $data);
  }


  // Menampilkan detail kelas (termasuk data gambar dari tabel pivot grade_images)
  public function gradeDetail($id)
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    // Ambil detail kelas (termasuk jumlah anggota)
    $class = $this->manageKelasModel->getClassWithMemberCountById($id);
    $proyek = $this->gradeImagesModel->where('kelas_id', $id)->findAll();

    $data = [
      'title'  => 'Informasi Level Kelas',
      'class'  => $class,
      'proyek' => $proyek,
    ];

    return view('admin/prestasi_sertifikat/grade_level/kelas_detail', $data);
  }

  // Menampilkan form edit level
  public function gradeLevel($id)
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    $class = $this->manageKelasModel->getClassWithMemberCountById($id);

    $data = [
      'title'   => 'Edit Level Kelas ' . $class['nama_kelas'],
      'kelas'   => $class,
    ];

    return view('admin/prestasi_sertifikat/grade_level/kelas_level', $data);
  }


  // Memproses update data kelas (hanya menyimpan level dan sub_level)
  public function gradeLevelUpdate($id)
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    // Validasi input dasar
    $validationRules = [
      'level'     => 'required',
      'sub_level' => 'required',
    ];

    if (!$this->validate($validationRules)) {
      return redirect()->back()
        ->withInput()
        ->with('errors', $this->validator->getErrors());
    }

    // Ambil nilai level; jika level "Lainnya", gunakan nilai dari input level_lainnya
    $level = $this->request->getPost('level');
    if ($level === 'Lainnya') {
      $level = $this->request->getPost('level_lainnya');
    }
    $sub_level = $this->request->getPost('sub_level');

    // Update data utama kelas 
    $data = [
      'level'      => $level,
      'sub_level'  => $sub_level,
      'updated_at' => date('Y-m-d H:i:s'),
    ];

    $result = $this->manageKelasModel->update($id, $data);
    if (!$result) {
      $errors = $this->manageKelasModel->errors();
      log_message('error', 'Update grade level gagal: ' . print_r($errors, true));
      return redirect()->back()->with('error', 'Gagal memperbarui grade level.');
    }

    return redirect()->to(base_url('admin/grade_level'))
      ->with('success', 'Level kelas berhasil diperbarui.');
  }

  // Menampilkan daftar proyek berdasarkan ID kelas
  public function gradeProyek($kelas_id)
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    $kelas = $this->manageKelasModel->find($kelas_id);
    $proyek = $this->gradeImagesModel->where('kelas_id', $kelas_id)->findAll();

    $data = [
      'title' => 'Daftar Proyek',
      'kelas' => $kelas,
      'proyek' => $proyek,
    ];

    return view('admin/prestasi_sertifikat/grade_level/kelas_proyek', $data);
  }

  // Menampilkan form tambah proyek berdasarkan ID kelas
  public function gradeProyekTambah($kelas_id)
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    $kelas = $this->manageKelasModel->find($kelas_id);

    $data = [
      'title' => 'Tambah Proyek',
      'kelas' => $kelas,
    ];

    return view('admin/prestasi_sertifikat/grade_level/kelas_proyek_tambah', $data);
  }

  public function gradeProyekSimpan($kelas_id)
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    $validationRules = [
      'deskripsi' => 'required',
      'image_name' => [
        'rules'  => 'permit_empty|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/svg+xml]|max_size[gambar,2048]',
        'errors' => [
          'is_image' => 'File harus berupa gambar.',
          'mime_in'  => 'Format gambar harus JPG, JPEG, PNG, atau SVG.',
          'max_size' => 'Ukuran gambar maksimal 2MB.'
        ]
      ]
    ];

    if (!$this->validate($validationRules)) {
      return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    $gradeImagesModel = new GradeImagesModel();

    $data = [
      'deskripsi'   => $this->request->getPost('deskripsi'),
      'kelas_id'    => $kelas_id,
      'created_at'  => date('Y-m-d H:i:s'),
    ];

    // Proses upload gambar
    $file = $this->request->getFile('gambar');
    if ($file && $file->isValid() && !$file->hasMoved()) {
      $newFileName = $file->getRandomName(); // Generate nama acak
      $file->move(FCPATH . 'uploads/proyek/', $newFileName); // Simpan ke folder uploads/proyek/
      $data['image_name'] = $newFileName; // Simpan nama file ke database menggunakan key image_name
    }

    if ($gradeImagesModel->insert($data)) {
      return redirect()->to('admin/grade_level/proyek/' . $kelas_id)->with('success', 'Proyek berhasil ditambahkan!');
    } else {
      return redirect()->back()->withInput()->with('error', 'Gagal menyimpan proyek.');
    }
  }

  public function gradeProyekEdit($kelas_id, $proyek_id)
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    // Ambil data kelas
    $kelas = $this->manageKelasModel->find($kelas_id);
    // Ambil data proyek berdasarkan ID proyek
    $proyek = $this->gradeImagesModel->find($proyek_id);

    if (!$proyek) {
      throw new \CodeIgniter\Exceptions\PageNotFoundException("Proyek tidak ditemukan.");
    }

    $data = [
      'title'   => 'Edit Proyek',
      'kelas'   => $kelas,
      'proyek'  => $proyek,
    ];

    return view('admin/prestasi_sertifikat/grade_level/kelas_proyek_edit', $data);
  }


  public function gradeProyekUpdate($kelas_id)
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    // Validasi file gambar
    $validationRules = [
      'gambar' => [
        'rules'  => 'uploaded[gambar]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/svg+xml]|max_size[gambar,2048]',
        'errors' => [
          'uploaded' => 'Gambar harus diunggah.',
          'is_image' => 'File harus berupa gambar.',
          'mime_in'  => 'Format gambar harus JPG, JPEG, PNG, atau SVG.',
          'max_size' => 'Ukuran gambar maksimal 2MB.'
        ]
      ]
    ];

    if (!$this->validate($validationRules)) {
      return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    $gradeImagesModel = new GradeImagesModel();

    // Proses upload gambar
    $file = $this->request->getFile('gambar');
    if ($file->isValid() && !$file->hasMoved()) {
      $newFileName = $file->getRandomName(); // Generate nama acak
      $file->move(FCPATH . 'uploads/proyek/', $newFileName); // Simpan ke folder uploads/proyek/

      // Simpan informasi gambar ke database
      $data = [
        'kelas_id' => $kelas_id,
        'image_name'     => $newFileName,
        'created_at'     => date('Y-m-d H:i:s'),
      ];

      if ($gradeImagesModel->insert($data)) {
        return redirect()->to('admin/grade_level/proyek/' . $kelas_id)->with('success', 'Gambar berhasil diunggah!');
      } else {
        return redirect()->back()->withInput()->with('error', 'Gagal menyimpan gambar ke database.');
      }
    } else {
      return redirect()->back()->withInput()->with('error', 'Gagal mengunggah gambar.');
    }
  }

  public function gradeProyekDelete($kelas_id, $proyek_id)
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    $proyek = $this->gradeImagesModel->where(['id' => $proyek_id, 'kelas_id' => $kelas_id])->first();

    if ($proyek) {
      $this->gradeImagesModel->delete($proyek_id);
      return redirect()->to('admin/grade_level/proyek/' . $kelas_id)->with('success', 'Proyek berhasil dihapus');
    }

    return redirect()->to('admin/grade_level/proyek/' . $kelas_id)->with('error', 'Proyek tidak ditemukan');
  }
}
