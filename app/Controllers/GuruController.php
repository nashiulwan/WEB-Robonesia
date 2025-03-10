<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\Manage_kelasModel;
use App\Models\PrestasiSertifikatModel;
use CodeIgniter\Controller;
use App\Models\ProfilModel;
use Myth\Auth\Password;
use App\Controllers\BaseController;
use App\Database\Migrations\ManageKelas;
use App\Models\Manage_akunModel;
use Myth\Auth\Models\UserModel;
use App\Models\UserPrestasiModel;
use App\Models\GradeImagesModel;
use App\Models\SertifikatModel;
use App\Models\GaleriSiswaModel;


class GuruController extends BaseController
{
    protected $artikelModel;
    protected $manage_akunModel;
    protected $manageKelasModel;
    protected $prestasiSertifikatModel;
    // protected $kategoriModel;
    protected $userModel;
    protected $userPrestasiModel;
    protected $gradeImagesModel;
    protected $sertifikatModel;
    protected $galeriSiswaModel;

    public function __construct()
    {
        $this->prestasiSertifikatModel = new PrestasiSertifikatModel();
        $this->manageKelasModel = new Manage_kelasModel();
        $this->artikelModel = new ArtikelModel();
        $this->manage_akunModel = new Manage_akunModel();
        $this->userModel = new UserModel();
        $this->prestasiSertifikatModel = new PrestasiSertifikatModel();
        $this->userPrestasiModel = new UserPrestasiModel();
        $this->userModel = new UserModel();
        $this->manageKelasModel = new Manage_kelasModel();
        $this->gradeImagesModel = new GradeImagesModel();
        $this->sertifikatModel = new SertifikatModel();
        $this->galeriSiswaModel = new GaleriSiswaModel();
        $this->userModel = new UserModel();
    }

    // Method untuk dashboard
    public function dashboard()
    {
        $artikelModel = new ArtikelModel();
        $prestasi = $this->prestasiSertifikatModel->findAll();
        $classes = $this->manageKelasModel->getAllClassesWithMemberCount();

        $data = [
            'title' => 'Daftar Kelas',
        ];
        $data = [
            'title' => 'Dashboard',
            'jumlahArtikel' => $this->artikelModel->countAll(),
            'jumlahPengguna' => $this->manage_akunModel->countAll(),
            'artikel' => $artikelModel->findAll(), // Ambil semua artikel
            'classes' => $classes,
            'prestasi' => $prestasi,
        ];


        return view('guru/dashboard', $data);
    }

  public function indexProfil()
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    $userId = user_id();
    $profilModel = new ProfilModel();
    $user = $profilModel->getUserById($userId);

    if (!$user) {
      return redirect()->to('/login')->with('error', 'Akun tidak ditemukan.');
    }

    $data = [
      'title' => 'Profil Saya',
      'user'  => $user  // Perhatikan: kita mengirim data sebagai "user", bukan "users"
    ];

    return view('guru/profil/index', $data);
  }

  /**
   * Tampilkan form Edit Profil.
   */
  public function editProfil()
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    $userId = user_id();
    $profilModel = new ProfilModel();
    $user = $profilModel->getUserById($userId);

    if (empty($user)) {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    $data = [
      'title' => 'Edit Profil',
      'user'  => $user
    ];

    return view('guru/profil/edit', $data);
  }

  public function updateProfil()
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    $userId = user_id();
    $profilModel = new ProfilModel();
    $user = $profilModel->getUserById($userId);

    if (empty($user)) {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    // Validasi input (sesuaikan rules sesuai kebutuhan)
    $validationRules = [
      'email' => [
        'rules'  => 'required|valid_email',
        'errors' => [
          'required'    => 'Email wajib diisi.',
          'valid_email' => 'Format email tidak valid.'
        ]
      ],
      'fullname' => [
        'rules'  => 'required',
        'errors' => [
          'required' => 'Nama lengkap wajib diisi.'
        ]
      ],
      // Field new_password diizinkan kosong jika tidak ingin mengganti password
      'new_password' => [
        'rules'  => 'permit_empty|min_length[6]',
        'errors' => [
          'min_length' => 'Password minimal 6 karakter.'
        ]
      ],
      // confirm_password harus matches new_password (jika diisi)
      'confirm_password' => [
        'rules'  => 'matches[new_password]',
        'errors' => [
          'matches' => 'Konfirmasi password tidak cocok.'
        ]
      ],
      'user_image' => [
        'rules'  => 'permit_empty|is_image[user_image]|mime_in[user_image,image/jpg,image/jpeg,image/png,image/svg+xml]|max_size[user_image,2048]',
        'errors' => [
          'is_image' => 'File yang diunggah harus berupa gambar.',
          'mime_in'  => 'Format gambar harus JPG, JPEG, PNG, atau SVG.',
          'max_size' => 'Ukuran gambar tidak boleh lebih dari 5MB.'
        ]
      ]
    ];

    if (!$this->validate($validationRules)) {
      return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    // Proses perubahan password
    $oldPassword    = $this->request->getPost('old_password');
    $newPassword    = $this->request->getPost('new_password');
    $confirmPassword = $this->request->getPost('confirm_password');

    if (!empty($oldPassword)) {
      // Jika ingin mengganti password, pastikan semua field password terisi
      if (empty($newPassword) || empty($confirmPassword)) {
        return redirect()->back()->withInput()->with('error', 'Untuk mengganti password, semua field password harus diisi.');
      }
      // Verifikasi kecocokan password lama
      if (!Password::verify($oldPassword, $user['password_hash'])) {
        return redirect()->back()->withInput()->with('error', 'Password lama tidak sesuai.');
      }
      // (Rule validasi "matches[new_password]" sudah memastikan kecocokan,
      // namun dapat dilakukan double-check jika diperlukan)
      if ($newPassword !== $confirmPassword) {
        return redirect()->back()->withInput()->with('error', 'Konfirmasi password tidak cocok.');
      }
      // Hash password baru
      $hashedPassword = Password::hash($newPassword);
    } else {
      // Jika field old_password tidak diisi, maka password tidak diubah
      $hashedPassword = $user['password_hash'];
    }

    // Kumpulkan data yang akan diupdate
    $data = [
      'email'         => $this->request->getPost('email'),
      'fullname'      => $this->request->getPost('fullname'),
      'asal_sekolah'  => $this->request->getPost('asal_sekolah'),
      'kelas'         => $this->request->getPost('kelas'),
      'alamat'        => $this->request->getPost('alamat'),
      'nomor_telepon' => $this->request->getPost('nomor_telepon'),
      'password_hash' => $hashedPassword,
      'updated_at'    => date('Y-m-d H:i:s'),
    ];

    // Proses upload gambar profil baru (jika ada)
    $file = $this->request->getFile('user_image');
    if ($file && $file->isValid() && !$file->hasMoved()) {
      // Hapus gambar lama jika ada (pastikan bukan default image)
      if (!empty($user['user_image']) && file_exists(FCPATH . 'uploads/' . $user['user_image'])) {
        unlink(FCPATH . 'uploads/' . $user['user_image']);
      }
      $newFileName = $file->getRandomName();
      $file->move(FCPATH . 'uploads/', $newFileName);
      $data['user_image'] = $newFileName;
    }

    if ($profilModel->update($userId, $data)) {
      return redirect()->to('guru/profil')->with('success', 'Profil berhasil diperbarui!');
    } else {
      return redirect()->back()->withInput()->with('error', 'Gagal memperbarui profil, silakan coba lagi.');
    }
  }

  public function indexManageKelas()
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }

        // Mengambil semua kelas beserta jumlah anggota
        $classes = $this->manageKelasModel->getAllClassesWithMemberCount(); // Memanggil method untuk ambil kelas beserta jumlah anggotanya
        $data = [
            'title' => 'Daftar Kelas',
            'classes' => $classes,
        ];

        return view('guru/manage_kelas/index', $data);
    }

    // Form Tambah Kelas
    public function tambahManageKelas()
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Tambah Kelas',
        ];

        return view('guru/manage_kelas/tambah', $data);
    }

    // Simpan Kelas
    public function simpanManageKelas()
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }

        // Validasi input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama_kelas' => [
                'rules'  => 'required|min_length[3]|max_length[255]',
                'errors' => [
                    'required'   => 'Nama kelas harus diisi.',
                    'min_length' => 'Nama kelas harus memiliki minimal 3 karakter.',
                    'max_length' => 'Nama kelas tidak boleh lebih dari 255 karakter.'
                ]
            ],
            'deskripsi' => [
                'rules'  => 'permit_empty',
                'errors' => [
                    'permit_empty' => 'Deskripsi dapat dikosongkan.'
                ]
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            // Jika validasi gagal, tampilkan error
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Ambil data dari form
        $kelas_nama = $this->request->getPost('nama_kelas');
        $kelas_deskripsi = $this->request->getPost('deskripsi');
        $kelas_status = $this->request->getPost('status'); // Ambil nilai status

        // Generate kode kelas jika tidak ada
        $kelas_kode = $this->generateClassCode($kelas_nama); // Fungsi untuk membuat kode kelas otomatis

        // Siapkan data untuk disimpan
        $data = [
            'nama_kelas' => $kelas_nama,
            'deskripsi' => $kelas_deskripsi,
            'kode_kelas' => $kelas_kode,
            'status' => $kelas_status, // Simpan status sesuai input (1 untuk aktif, 0 untuk tidak aktif)
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Simpan data kelas ke database
        $this->manageKelasModel->saveKelas($data);

        // Redirect ke halaman manage kelas
        return redirect()->to('guru/manage_kelas')->with('success', 'Kelas berhasil disimpan.');
    }

    private function generateClassCode($kelas_nama)
    {
        // Ambil kata pertama dari setiap suku kata dengan mempertimbangkan huruf besar/kecil
        $words = explode(' ', strtoupper($kelas_nama)); // Ubah jadi uppercase untuk akurasi
        $code = '';

        // Ambil huruf pertama dari setiap kata
        foreach ($words as $word) {
            $code .= substr($word, 0, 1);
        }

        // Kode kelas harus terdiri dari huruf besar dan kecil, tambahkan huruf acak (besar/kecil)
        $randomChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $randomLetter = $randomChars[random_int(0, strlen($randomChars) - 1)];
        $code .= $randomLetter;

        // Tambahkan angka acak 1 digit
        $code .= random_int(0, 9); // Angka acak 1 digit

        // Jika kode kelas kurang dari 6 karakter, tambahkan huruf atau angka acak sampai 6
        while (strlen($code) < 6) {
            $randomChar = $randomChars[random_int(0, strlen($randomChars) - 1)];
            $code .= $randomChar;
        }

        // Jika kode kelas lebih dari 6 karakter, potong menjadi 6 karakter
        $code = substr($code, 0, 6);

        return $code;
    }


    // Form Edit Kelas
    public function editManageKelas($id)
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }

        $kelas = $this->manageKelasModel->find($id);
        $data = [
            'title' => 'Edit Kelas',
            'kelas' => $kelas,
        ];

        return view('guru/manage_kelas/edit', $data);
    }

    // Update Kelas
    public function updateManageKelas($id)
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }

        // Validasi input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama_kelas' => [
                'rules'  => 'required|min_length[3]|max_length[255]',
                'errors' => [
                    'required'   => 'Nama kelas harus diisi.',
                    'min_length' => 'Nama kelas harus memiliki minimal 3 karakter.',
                    'max_length' => 'Nama kelas tidak boleh lebih dari 255 karakter.'
                ]
            ],
            'deskripsi' => [
                'rules'  => 'permit_empty',
                'errors' => [
                    'permit_empty' => 'Deskripsi dapat dikosongkan.'
                ]
            ],
            'status' => [
                'rules'  => 'required',
                'errors' => [
                    'required'   => 'Status kelas harus diisi.'
                ]
            ],
        ]);

        // Cek apakah validasi gagal
        if (!$validation->withRequest($this->request)->run()) {
            // Jika validasi gagal, tampilkan error
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Ambil data dari form
        $data = [
            'nama_kelas' => $this->request->getPost('nama_kelas'),
            'deskripsi'  => $this->request->getPost('deskripsi'),
            'status'     => $this->request->getPost('status'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        try {
            // Update data kelas ke database
            $this->manageKelasModel->updateKelas($id, $data);

            // Redirect ke halaman manage kelas
            return redirect()->to('guru/manage_kelas')->with('success', 'Kelas berhasil diupdate.');
        } catch (\Exception $e) {
            // Jika terjadi error saat update data, tampilkan error
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate kelas: ' . $e->getMessage());
        }
    }

    // Hapus Kelas
    public function deleteManageKelas($id)
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }

        $this->manageKelasModel->deleteKelas($id);
        return redirect()->to('guru/manage_kelas');
    }
    public function kelola_anggotaManageKelas()
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }

        // Mengambil semua kelas beserta jumlah anggota
        $classes = $this->manageKelasModel->getAllClassesWithMemberCount();

        // Filter hanya kelas dengan status aktif (status = 1)
        $activeClasses = array_filter($classes, function ($kelas) {
            return $kelas['status'] == 1; // Pastikan tipe data sesuai (integer atau string)
        });

        $data = [
            'title'   => 'Kelola Anggota Kelas',
            'classes' => $activeClasses,
        ];

        return view('guru/manage_kelas/kelola_anggota', $data);
    }


    public function detailManageKelas($id)
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }

        // Ambil detail kelas (termasuk jumlah anggota)
        $class = $this->manageKelasModel->getClassWithMemberCountById($id);
        // Ambil data anggota kelas
        $members = $this->manageKelasModel->getAnggotaByKelas($id);

        $data = [
            'title'   => 'Detail Anggota Kelas',
            'class'   => $class,
            'members' => $members,
        ];

        return view('guru/manage_kelas/detail_kelas', $data);
    }

    public function tambah_anggotaManageKelas($id)
    {
        $manage_akunModel = new Manage_akunModel();

        $class = $this->manageKelasModel->getClassWithMemberCountById($id);

        // Ambil semua user dengan role "siswa" (role == 2)
        $users = $manage_akunModel->getAllUsersWithRoles();
        $filteredUsers = array_filter($users, function ($user) {
            return $user['role'] == 2;
        });

        // Ambil anggota yang sudah terdaftar di kelas ini
        $members = $this->manageKelasModel->getAnggotaByKelas($id);
        // Buat array dari kolom 'id_user'
        $member_ids = array_column($members, 'id_user');

        // (Opsional) Debugging: Log isi $member_ids
        log_message('debug', 'Member IDs: ' . print_r($member_ids, true));

        $data = [
            'title'      => 'Daftar Akun',
            'users'      => $filteredUsers,
            'class_id'   => $id,
            'kelas'      => $class,
            'member_ids' => $member_ids,
        ];

        return view('guru/manage_kelas/tambah_anggota', $data);
    }


    public function addMemberToClassManageKelas()
    {
        $kelasId = $this->request->getPost('kelas_id');
        $userId  = $this->request->getPost('user_id');

        $result = $this->manageKelasModel->addAnggota($kelasId, $userId);

        if ($result === 'already_joined') {
            return redirect()->to('/guru/manage_kelas/kelola_anggota/tambah/' . $kelasId)
                ->with('error', 'Akun telah bergabung di kelas ini.');
        } elseif ($result) {
            return redirect()->to('/guru/manage_kelas/kelola_anggota/tambah/' . $kelasId)
                ->with('success', 'Anggota berhasil ditambahkan.');
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan anggota.');
        }
    }

    public function hapus_anggotaManageKelas($id)
    {
        // $id di sini adalah ID record dari tabel kelas_anggota
        if ($this->manageKelasModel->removeMemberById($id)) {
            return redirect()->back()->with('success', 'Anggota berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus anggota.');
        }
    }

    public function removeMemberManageKelas($kelas_id, $user_id)
    {
        return $this->db->table('kelas_anggota')
            ->where(['kelas_id' => $kelas_id, 'user_id' => $user_id])
            ->delete();
    }

    public function indexPrestasi()
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }
    $data['title']     = 'Kelola Prestasi';
    $data['prestasis'] = $this->prestasiSertifikatModel->findAll();

    // Hanya ambil user dengan role siswa (group_id = 2)
    $data['users']     = $this->prestasiSertifikatModel->getUsersByRole(2);
    return view('guru/prestasi_sertifikat/prestasi/index', $data);
  }

  public function sertifikatDetail($sertifikatId)
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    $sertifikat = $this->sertifikatModel->getSertifikatDetailById($sertifikatId);

    if (empty($sertifikat)) {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Sertifikat tidak ditemukan.');
    }

    $data = [
      'title'      => 'Detail Sertifikat',
      'sertifikat' => $sertifikat,
    ];

    return view('guru/prestasi_sertifikat/sertifikat/detail', $data);
  }

  public function sertifikatEditPrestasi($sertifikatId)
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    // Ambil sertifikat berdasarkan ID
    $sertifikat = $this->sertifikatModel->getSertifikatById($sertifikatId);
    if (empty($sertifikat)) {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Sertifikat tidak ditemukan.');
    }

    $data = [
      'title'      => 'Edit Sertifikat',
      'sertifikat' => $sertifikat,
    ];

    return view('guru/prestasi_sertifikat/sertifikat/edit', $data);
  }

  public function sertifikatUpdatePrestasi($sertifikatId)
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    $model = new SertifikatModel();
    $sertifikat = $model->find($sertifikatId);

    if (!$sertifikat) {
      return redirect()->back()->with('error', 'Sertifikat tidak ditemukan.');
    }

    $validationRules = [
      'deskripsi' => 'required',
      'nama_file' => [
        'rules'  => 'mime_in[nama_file,image/jpg,image/jpeg,image/png,application/pdf]',
        'errors' => [
          'mime_in'  => 'File harus berupa gambar atau PDF.'
        ]
      ]
    ];

    if (!$this->validate($validationRules)) {
      return redirect()->back()
        ->withInput()
        ->with('errors', $this->validator->getErrors());
    }

    // Ambil file lama
    $oldFileNames = json_decode($sertifikat['nama_file'], true) ?? [];

    // File yang tersisa dari input hidden 'existing_files[]'
    $remainingFiles = $this->request->getPost('existing_files') ?? [];
    if (!is_array($remainingFiles)) {
      $remainingFiles = [];
    }

    // Ambil file baru
    $files = $this->request->getFiles();
    $newFiles = [];
    if (!empty($files['nama_file'])) {
      foreach ($files['nama_file'] as $file) {
        if ($file->isValid() && !$file->hasMoved()) {
          $originalName = $file->getClientName();
          $extension = $file->getExtension();
          $nameWithoutExt = pathinfo($originalName, PATHINFO_FILENAME);
          $newFileName = $nameWithoutExt . '_' . date('YmdHis') . '.' . $extension;
          $file->move(FCPATH . 'uploads/sertifikat/', $newFileName);
          $newFiles[] = $newFileName;
        }
      }
    }

    // Gabungkan file lama yang masih ada dengan file baru
    $updatedFileNames = array_merge($remainingFiles, $newFiles);

    // Hapus file yang sudah tidak ada
    $removedFiles = array_diff($oldFileNames, $updatedFileNames);
    foreach ($removedFiles as $removedFile) {
      $filePath = FCPATH . 'uploads/sertifikat/' . $removedFile;
      if (file_exists($filePath)) {
        unlink($filePath);
      }
    }

    // Update sertifikat
    $updateData = [
      'nama_file'  => json_encode($updatedFileNames),
      'deskripsi'  => $this->request->getPost('deskripsi'),
      'updated_at' => date('Y-m-d H:i:s')
    ];

    if ($model->update($sertifikatId, $updateData)) {
      return redirect()->to('guru/sertifikat')
        ->with('success', 'Sertifikat berhasil diperbarui!');
    } else {
      return redirect()->back()->withInput()->with('error', 'Gagal memperbarui sertifikat.');
    }
  }

  public function sertifikatDeletePrestasi($sertifikatId)
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    $model = new SertifikatModel();
    $sertifikat = $model->find($sertifikatId);

    if (!$sertifikat) {
      return redirect()->back()->with('error', 'Sertifikat tidak ditemukan.');
    }

    // Hapus file dari server
    $files = json_decode($sertifikat['nama_file'], true);
    if (!empty($files)) {
      foreach ($files as $file) {
        $filePath = FCPATH . 'uploads/sertifikat/' . $file;
        if (file_exists($filePath)) {
          unlink($filePath);
        }
      }
    }

    // Hapus data dari sertifikat_recipients
    $db = \Config\Database::connect();
    $db->table('sertifikat_recipients')->where('sertifikat_id', $sertifikatId)->delete();

    // Hapus sertifikat dari database
    if ($model->delete($sertifikatId)) {
      return redirect()->to('guru/sertifikat')
        ->with('success', 'Sertifikat berhasil dihapus.');
    } else {
      return redirect()->back()->with('error', 'Gagal menghapus sertifikat.');
    }
  }

  public function prestasiDetailPrestasi($user_id)
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

    return view('guru/prestasi_sertifikat/prestasi/prestasi_user', $data);
  }


  // Menampilkan form tambah prestasi untuk user tertentu
  public function prestasiDetailTambahPrestasi($userId)
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

    return view('guru/prestasi_sertifikat/prestasi/prestasi_user_tambah', $data);
  }

  public function prestasiDetailSimpanPrestasi()
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
    return redirect()->to(base_url('guru/prestasi/prestasi_detail/' . esc($post['user_id'])));
  }

  public function prestasiDetailInfoPrestasi($user_id, $prestasiId)
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

    return view('guru/prestasi_sertifikat/prestasi/prestasi_user_info', $data);
  }


  // Menampilkan form edit prestasi
  public function prestasiDetailEditPrestasi($userId, $prestasiId)
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

    return view('guru/prestasi_sertifikat/prestasi/prestasi_user_edit', $data);
  }

  // Memproses update data prestasi (POST)
  public function prestasiDetailUpdatePrestasi($userId, $prestasiId)
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
    return redirect()->to(base_url('guru/prestasi/prestasi_detail/' . esc($userId)));
  }

  // Menghapus prestasi dan data relasinya di pivot table
  public function prestasiDetailDeletePrestasi($prestasi_id)
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

  public function prestasiInfoPrestasi($prestasiId)
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

    return view('guru/prestasi_sertifikat/prestasi/prestasi_info', $data);
  }
  // Menampilkan form tambah prestasi untuk user tertentu
  public function prestasiTambahPrestasi()
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    $users = $this->prestasiSertifikatModel->getUsersByRole('2');

    $data = [
      'title' => 'Tambah Prestasi',
      'users' => $users,
    ];

    return view('guru/prestasi_sertifikat/prestasi/prestasi_tambah', $data);
  }
  public function prestasiSimpanPrestasi()
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
    return redirect()->to(base_url('guru/prestasi'));
  }


  // Menampilkan form edit prestasi
  public function prestasiEditPrestasi($prestasiId)
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

    return view('guru/prestasi_sertifikat/prestasi/prestasi_edit', $data);
  }

  public function prestasiUpdatePrestasi($prestasiId)
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
    return redirect()->to(base_url('guru/prestasi'));
  }


  public function prestasiDeletePrestasi($prestasiId)
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
  
  public function gradeIndexPrestasi()
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

    return view('guru/prestasi_sertifikat/grade_level/index', $data);
  }


  // Menampilkan detail kelas (termasuk data gambar dari tabel pivot grade_images)
  public function gradeDetailPrestasi($id)
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

    return view('guru/prestasi_sertifikat/grade_level/kelas_detail', $data);
  }

  public function gradeLevelPrestasi($id)
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    $class = $this->manageKelasModel->getClassWithMemberCountById($id);

    $data = [
      'title'   => 'Edit Level Kelas ' . $class['nama_kelas'],
      'kelas'   => $class,
    ];

    return view('guru/prestasi_sertifikat/grade_level/kelas_level', $data);
  }


  // Memproses update data kelas (hanya menyimpan level dan sub_level)
  public function gradeLevelUpdatePrestasi($id)
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

    return redirect()->to(base_url('guru/grade_level'))
      ->with('success', 'Level kelas berhasil diperbarui.');
  }

  // Menampilkan daftar proyek berdasarkan ID kelas
  public function gradeProyekPrestasi($kelas_id)
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

    return view('guru/prestasi_sertifikat/grade_level/kelas_proyek', $data);
  }

  // Menampilkan form tambah proyek berdasarkan ID kelas
  public function gradeProyekTambahPrestasi($kelas_id)
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    $kelas = $this->manageKelasModel->find($kelas_id);

    $data = [
      'title' => 'Tambah Proyek',
      'kelas' => $kelas,
    ];

    return view('guru/prestasi_sertifikat/grade_level/kelas_proyek_tambah', $data);
  }

  public function gradeProyekSimpanPrestasi($kelas_id)
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    $validationRules = [
      'deskripsi' => 'required',
      'image_name' => [
        'rules'  => 'permit_empty|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/svg+xml]',
        'errors' => [
          'is_image' => 'File harus berupa gambar.',
          'mime_in'  => 'Format gambar harus JPG, JPEG, PNG, atau SVG.',
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
      return redirect()->to('guru/grade_level/proyek/' . $kelas_id)->with('success', 'Proyek berhasil ditambahkan!');
    } else {
      return redirect()->back()->withInput()->with('error', 'Gagal menyimpan proyek.');
    }
  }

  public function gradeProyekEditPrestasi($kelas_id, $proyek_id)
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

    return view('guru/prestasi_sertifikat/grade_level/kelas_proyek_edit', $data);
  }


  public function gradeProyekUpdatePrestasi($kelas_id)
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    // Validasi file gambar
    $validationRules = [
      'gambar' => [
        'rules'  => 'uploaded[gambar]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/svg+xml]',
        'errors' => [
          'uploaded' => 'Gambar harus diunggah.',
          'is_image' => 'File harus berupa gambar.',
          'mime_in'  => 'Format gambar harus JPG, JPEG, PNG, atau SVG.',
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
        return redirect()->to('guru/grade_level/proyek/' . $kelas_id)->with('success', 'Gambar berhasil diunggah!');
      } else {
        return redirect()->back()->withInput()->with('error', 'Gagal menyimpan gambar ke database.');
      }
    } else {
      return redirect()->back()->withInput()->with('error', 'Gagal mengunggah gambar.');
    }
  }

  public function gradeProyekDeletePrestasi($kelas_id, $proyek_id)
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    $proyek = $this->gradeImagesModel->where(['id' => $proyek_id, 'kelas_id' => $kelas_id])->first();

    if ($proyek) {
      $this->gradeImagesModel->delete($proyek_id);
      return redirect()->to('guru/grade_level/proyek/' . $kelas_id)->with('success', 'Proyek berhasil dihapus');
    }

    return redirect()->to('guru/grade_level/proyek/' . $kelas_id)->with('error', 'Proyek tidak ditemukan');
  }

  public function sertifikatIndexSertifikat()
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }
    $data['title']     = 'Kelola Sertifikat';
    $data['sertifikats'] = $this->sertifikatModel->getAllSertifikats();
    $data['prestasis'] = $this->prestasiSertifikatModel->findAll();

    $data['kelas'] = $this->manageKelasModel->findAll();
    // Hanya ambil user dengan role siswa (group_id = 2)
    $data['users']     = $this->prestasiSertifikatModel->getUsersByRole(2);
    return view('guru/prestasi_sertifikat/sertifikat/index', $data);
  }

  public function sertifikatPrestasiDetailPrestasi($prestasiId)
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }
    // Ambil data user berdasarkan user_id

    $prestasi = $this->prestasiSertifikatModel->findPrestasiById($prestasiId);
    if (!$prestasi) {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Prestasi tidak ditemukan.');
    }

    $sertifikat = $this->sertifikatModel->getSertifikatByPrestasi($prestasiId);

    $data = [
      'title'     => 'Sertifikat Prestasi ',
      'prestasi' => $prestasi,
      'sertifikat' => $sertifikat,
    ];

    return view('guru/prestasi_sertifikat/sertifikat/sertifprestasi', $data);
  }



  // Menampilkan form tambah prestasi untuk user tertentu
  public function sertifikatPrestasiTambahSertifikat($prestasiId)
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    $prestasi = $this->prestasiSertifikatModel->findPrestasiById($prestasiId);
    if (!$prestasi) {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Prestasi tidak ditemukan.');
    }

    $data = [
      'title' => 'Tambah Sertifikat ',
      'prestasi'  => $prestasi,
    ];

    return view('guru/prestasi_sertifikat/sertifikat/sertifprestasi_tambah', $data);
  }

  public function sertifikatPrestasiSimpanSertifikat($prestasiId)
  {
    // Pastikan user sudah login
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    // Validasi input:
    // - Field deskripsi wajib diisi.
    // - File (nama_file) wajib diupload, maksimal 2MB, hanya boleh gambar (JPG, JPEG, PNG) atau PDF.
    // Catatan: meskipun form menggunakan multiple file (nama_file[]), validasi dapat diterapkan per file.
    $validationRules = [
      'deskripsi' => 'required',
      'nama_file' => [
        'rules'  => 'uploaded[nama_file]|mime_in[nama_file,image/jpg,image/jpeg,image/png,application/pdf]',
        'errors' => [
          'uploaded' => 'Harus ada file yang diupload.',
          'mime_in'  => 'File harus berupa gambar atau PDF.'
        ]
      ]
    ];

    if (!$this->validate($validationRules)) {
      return redirect()->back()
        ->withInput()
        ->with('errors', $this->validator->getErrors());
    }

    $files = $this->request->getFiles();
    $savedFileNames = [];

    foreach ($files['nama_file'] as $file) {
      if ($file->isValid() && !$file->hasMoved()) {
        // Ambil nama file asli dan ekstensi
        $originalName = $file->getClientName();
        $extension = $file->getExtension(); // Mendapatkan ekstensi file

        // Hilangkan ekstensi dari nama file asli
        $nameWithoutExt = pathinfo($originalName, PATHINFO_FILENAME);

        $newFileName = $nameWithoutExt . '_' . date('YmdHis') . '.' . $extension;

        // Pindahkan file ke folder tujuan dengan nama yang sudah dimodifikasi
        $file->move(FCPATH . 'uploads/sertifikat/', $newFileName);
        $savedFileNames[] = $newFileName;
      }
    }


    $sertifikatData = [
      'nama_file' => json_encode($savedFileNames),
      'deskripsi' => $this->request->getPost('deskripsi'),
      'kategori'  => 'prestasi',
    ];

    $model = new SertifikatModel();

    // Insert data sertifikat
    if ($model->insert($sertifikatData)) {
      $sertifikatId = $model->getInsertID();

      // Siapkan data pivot untuk tabel sertifikat_recipients
      $dataRecipient = [
        'sertifikat_id' => $sertifikatId,
        'target_type'   => 'prestasi',
        'target_id'     => $prestasiId,
        'created_at'    => date('Y-m-d H:i:s'),
        'updated_at'    => date('Y-m-d H:i:s'),
      ];

      // Insert data pivot menggunakan query builder
      $db = \Config\Database::connect();
      $builder = $db->table('sertifikat_recipients');
      if ($builder->insert($dataRecipient)) {
        return redirect()->to('guru/sertifikat/prestasi/' . esc($prestasiId))->with('success', 'Sertifikat berhasil ditambahkan!');
      } else {
        // Jika pivot gagal, hapus data sertifikat yang sudah tersimpan (opsional)
        $model->delete($sertifikatId);
        return redirect()->back()->withInput()->with('error', 'Gagal menyimpan penerima sertifikat.');
      }
    } else {
      return redirect()->back()->withInput()->with('error', 'Gagal menyimpan sertifikat.');
    }
  }

  public function sertifikatPrestasiEditSertifikat($prestasiId, $sertifikatId)
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    $model = new SertifikatModel();
    $sertifikat = $model->getSertifikatByPrestasi($prestasiId);

    // Pastikan hanya mengambil sertifikat yang sesuai dengan ID prestasi dan ID sertifikat
    $sertifikat = array_filter($sertifikat, function ($s) use ($sertifikatId) {
      return $s['id'] == $sertifikatId;
    });

    if (empty($sertifikat)) {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Sertifikat tidak ditemukan.');
    }

    $data = [
      'title'      => 'Edit Sertifikat Prestasi',
      'sertifikat' => reset($sertifikat), // Ambil satu sertifikat yang cocok
      'prestasiId' => $prestasiId,
    ];

    return view('guru/prestasi_sertifikat/sertifikat/sertifprestasi_edit', $data);
  }

  public function sertifikatPrestasiUpdateSertifikat($prestasiId, $sertifikatId)
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    $model = new SertifikatModel();
    $sertifikat = $model->find($sertifikatId);

    // Pastikan sertifikat terkait dengan prestasi yang benar
    if (!$sertifikat || !$model->getSertifikatByPrestasi($prestasiId)) {
      return redirect()->back()->with('error', 'Sertifikat tidak ditemukan atau tidak sesuai dengan prestasi.');
    }

    $validationRules = [
      'deskripsi' => 'required',
      'nama_file' => [
        'rules'  => 'mime_in[nama_file,image/jpg,image/jpeg,image/png,application/pdf]',
        'errors' => [
          'mime_in'  => 'File harus berupa gambar atau PDF.'
        ]
      ]
    ];

    if (!$this->validate($validationRules)) {
      return redirect()->back()
        ->withInput()
        ->with('errors', $this->validator->getErrors());
    }

    // Ambil file lama yang tersimpan (dari database)
    $oldFileNames = json_decode($sertifikat['nama_file'], true) ?? [];

    // Ambil file yang tersisa (dari input hidden)
    $remainingFiles = $this->request->getPost('existing_files');
    if (!is_array($remainingFiles)) {
      $remainingFiles = [];
    }

    // Ambil file baru yang diupload
    $files = $this->request->getFiles();
    $newFiles = [];
    if (!empty($files['nama_file'])) {
      foreach ($files['nama_file'] as $file) {
        if ($file->isValid() && !$file->hasMoved()) {
          $originalName = $file->getClientName();
          $extension = $file->getExtension();
          $nameWithoutExt = pathinfo($originalName, PATHINFO_FILENAME);
          $newFileName = $nameWithoutExt . '_' . date('YmdHis') . '.' . $extension;
          $file->move(FCPATH . 'uploads/sertifikat/', $newFileName);
          $newFiles[] = $newFileName;
        }
      }
    }

    // File baru yang akan disimpan adalah gabungan file yang masih ada dan file baru yang diupload
    $updatedFileNames = array_merge($remainingFiles, $newFiles);

    // Cari file yang telah dihapus: file yang sebelumnya ada tapi tidak dikirim kembali melalui form
    $removedFiles = array_diff($oldFileNames, $updatedFileNames);
    foreach ($removedFiles as $removedFile) {
      $filePath = FCPATH . 'uploads/sertifikat/' . $removedFile;
      if (file_exists($filePath)) {
        unlink($filePath);
      }
    }

    // Siapkan data untuk update
    $updateData = [
      'nama_file' => json_encode($updatedFileNames),
      'deskripsi' => $this->request->getPost('deskripsi'),
      'updated_at' => date('Y-m-d H:i:s')
    ];

    if ($model->update($sertifikatId, $updateData)) {
      return redirect()->to('guru/sertifikat/prestasi/' . esc($prestasiId))
        ->with('success', 'Sertifikat berhasil diperbarui!');
    } else {
      return redirect()->back()->withInput()->with('error', 'Gagal memperbarui sertifikat.');
    }
  }

  public function sertifikatPrestasiDeleteSertifikat($prestasiId, $sertifikatId)
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    $model = new SertifikatModel();
    $sertifikat = $model->find($sertifikatId);

    // Pastikan sertifikat terkait dengan prestasi yang benar
    if (!$sertifikat || !$model->getSertifikatByPrestasi($prestasiId)) {
      return redirect()->back()->with('error', 'Sertifikat tidak ditemukan atau tidak sesuai dengan prestasi.');
    }

    // Hapus file dari server
    $files = json_decode($sertifikat['nama_file'], true);
    if (!empty($files)) {
      foreach ($files as $file) {
        $filePath = FCPATH . 'uploads/sertifikat/' . $file;
        if (file_exists($filePath)) {
          unlink($filePath);
        }
      }
    }

    // Hapus data dari tabel pivot sertifikat_recipients
    $db = \Config\Database::connect();
    $db->table('sertifikat_recipients')->where('sertifikat_id', $sertifikatId)->delete();

    // Hapus sertifikat dari database
    if ($model->delete($sertifikatId)) {
      return redirect()->to('guru/sertifikat/prestasi/' . esc($prestasiId))
        ->with('success', 'Sertifikat berhasil dihapus.');
    } else {
      return redirect()->back()->with('error', 'Gagal menghapus sertifikat.');
    }
  }

  public function sertifikatAkunDetailSertifikat($userId)
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    $user = $this->userModel->find($userId);
    if (!$user) {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('User tidak ditemukan.');
    }

    $sertifikat = $this->sertifikatModel->getSertifikatByUser($userId);

    $data = [
      'title'      => 'Sertifikat Akun',
      'user'       => $user,
      'sertifikat' => $sertifikat,
    ];

    return view('guru/prestasi_sertifikat/sertifikat/sertifakun', $data);
  }

  // Menampilkan Form Tambah Sertifikat untuk Akun
  public function sertifikatAkunTambahSertifikat($userId)
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    $user = $this->userModel->find($userId);
    if (!$user) {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('User tidak ditemukan.');
    }

    $data = [
      'title' => 'Tambah Sertifikat Akun',
      'user'  => $user,
    ];

    return view('guru/prestasi_sertifikat/sertifikat/sertifakun_tambah', $data);
  }

  // Proses Simpan Sertifikat untuk Akun
  public function sertifikatAkunSimpanSertifikat($userId)
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    $validationRules = [
      'deskripsi' => 'required',
      'nama_file' => [
        'rules'  => 'uploaded[nama_file]|mime_in[nama_file,image/jpg,image/jpeg,image/png,application/pdf]',
        'errors' => [
          'uploaded' => 'Harus ada file yang diupload.',
          'mime_in'  => 'File harus berupa gambar atau PDF.'
        ]
      ]
    ];

    if (!$this->validate($validationRules)) {
      return redirect()->back()
        ->withInput()
        ->with('errors', $this->validator->getErrors());
    }

    $files = $this->request->getFiles();
    $savedFileNames = [];

    foreach ($files['nama_file'] as $file) {
      if ($file->isValid() && !$file->hasMoved()) {
        $originalName = $file->getClientName();
        $extension    = $file->getExtension();
        $nameWithoutExt = pathinfo($originalName, PATHINFO_FILENAME);
        $newFileName  = $nameWithoutExt . '_' . date('YmdHis') . '.' . $extension;
        $file->move(FCPATH . 'uploads/sertifikat/', $newFileName);
        $savedFileNames[] = $newFileName;
      }
    }

    $sertifikatData = [
      'nama_file' => json_encode($savedFileNames),
      'deskripsi' => $this->request->getPost('deskripsi'),
      'kategori'  => 'users',
    ];

    if ($this->sertifikatModel->insert($sertifikatData)) {
      $sertifikatId = $this->sertifikatModel->getInsertID();

      // Simpan data pivot ke tabel sertifikat_recipients
      $dataRecipient = [
        'sertifikat_id' => $sertifikatId,
        'target_type'   => 'users',
        'target_id'     => $userId,
        'created_at'    => date('Y-m-d H:i:s'),
        'updated_at'    => date('Y-m-d H:i:s'),
      ];

      $db = \Config\Database::connect();
      $builder = $db->table('sertifikat_recipients');
      if ($builder->insert($dataRecipient)) {
        return redirect()->to('guru/sertifikat/akun/' . esc($userId))
          ->with('success', 'Sertifikat berhasil ditambahkan!');
      } else {
        // Jika pivot gagal, hapus data sertifikat yang sudah tersimpan (opsional)
        $this->sertifikatModel->delete($sertifikatId);
        return redirect()->back()->withInput()->with('error', 'Gagal menyimpan penerima sertifikat.');
      }
    } else {
      return redirect()->back()->withInput()->with('error', 'Gagal menyimpan sertifikat.');
    }
  }

  // Menampilkan Form Edit Sertifikat untuk Akun
  public function sertifikatAkunEditSertifikat($userId, $sertifikatId)
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    $user = $this->userModel->find($userId);
    if (!$user) {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('User tidak ditemukan.');
    }

    // Ambil sertifikat berdasarkan user_id
    $sertifikatList = $this->sertifikatModel->getSertifikatByUser($userId);
    // Filter sertifikat yang sesuai dengan sertifikatId
    $sertifikatArr = array_filter($sertifikatList, function ($s) use ($sertifikatId) {
      return $s['id'] == $sertifikatId;
    });

    if (empty($sertifikatArr)) {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Sertifikat tidak ditemukan.');
    }

    $data = [
      'title'      => 'Edit Sertifikat Akun',
      'sertifikat' => reset($sertifikatArr),
      'user'       => $user,
    ];

    return view('guru/prestasi_sertifikat/sertifikat/sertifakun_edit', $data);
  }

  // Proses Update Sertifikat untuk Akun
  public function sertifikatAkunUpdateSertifikat($userId, $sertifikatId)
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    $model = new SertifikatModel();
    $sertifikat = $model->find($sertifikatId);

    // Pastikan sertifikat terkait dengan akun yang benar
    if (!$sertifikat || !$model->getSertifikatByUser($userId)) {
      return redirect()->back()->with('error', 'Sertifikat tidak ditemukan atau tidak sesuai dengan akun.');
    }

    $validationRules = [
      'deskripsi' => 'required',
      'nama_file' => [
        'rules'  => 'mime_in[nama_file,image/jpg,image/jpeg,image/png,application/pdf]',
        'errors' => [
          'mime_in'  => 'File harus berupa gambar atau PDF.'
        ]
      ]
    ];

    if (!$this->validate($validationRules)) {
      return redirect()->back()
        ->withInput()
        ->with('errors', $this->validator->getErrors());
    }

    // Ambil file lama yang tersimpan (dari database)
    $oldFileNames = json_decode($sertifikat['nama_file'], true) ?? [];

    // Ambil file yang tersisa (dari input hidden 'existing_files[]')
    $remainingFiles = $this->request->getPost('existing_files');
    if (!is_array($remainingFiles)) {
      $remainingFiles = [];
    }

    // Ambil file baru yang diupload
    $files = $this->request->getFiles();
    $newFiles = [];
    if (!empty($files['nama_file'])) {
      foreach ($files['nama_file'] as $file) {
        if ($file->isValid() && !$file->hasMoved()) {
          $originalName = $file->getClientName();
          $extension = $file->getExtension();
          $nameWithoutExt = pathinfo($originalName, PATHINFO_FILENAME);
          $newFileName = $nameWithoutExt . '_' . date('YmdHis') . '.' . $extension;
          $file->move(FCPATH . 'uploads/sertifikat/', $newFileName);
          $newFiles[] = $newFileName;
        }
      }
    }

    // Gabungkan file lama yang masih ada dan file baru
    $updatedFileNames = array_merge($remainingFiles, $newFiles);

    // Cari file yang telah dihapus: file yang sebelumnya ada tapi tidak dikirim melalui form
    $removedFiles = array_diff($oldFileNames, $updatedFileNames);
    foreach ($removedFiles as $removedFile) {
      $filePath = FCPATH . 'uploads/sertifikat/' . $removedFile;
      if (file_exists($filePath)) {
        unlink($filePath);
      }
    }

    $updateData = [
      'nama_file' => json_encode($updatedFileNames),
      'deskripsi' => $this->request->getPost('deskripsi'),
      'updated_at' => date('Y-m-d H:i:s')
    ];

    if ($model->update($sertifikatId, $updateData)) {
      return redirect()->to('guru/sertifikat/akun/' . esc($userId))
        ->with('success', 'Sertifikat berhasil diperbarui!');
    } else {
      return redirect()->back()->withInput()->with('error', 'Gagal memperbarui sertifikat.');
    }
  }
  public function sertifikatAkunDeletePrestasi($userId, $sertifikatId)
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    $model = new SertifikatModel();
    $sertifikat = $model->find($sertifikatId);

    // Pastikan sertifikat terkait dengan akun yang benar
    if (!$sertifikat || !$model->getSertifikatByUser($userId)) {
      return redirect()->back()->with('error', 'Sertifikat tidak ditemukan atau tidak sesuai dengan akun.');
    }

    // Hapus file dari server
    $files = json_decode($sertifikat['nama_file'], true);
    if (!empty($files)) {
      foreach ($files as $file) {
        $filePath = FCPATH . 'uploads/sertifikat/' . $file;
        if (file_exists($filePath)) {
          unlink($filePath);
        }
      }
    }

    // Hapus data dari tabel pivot sertifikat_recipients
    $db = \Config\Database::connect();
    $db->table('sertifikat_recipients')->where('sertifikat_id', $sertifikatId)->delete();

    // Hapus sertifikat dari database
    if ($model->delete($sertifikatId)) {
      return redirect()->to('guru/sertifikat/akun/' . esc($userId))
        ->with('success', 'Sertifikat berhasil dihapus.');
    } else {
      return redirect()->back()->with('error', 'Gagal menghapus sertifikat.');
    }
  }

  //===============================================================================//
  //Sertifikat Akun Selesai
  //===============================================================================//
  //===============================================================================//
  //===============================================================================//


  //===============================================================================//
  //===============================================================================//
  //===============================================================================//
  //Sertifikat Kelas Mulai
  //===============================================================================//
  public function sertifikatKelasDetailSertifikat($kelasId)
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    $kelas = $this->manageKelasModel->getClassById($kelasId);
    if (!$kelas) {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Kelas tidak ditemukan.');
    }

    $sertifikat = $this->sertifikatModel->getSertifikatByKelas($kelasId);

    $data = [
      'title'      => 'Sertifikat Kelas',
      'kelas'       => $kelas,
      'sertifikat' => $sertifikat,
    ];

    return view('guru/prestasi_sertifikat/sertifikat/sertifkelas', $data);
  }

  // Menampilkan Form Tambah Sertifikat untuk Akun
  public function sertifikatKelasTambahPrestasi($kelasId)
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    $kelas = $this->manageKelasModel->find($kelasId);
    if (!$kelas) {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Kelas tidak ditemukan.');
    }

    $data = [
      'title' => 'Tambah Sertifikat Kelas',
      'kelas'  => $kelas,
    ];

    return view('guru/prestasi_sertifikat/sertifikat/sertifkelas_tambah', $data);
  }

  // Proses Simpan Sertifikat untuk Kelas
  public function sertifikatKelasSimpanSertifikat($kelasId)
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    $validationRules = [
      'deskripsi' => 'required',
      'nama_file' => [
        'rules'  => 'uploaded[nama_file]|mime_in[nama_file,image/jpg,image/jpeg,image/png,application/pdf]',
        'errors' => [
          'uploaded' => 'Harus ada file yang diupload.',
          'mime_in'  => 'File harus berupa gambar atau PDF.'
        ]
      ]
    ];

    if (!$this->validate($validationRules)) {
      return redirect()->back()
        ->withInput()
        ->with('errors', $this->validator->getErrors());
    }

    $files = $this->request->getFiles();
    $savedFileNames = [];

    foreach ($files['nama_file'] as $file) {
      if ($file->isValid() && !$file->hasMoved()) {
        $originalName = $file->getClientName();
        $extension    = $file->getExtension();
        $nameWithoutExt = pathinfo($originalName, PATHINFO_FILENAME);
        $newFileName  = $nameWithoutExt . '_' . date('YmdHis') . '.' . $extension;
        $file->move(FCPATH . 'uploads/sertifikat/', $newFileName);
        $savedFileNames[] = $newFileName;
      }
    }

    $sertifikatData = [
      'nama_file' => json_encode($savedFileNames),
      'deskripsi' => $this->request->getPost('deskripsi'),
      'kategori'  => 'kelas',
    ];

    if ($this->sertifikatModel->insert($sertifikatData)) {
      $sertifikatId = $this->sertifikatModel->getInsertID();

      // Simpan data pivot ke tabel sertifikat_recipients
      $dataRecipient = [
        'sertifikat_id' => $sertifikatId,
        'target_type'   => 'manage_kelas',
        'target_id'     => $kelasId,
        'created_at'    => date('Y-m-d H:i:s'),
        'updated_at'    => date('Y-m-d H:i:s'),
      ];

      $db = \Config\Database::connect();
      $builder = $db->table('sertifikat_recipients');
      if ($builder->insert($dataRecipient)) {
        return redirect()->to('guru/sertifikat/kelas/' . esc($kelasId))
          ->with('success', 'Sertifikat berhasil ditambahkan!');
      } else {
        // Jika pivot gagal, hapus data sertifikat yang sudah tersimpan (opsional)
        $this->sertifikatModel->delete($sertifikatId);
        return redirect()->back()->withInput()->with('error', 'Gagal menyimpan penerima sertifikat.');
      }
    } else {
      return redirect()->back()->withInput()->with('error', 'Gagal menyimpan sertifikat.');
    }
  }

  // Menampilkan Form Edit Sertifikat untuk Kelas
  public function sertifikatKelasEditSertifikat($kelasId, $sertifikatId)
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    $kelas = $this->manageKelasModel->find($kelasId);
    if (!$kelasId) {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('User tidak ditemukan.');
    }

    // Ambil sertifikat berdasarkan kelas_id
    $sertifikatList = $this->sertifikatModel->getSertifikatByKelas($kelasId);
    // Filter sertifikat yang sesuai dengan sertifikatId
    $sertifikatArr = array_filter($sertifikatList, function ($s) use ($sertifikatId) {
      return $s['id'] == $sertifikatId;
    });

    if (empty($sertifikatArr)) {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Sertifikat tidak ditemukan.');
    }

    $data = [
      'title'      => 'Edit Sertifikat Kelas',
      'sertifikat' => reset($sertifikatArr),
      'kelas'       => $kelas,
    ];

    return view('guru/prestasi_sertifikat/sertifikat/sertifkelas_edit', $data);
  }

  // Proses Update Sertifikat untuk Kelas
  public function sertifikatKelasUpdateSertifikat($kelasId, $sertifikatId)
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    $model = new SertifikatModel();
    $sertifikat = $model->find($sertifikatId);

    // Pastikan sertifikat terkait dengan akun yang benar
    if (!$sertifikat || !$model->getSertifikatByKelas($kelasId)) {
      return redirect()->back()->with('error', 'Sertifikat tidak ditemukan atau tidak sesuai dengan akun.');
    }

    $validationRules = [
      'deskripsi' => 'required',
      'nama_file' => [
        'rules'  => 'mime_in[nama_file,image/jpg,image/jpeg,image/png,application/pdf]',
        'errors' => [
          'mime_in'  => 'File harus berupa gambar atau PDF.'
        ]
      ]
    ];

    if (!$this->validate($validationRules)) {
      return redirect()->back()
        ->withInput()
        ->with('errors', $this->validator->getErrors());
    }

    // Ambil file lama yang tersimpan (dari database)
    $oldFileNames = json_decode($sertifikat['nama_file'], true) ?? [];

    // Ambil file yang tersisa (dari input hidden 'existing_files[]')
    $remainingFiles = $this->request->getPost('existing_files');
    if (!is_array($remainingFiles)) {
      $remainingFiles = [];
    }

    // Ambil file baru yang diupload
    $files = $this->request->getFiles();
    $newFiles = [];
    if (!empty($files['nama_file'])) {
      foreach ($files['nama_file'] as $file) {
        if ($file->isValid() && !$file->hasMoved()) {
          $originalName = $file->getClientName();
          $extension = $file->getExtension();
          $nameWithoutExt = pathinfo($originalName, PATHINFO_FILENAME);
          $newFileName = $nameWithoutExt . '_' . date('YmdHis') . '.' . $extension;
          $file->move(FCPATH . 'uploads/sertifikat/', $newFileName);
          $newFiles[] = $newFileName;
        }
      }
    }

    // Gabungkan file lama yang masih ada dan file baru
    $updatedFileNames = array_merge($remainingFiles, $newFiles);

    // Cari file yang telah dihapus: file yang sebelumnya ada tapi tidak dikirim melalui form
    $removedFiles = array_diff($oldFileNames, $updatedFileNames);
    foreach ($removedFiles as $removedFile) {
      $filePath = FCPATH . 'uploads/sertifikat/' . $removedFile;
      if (file_exists($filePath)) {
        unlink($filePath);
      }
    }

    $updateData = [
      'nama_file' => json_encode($updatedFileNames),
      'deskripsi' => $this->request->getPost('deskripsi'),
      'updated_at' => date('Y-m-d H:i:s')
    ];

    if ($model->update($sertifikatId, $updateData)) {
      return redirect()->to('guru/sertifikat/kelas/' . esc($kelasId))
        ->with('success', 'Sertifikat berhasil diperbarui!');
    } else {
      return redirect()->back()->withInput()->with('error', 'Gagal memperbarui sertifikat.');
    }
  }

  public function sertifikatKelasDeleteSertifikat($kelasId, $sertifikatId)
  {
    if (!logged_in()) {
      return redirect()->to('/login');
    }

    $sertifikatModel = new SertifikatModel();
    $sertifikat = $sertifikatModel->find($sertifikatId);

    // Pastikan sertifikat terkait dengan kelas yang benar
    if (!$sertifikat || !$sertifikatModel->getSertifikatByKelas($kelasId)) {
      return redirect()->back()->with('error', 'Sertifikat tidak ditemukan atau tidak sesuai dengan akun.');
    }

    // Hapus file dari server
    $files = json_decode($sertifikat['nama_file'], true);
    if (!empty($files)) {
      foreach ($files as $file) {
        $filePath = FCPATH . 'uploads/sertifikat/' . $file;
        if (file_exists($filePath)) {
          unlink($filePath);
        }
      }
    }

    // Gunakan transaksi untuk memastikan integritas data
    $db = \Config\Database::connect();
    $db->transStart();

    // Hapus data di tabel pivot sertifikat_recipients yang terkait
    $db->table('sertifikat_recipients')->where('sertifikat_id', $sertifikatId)->delete();

    // Hapus sertifikat dari tabel utama
    $sertifikatModel->delete($sertifikatId);

    $db->transComplete();

    if ($db->transStatus() === false) {
      return redirect()->back()->with('error', 'Gagal menghapus sertifikat.');
    }

    return redirect()->to('guru/sertifikat/kelas/' . esc($kelasId))
      ->with('success', 'Sertifikat berhasil dihapus.');
  }
}
