<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Manage_akunModel;
use Myth\Auth\Models\UserModel;
use Myth\Auth\Password;

class Manage_akunController extends BaseController
{
    // protected $artikelModel;
    // public function __construct()
    // {
    //     $this->artikelModel = new ArtikelModel();
    // }

    public function index()
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }

        $manage_akunModel = new Manage_akunModel();
        $users = $manage_akunModel->getAllUsersWithRoles();

        $data = [
            'title' => 'Daftar Akun',
            'users' => $users,
        ];

        return view('admin/manage_akun/index', $data);
    }

    public function updateRole()
    {
        if ($this->request->isAJAX()) {
            $userId = $this->request->getPost('id');
            $newRole = $this->request->getPost('role');

            $manage_akunModel = new Manage_akunModel();
            $update = $manage_akunModel->updateUserRole($userId, $newRole);

            if ($update) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Role berhasil diperbarui']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal memperbarui role']);
            }
        }
    }

    public function tambah()
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Tambah Akun',
        ];

        return view('admin/manage_akun/tambah', $data);
    }

    public function simpan()
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }

        $users = model(UserModel::class);
        $userModel = new UserModel();
        $manage_akunModel = new Manage_akunModel();

        $role = $this->request->getPost('role');
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');

        // Jika email kosong, buat email dari username
        if (empty($email)) {
            $email = strtolower($username) . '@gmail.com';

            // Cek apakah email sudah ada di database
            while ($users->where('email', $email)->countAllResults() > 0) {
                // Jika email sudah ada, tambahkan angka acak agar unik
                $email = strtolower($username) . rand(100, 999) . '@gmail.com';
            }
        }

        $rules = [
            'username' => 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username]',
            'password' => 'required',
            'confirm_password' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $file = $this->request->getFile('user_image');
        $fileName = 'profil_devault.svg';

        if ($file->isValid() && !$file->hasMoved()) {
            // Validasi jenis file (hanya menerima JPG, PNG, SVG)
            $allowedTypes = ['image/jpeg', 'image/png', 'image/svg+xml'];
            if (!in_array($file->getMimeType(), $allowedTypes)) {
                return redirect()->back()->withInput()->with('error', 'Format file tidak diizinkan. Hanya JPG, PNG, dan SVG yang diperbolehkan.');
            }

            // Validasi ukuran file (maksimal 2MB)
            if ($file->getSize() > 2 * 1024 * 1024) {
                return redirect()->back()->withInput()->with('error', 'Ukuran file terlalu besar. Maksimum 2MB.');
            }

            // Generate nama file acak dan simpan
            $fileName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/', $fileName);
            $data['gambar'] = $fileName;
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal mengunggah gambar.');
        }

        // Hash password sebelum disimpan
        $hashedPassword = Password::hash($this->request->getPost('password'));

        // Buat data user
        $data = [
            'username'   => $username,
            'email'      => $email,
            'password_hash'   => $hashedPassword,
            'fullname'   => $this->request->getPost('fullname'),
            'user_image' => $fileName,
            'active'     => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];


        // Simpan user baru ke database
        if ($userModel->insert($data)) {
            $userId = $userModel->getInsertID(); // Ambil ID user yang baru dibuat

            // Ambil role yang dipilih dari form
            $role = $this->request->getPost('role');

            // Jika role valid (misal: 1 = Admin, 2 = Moderator, 3 = User)
            if (in_array($role, [1, 2, 3])) {
                $groupModel = new Manage_akunModel();
                $groupModel->updateUserRole($userId, $role);
            }

            return redirect()->to('/admin/manage_akun')->with('success', 'Akun berhasil ditambahkan dan role diberikan.');
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan akun.');
        }

        return redirect()->to('/admin/manage_akun')->with('success', 'Akun berhasil ditambahkan.');
    }

    // public function simpan()
    // {
    //     if (!logged_in()) {
    //         return redirect()->to('/login');
    //     }

    //     $manage_akunModel = new Manage_akunModel();
    //     $users = model(UserModel::class);
    //     $role = $this->request->getPost('role');

    //     $rules = [
    //         'username' => 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username]',
    //         'email'    => 'required|valid_email|is_unique[users.email]',
    //         'password' => 'required',
    //         'confirm_password' => 'required|matches[password]',
    //     ];

    //     if (!$this->validate($rules)) {
    //         return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    //     }

    //     // Cek apakah ada file gambar yang diunggah
    //     $file = $this->request->getFile('user_image');
    //     $fileName = 'default.png'; // Nama default jika tidak ada gambar diunggah

    //     if ($file && $file->isValid() && !$file->hasMoved()) {
    //         $fileName = $file->getRandomName();
    //         $file->move(FCPATH . 'uploads/', $fileName);
    //     }

    //     // Hash password sebelum disimpan
    //     $hashedPassword = Password::hash($this->request->getPost('password'));

    //     // Buat data user
    //     $data = [
    //         'username'   => $this->request->getPost('username'),
    //         'email'      => $this->request->getPost('email'),
    //         'password_hash'   => $hashedPassword,
    //         'fullname'   => $this->request->getPost('fullname'),
    //         'user_image' => $fileName,
    //         'active'     => 1,
    //         'created_at' => date('Y-m-d H:i:s'),
    //         'updated_at' => date('Y-m-d H:i:s'),
    //     ];


    //     $userId = $manage_akunModel->insert($data); // Simpan data

    //     if ($userId) {
    //         // Update role sesuai pilihan
    //         if (in_array($role, ['1', '2', '3'])) {
    //             $manage_akunModel->updateUserRole($userId, $role);
    //         }

    //         session()->setFlashdata('success', 'Akun berhasil ditambahkan');
    //         return redirect()->to(base_url('admin/manage_akun'));
    //     } else {
    //         session()->setFlashdata('error', 'Gagal menambahkan akun');
    //         return redirect()->back()->withInput();
    //     }
    //     if (!$users->insert($data)) {
    //         return redirect()->back()->withInput()->with('errors', $users->errors());
    //     }

    //     return redirect()->to('/admin/manage_akun/tambah')->with('success', 'Akun berhasil ditambahkan!');
    // }

    // public function simpan()
    // {
    //     if (!logged_in()) {
    //         return redirect()->to('/login');
    //     }

    //     $users = model(UserModel::class);
    //     $manage_akunModel = new Manage_akunModel();

    //     $role = $this->request->getPost('role');
    //     $email = $this->request->getPost('email');

    //     $rules = [
    //         'username' => 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username]',
    //         'email'    => 'valid_email|is_unique[users.email]',
    //         'password' => 'required',
    //         'confirm_password' => 'required|matches[password]',
    //     ];

    //     if (!$this->validate($rules)) {
    //         return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    //     }

    //     // Jika email kosong, buat email otomatis dengan format <username>@gmail.com
    //     if (empty($email)) {
    //         $email = strtolower($username) . '@gmail.com'; // email dibuat otomatis
    //     }


    //     // Cek apakah ada file gambar yang diunggah
    //     $file = $this->request->getFile('user_image');
    //     $fileName = 'default.png'; // Nama default jika tidak ada gambar diunggah

    //     if ($file && $file->isValid() && !$file->hasMoved()) {
    //         $fileName = $file->getRandomName();
    //         $file->move(FCPATH . 'uploads/', $fileName);
    //     }

    //     // Hash password sebelum disimpan
    //     $hashedPassword = Password::hash($this->request->getPost('password'));

    //     // Buat data user
    //     $data = [
    //         'username'   => $this->request->getPost('username'),
    //         'email'      => $this->request->getPost('email'),
    //         'password_hash'   => $hashedPassword,
    //         'fullname'   => $this->request->getPost('fullname'),
    //         'user_image' => $fileName,
    //         'active'     => 1,
    //         'created_at' => date('Y-m-d H:i:s'),
    //         'updated_at' => date('Y-m-d H:i:s'),
    //     ];

    //     // Simpan user baru ke dalam database
    //     $userId = $users->insert($data);

    //     if ($userId) {
    //         // Tambahkan role seperti di updateRole()
    //         if (in_array($role, ['1', '2', '3'])) {
    //             $manage_akunModel->updateUserRole($userId, $role);
    //         }

    //         session()->setFlashdata('success', 'Akun berhasil ditambahkan');
    //         return redirect()->to(base_url('admin/manage_akun'));
    //     } else {
    //         session()->setFlashdata('error', 'Gagal menambahkan akun');
    //         return redirect()->back()->withInput();
    //     }
    // }


    // public function edit($id)
    // {
    //     if (!logged_in()) {
    //         return redirect()->to('/login');
    //     }

    //     $artikelModel = new ArtikelModel();
    //     $artikel = $artikelModel->find($id);

    //     if (empty($artikel)) {
    //         throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    //     }

    //     $kategoriList = ['Berita', 'Kompetisi', 'Event', 'Belajar', 'Lainnya'];

    //     $data = [
    //         'title' => 'Edit Artikel',
    //         'artikel' => $artikel,
    //         'kategoriList' => $kategoriList,
    //     ];

    //     return view('admin/artikel/edit', $data);
    // }

    // public function update($id)
    // {
    //     if (!logged_in()) {
    //         return redirect()->to('/login');
    //     }

    //     $artikelModel = new ArtikelModel();
    //     $artikel = $artikelModel->find($id);

    //     if (empty($artikel)) {
    //         throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    //     }

    //     $validationRules = [
    //         'judul' => [
    //             'rules' => 'required',
    //             'errors' => ['required' => 'Judul artikel wajib diisi.']
    //         ],
    //         'kategori' => [
    //             'rules' => 'required|in_list[Berita,Kompetisi,Event,Belajar,Lainnya]',
    //             'errors' => [
    //                 'required' => 'Kategori harus dipilih.',
    //                 'in_list' => 'Kategori yang dipilih tidak valid.'
    //             ]
    //         ],
    //         'konten' => [
    //             'rules' => 'required',
    //             'errors' => ['required' => 'Konten artikel tidak boleh kosong.']
    //         ],
    //         'gambar' => [
    //             'rules' => 'max_size[gambar,5000]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
    //             'errors' => [
    //                 'max_size' => 'Ukuran gambar maksimal adalah 5MB.',
    //                 'is_image' => 'File harus berupa gambar.',
    //                 'mime_in' => 'Format gambar harus JPG, JPEG, atau PNG.'
    //             ]
    //         ]
    //     ];

    //     if (!$this->validate($validationRules)) {
    //         return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    //     }

    //     // Ambil inputan dari form
    //     $data = [
    //         'judul' => $this->request->getPost('judul'),
    //         'slug' => url_title($this->request->getPost('judul'), '-', true),
    //         'konten' => $this->request->getPost('konten'),
    //         'kategori' => $this->request->getPost('kategori'),
    //         'penulis_id' => 1,
    //         'status' => 'publish',
    //         'updated_at' => date('Y-m-d H:i:s'),
    //     ];

    //     // Cek jika ada gambar baru yang diunggah
    //     $file = $this->request->getFile('gambar');
    //     if ($file && $file->isValid() && !$file->hasMoved()) {
    //         // Hapus gambar lama jika ada
    //         if (!empty($artikel['gambar']) && file_exists(FCPATH . 'uploads/' . $artikel['gambar'])) {
    //             unlink(FCPATH . 'uploads/' . $artikel['gambar']);
    //         }

    //         // Upload gambar baru
    //         $fileName = $file->getRandomName();
    //         $file->move(FCPATH . 'uploads/', $fileName);
    //         $data['gambar'] = $fileName;
    //     }

    //     // Cek apakah ada perubahan data sebelum update
    //     if ($artikel == $data) {
    //         return redirect()->back()->with('error', 'Tidak ada perubahan yang dilakukan.');
    //     }

    //     // Jalankan update
    //     if ($artikelModel->update($id, $data)) {
    //         return redirect()->to('/admin/artikel')->with('success', 'Artikel berhasil diperbarui!');
    //     } else {
    //         return redirect()->back()->withInput()->with('error', 'Gagal menyimpan artikel, silakan coba lagi.');
    //     }
    // }

    // public function delete($id)
    // {
    //     if (!logged_in()) {
    //         return redirect()->to('/login');
    //     }

    //     $artikelModel = new ArtikelModel();
    //     $artikel = $artikelModel->find($id);

    //     if (empty($artikel)) {
    //         return redirect()->to('/admin/artikel')->with('error', 'Artikel tidak ditemukan.');
    //     }

    //     // Hapus gambar jika ada
    //     if (!empty($artikel['gambar']) && file_exists(FCPATH . 'uploads/' . $artikel['gambar'])) {
    //         unlink(FCPATH . 'uploads/' . $artikel['gambar']);
    //     }

    //     // Hapus artikel
    //     $artikelModel->delete($id);

    //     return redirect()->to('/admin/artikel')->with('success', 'Artikel berhasil dihapus!');
    // }
}
