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

        $manage_akunModel = new Manage_akunModel();

        $role = $this->request->getPost('role') ?? ''; // Bisa kosong
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $fullname = $this->request->getPost('fullname');
        $asal_sekolah = $this->request->getPost('asal_sekolah');        
        $kelas = $this->request->getPost('kelas');

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
        $fileName = 'profil_default.svg';
        $file = $this->request->getFile('user_image');
        if ($file->isValid() && !$file->hasMoved()) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/svg+xml'];
            if (!in_array($file->getMimeType(), $allowedTypes)) {
                return redirect()->back()->withInput()->with('error', 'Format file tidak didukung. Hanya JPG, PNG, dan SVG.');
            }
            $fileName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/', $fileName);
        }

        $hashedPassword = Password::hash($this->request->getPost('password'));

        // Jika role kosong atau tidak valid, set ke default (2 = siswa)
        $validRoles = ['1', '2', '3'];
        $role = in_array($role, $validRoles) ? (int)$role : 2;

        // Buat data user
        $data = [
            'username'       => $username,
            'email'          => $email,
            'password_hash'  => $hashedPassword,
            'fullname'       => $fullname,
            'user_image'     => $fileName,
            'asal_sekolah'   => $asal_sekolah,
            'kelas'          => $kelas,
            'active'         => 1,
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s'),
        ];

        // Simpan user baru ke database
        if ($manage_akunModel->insert($data)) {
            $userId = $manage_akunModel->insertID(); // Ambil ID user yang baru disimpan

            // Simpan role ke auth_groups_users
            $manage_akunModel->assignUserRole($userId, $role);

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

        $manage_akunmodel = new Manage_akunModel();
        $users = $manage_akunmodel->find($id);

        if (empty($users)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $role = $manage_akunmodel->getUserRole($id);

        $data = [
            'title' => 'Edit Akun',
            'users' => $users,
            'role'  => $role, // Kirim role ke view
        ];

        return view('admin/manage_akun/edit', $data);
    }

    public function update($id)
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }

        $manageAkunModel = new Manage_akunModel();
        $user = $manageAkunModel->find($id);

        if (empty($user)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Validasi input
        $validationRules = [
            'username' => [
                'rules' => 'required|alpha_numeric',
                'errors' => [
                    'required' => 'Username wajib diisi.',
                    'alpha_numeric' => 'Username hanya boleh mengandung huruf dan angka.',
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Email wajib diisi.',
                    'valid_email' => 'Format email tidak valid.'
                ]
            ],
            'fullname' => [
                'rules' => 'required',
                'errors' => ['required' => 'Nama lengkap wajib diisi.']
            ],
            'role' => [
                'rules' => 'required|in_list[1,2,3,0]',
                'errors' => [
                    'required' => 'Hak akses harus dipilih.',
                    'in_list' => 'Hak akses tidak valid.'
                ]
            ],
            'password' => [
                'rules' => 'permit_empty',
            ],
            'confirm_password' => [
                'rules' => 'matches[password]',
                'errors' => ['matches' => 'Konfirmasi password tidak cocok.']
            ],
            'user_image' => [
                'rules' => 'permit_empty|is_image[user_image]|mime_in[user_image,image/jpg,image/jpeg,image/png]|max_size[user_image,2048]',
                'errors' => [
                    'is_image' => 'File yang diunggah harus berupa gambar.',
                    'mime_in' => 'Format gambar harus JPG, JPEG, atau PNG.',
                    'max_size' => 'Ukuran gambar tidak boleh lebih dari 2MB.'
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Ambil input password baru dari form
        $newPassword = $this->request->getPost('password');
        // Jika password tidak diisi, gunakan password lama
        $hashedPassword = !empty($newPassword) ? Password::hash($newPassword) : $user['password_hash'];

        // Data yang akan diperbarui
        $data = [
            'username'      => $this->request->getPost('username'),
            'email'         => $this->request->getPost('email'),
            'fullname'      => $this->request->getPost('fullname'),
            'role'          => $this->request->getPost('role'),
            'asal_sekolah'  => $this->request->getPost('asal_sekolah'),
            'kelas'         => $this->request->getPost('kelas'),
            'password_hash' => $hashedPassword,
            'updated_at'    => date('Y-m-d H:i:s'),
        ];

        // **PROSES UPLOAD FOTO BARU**
        $file = $this->request->getFile('user_image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // **Hapus foto lama jika ada**
            if (!empty($user['user_image']) && file_exists(FCPATH . 'uploads/' . $user['user_image'])) {
                unlink(FCPATH . 'uploads/' . $user['user_image']);
            }

            // **Simpan foto baru dengan nama unik**
            $newFileName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/', $newFileName);
            $data['user_image'] = $newFileName; // Update nama file baru di database
        }

        // Jalankan update
        if ($manageAkunModel->update($id, $data)) {
            return redirect()->to('/admin/manage_akun')->with('success', 'Akun berhasil diperbarui!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui akun, silakan coba lagi.');
        }
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
