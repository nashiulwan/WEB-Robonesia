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

    // public function simpan()
    // {
    //     if (!logged_in()) {
    //         return redirect()->to('/login');
    //     }

    //     $userModel = new UserModel();
    //     $manage_akunModel = new Manage_akunModel();

    //     $role = $this->request->getPost('role');
    //     $username = $this->request->getPost('username');
    //     $email = $this->request->getPost('email');
    //     $fullname = $this->request->getPost('fullname');

    //     // Jika email kosong, buat email dari username
    //     if (empty($email)) {
    //         $email = strtolower($username) . '@gmail.com';

    //         // Cek apakah email sudah ada di database
    //         while ($userModel->where('email', $email)->countAllResults() > 0) {
    //             // Jika email sudah ada, tambahkan angka acak agar unik
    //             $email = strtolower($username) . rand(100, 999) . '@gmail.com';
    //         }
    //     }

    //     $rules = [
    //         'username' => 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username]',
    //         'password' => 'required',
    //         'confirm_password' => 'required|matches[password]',
    //     ];

    //     if (!$this->validate($rules)) {
    //         return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    //     }

    //     // Tentukan gambar default
    //     $fileName = 'profil_devault.svg';

    //     // Proses file gambar jika ada yang diunggah
    //     $file = $this->request->getFile('user_image');
    //     if ($file->isValid() && !$file->hasMoved()) {
    //         // Validasi jenis file (hanya menerima JPG, PNG, SVG)
    //         $allowedTypes = ['image/jpeg', 'image/png', 'image/svg+xml'];
    //         if (!in_array($file->getMimeType(), $allowedTypes)) {
    //             return redirect()->back()->withInput()->with('error', 'Format file tidak diizinkan. Hanya JPG, PNG, dan SVG yang diperbolehkan.');
    //         }

    //         // Validasi ukuran file (maksimal 2MB)
    //         if ($file->getSize() > 2 * 1024 * 1024) {
    //             return redirect()->back()->withInput()->with('error', 'Ukuran file terlalu besar. Maksimum 2MB.');
    //         }

    //         // Generate nama file acak dan simpan
    //         $fileName = $file->getRandomName();
    //         $file->move(FCPATH . 'uploads/', $fileName);
    //     }

    //     // Hash password sebelum disimpan
    //     $hashedPassword = Password::hash($this->request->getPost('password'));

    //     // Buat data user
    //     $data = [
    //         'username'       => $username,
    //         'email'          => $email,
    //         'password_hash'  => $hashedPassword,
    //         'fullname'       => $fullname,
    //         'user_image'     => $fileName,
    //         'active'         => 1,
    //         'created_at'     => date('Y-m-d H:i:s'),
    //         'updated_at'     => date('Y-m-d H:i:s'),
    //     ];

    //     // Simpan user baru ke database
    //     if ($userModel->insert($data)) {
    //         $userId = $userModel->getInsertID(); // Ambil ID user yang baru dibuat

    //         // Jika role valid (misal: 1 = Admin, 2 = Moderator, 3 = User)
    //         if (in_array($role, [1, 2, 3])) {
    //             // Update role untuk user
    //             $manage_akunModel->updateUserRole($userId, $role);
    //         }

    //         return redirect()->to('/admin/manage_akun')->with('success', 'Akun berhasil ditambahkan dan role diberikan.');
    //     } else {
    //         return redirect()->back()->with('error', 'Gagal menambahkan akun.');
    //     }
    // }

    public function simpan()
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }

        $manage_akunModel = new Manage_akunModel();

        $role = $this->request->getPost('role');
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $fullname = $this->request->getPost('fullname');

        // Jika email kosong, buat email dari username
        if (empty($email)) {
            $email = strtolower($username) . '@gmail.com';
            while ($manage_akunModel->where('email', $email)->countAllResults() > 0) {
                $email = strtolower($username) . rand(100, 999) . '@gmail.com';
            }
        }

        if (empty($fullname)) {
            $fullname = $username;
        }
        $rules = [
            'username' => 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username]',
            'password' => 'required',
            'confirm_password' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Tentukan gambar default
        $fileName = 'profil_devault.svg';
        $file = $this->request->getFile('user_image');
        if ($file->isValid() && !$file->hasMoved()) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/svg+xml'];
            if (!in_array($file->getMimeType(), $allowedTypes)) {
                return redirect()->back()->withInput()->with('error', 'Format file tidak diizinkan. Hanya JPG, PNG, dan SVG yang diperbolehkan.');
            }
            if ($file->getSize() > 2 * 1024 * 1024) {
                return redirect()->back()->withInput()->with('error', 'Ukuran file terlalu besar. Maksimum 2MB.');
            }
            $fileName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/', $fileName);
        }

        $hashedPassword = Password::hash($this->request->getPost('password'));

        // Buat data user
        $data = [
            'username'       => $username,
            'email'          => $email,
            'password_hash'  => $hashedPassword,
            'fullname'       => $fullname,
            'user_image'     => $fileName,
            'active'         => 1,
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s'),
            'role'           => in_array($role, [1, 2, 3]) ? $role : 3, // Default ke User jika role tidak valid
        ];

        // Simpan user baru ke database
        if ($manage_akunModel->insert($data)) {
            return redirect()->to('/admin/manage_akun')->with('success', 'Akun berhasil ditambahkan dan role diberikan.');
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan akun.');
        }
    }


    public function edit($id)
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }

        $manageModel = new Manage_akunModel();
        $users = $manageModel->find($id);

        if (empty($users)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Edit Akun',
            'users' => $users,
        ];

        return view('admin/manage_akun/edit', $data);
    }

    public function delete($id)
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }

        $manageModel = new Manage_akunModel();
        $users = $manageModel->find($id);

        if (empty($users)) {
            return redirect()->to('/admin/manage_akun')->with('error', 'Akun tidak ditemukan.');
        }

        $username = $users['username'];

        if (
            !empty($users['gambar']) &&
            $users['gambar'] !== 'profil_devault.svg' &&
            file_exists(FCPATH . 'uploads/' . $users['gambar'])
        ) {

            unlink(FCPATH . 'uploads/' . $users['gambar']);
        }

        // Hapus 
        $manageModel->delete($id);

        return redirect()->to('/admin/manage_akun')->with('success', "Akun $username berhasil dihapus!");
    }
}
