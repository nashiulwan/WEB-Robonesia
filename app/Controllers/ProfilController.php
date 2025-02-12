<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProfilModel;
use Myth\Auth\Password;

class ProfilController extends BaseController
{
  /**
   * Tampilkan halaman Profil Saya.
   */
  public function index()
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

    return view('admin/profil/index', $data);
  }

  /**
   * Tampilkan form Edit Profil.
   */
  public function edit()
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

    return view('admin/profil/edit', $data);
  }

  /**
   * Proses update data Profil.
   */
  /**
   * Proses update data Profil.
   */
  public function update()
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
      return redirect()->to('admin/profil')->with('success', 'Profil berhasil diperbarui!');
    } else {
      return redirect()->back()->withInput()->with('error', 'Gagal memperbarui profil, silakan coba lagi.');
    }
  }
}
