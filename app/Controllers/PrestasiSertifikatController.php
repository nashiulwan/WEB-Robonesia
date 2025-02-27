<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PrestasiSertifikatModel;
use App\Models\UserPrestasiModel;
use App\Models\UserModel;

class PrestasiSertifikatController extends BaseController
{
  protected $prestasiSertifikatModel;
  protected $userPrestasiModel;
  protected $userModel;

  public function __construct()
  {
    $this->prestasiSertifikatModel = new PrestasiSertifikatModel();
    $this->userPrestasiModel = new UserPrestasiModel();
    $this->userModel      = new UserModel();
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
      'anggota'   => ($prestasi['jenis'] === 'Kelompok') ? $anggota : []
    ];

    return view('admin/prestasi_sertifikat/prestasi/prestasi_info', $data);
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


  // Memproses update data prestasi (POST)
  public function prestasiUpdate($prestasiId)
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
    $userIds[] = $post['user_id'];

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
}
