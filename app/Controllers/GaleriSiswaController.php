<?php

namespace App\Controllers;

use App\Models\GaleriSiswaModel;
use App\Models\UserModel;

class GaleriSiswaController extends BaseController
{
  protected $galeriSiswaModel;
  protected $userModel;

  public function __construct()
  {
    $this->galeriSiswaModel = new GaleriSiswaModel();
    $this->userModel        = new UserModel();
  }

  public function index()
  {
    if (!logged_in()) {
      return redirect()->to('auth/login');
    }
    $users = $this->userModel->getUsersByRole(2);

    if (!$users) {
      return redirect()->to('admin/dashboard')->with('error', 'Akun tidak ditemukan.');
    }

    $data = [
      'title' => 'Daftar Siswa',
      'users' => $users
    ];

    return view('admin/galeri_siswa/index', $data);
  }

  // Menampilkan seluruh galeri berdasarkan user
  public function detail($userId)
  {
    if (!logged_in()) {
      return redirect()->to('auth/login');
    }
    $user = $this->userModel->getUserById($userId);
    $galeri = $this->galeriSiswaModel->getGaleryByUserId($userId);

    $data = [
      'title' => 'Galeri Siswa',
      'galeri' => $galeri,
      'user' => $user
    ];

    return view('admin/galeri_siswa/detail', $data);
  }

  // Menampilkan form tambah
  public function tambah($userId)
  {
    if (!logged_in()) {
      return redirect()->to('auth/login');
    }

    $user = $this->userModel->getUserById($userId);
    $galeri = $this->galeriSiswaModel->getGaleryByUserId($userId);

    $data = [
      'title' => 'Galeri Siswa',
      'galeri' => $galeri,
      'user' => $user
    ];

    return view('admin/galeri_siswa/tambah', $data);
  }

  public function simpan($userId)
  {
    // Pastikan user sudah login
    if (!logged_in()) {
      return redirect()->to('auth/login');
    }

    // Aturan validasi untuk input form
    $rules = [
      'level'     => 'required',
      'sub_level' => 'required',
      'gambar'    => 'uploaded[gambar]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
    ];

    if (!$this->validate($rules)) {
      return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    $user_id = $userId;

    // Ambil data input lainnya
    $judul         = $this->request->getPost('judul');
    $deskripsi     = $this->request->getPost('deskripsi');
    $level         = $this->request->getPost('level');
    $level_lainnya = $this->request->getPost('level_lainnya');
    if ($level == 'Lainnya' && !empty($level_lainnya)) {
      $level = $level_lainnya;
    }
    $sub_level = $this->request->getPost('sub_level');

    // Proses unggah file gambar
    $gambarFile = $this->request->getFile('gambar');

    // Tentukan target folder di public/uploads/galeri
    $targetPath = FCPATH . 'uploads/galeri';
    if (!is_dir($targetPath)) {
      mkdir($targetPath, 0777, true);
    }

    if ($gambarFile->isValid() && !$gambarFile->hasMoved()) {
      $newName = $gambarFile->getRandomName();
      $gambarFile->move($targetPath, $newName);
      // Simpan hanya nama file di database
      $gambarName = $newName;
    } else {
      $gambarName = '';
    }

    // Siapkan data yang akan disimpan
    $dataGaleri = [
      'user_id'   => $user_id,
      'judul'     => $judul,
      'deskripsi' => $deskripsi,
      'level'     => $level,
      'sub_level' => $sub_level,
      'gambar'    => $gambarName,
    ];

    // Simpan data menggunakan model
    $this->galeriSiswaModel->save($dataGaleri);

    session()->setFlashdata('success', 'Data galeri berhasil disimpan.');
    return redirect()->to(base_url('admin/galeri/detail/' . $user_id));
  }

  // Method untuk menampilkan detail 1 record galeri (edit/view detail) berdasarkan user dan galeri
  public function detailGaleri($userId, $galeriId)
  {
    if (!logged_in()) {
      return redirect()->to('auth/login');
    }
    $user = $this->userModel->getUserById($userId);
    $galeri = $this->galeriSiswaModel->find($galeriId);
    if (!$galeri) {
      return redirect()->back()->with('error', 'Data galeri tidak ditemukan.');
    }

    $data = [
      'title'  => 'Detail Galeri Siswa',
      'user'   => $user,
      'galeri' => $galeri
    ];

    return view('admin/galeri_siswa/detail_galeri', $data);
  }

  // (Opsional) Method untuk menampilkan form edit
  // Jika Anda ingin menampilkan form edit dengan data yang sudah ada
  public function edit($userId, $galeriId)
  {
    if (!logged_in()) {
      return redirect()->to('auth/login');
    }
    $user = $this->userModel->getUserById($userId);
    $galeri = $this->galeriSiswaModel->find($galeriId);
    if (!$galeri) {
      return redirect()->back()->with('error', 'Data galeri tidak ditemukan.');
    }
    $data = [
      'title'  => 'Edit Galeri Siswa',
      'user'   => $user,
      'galeri' => $galeri
    ];
    return view('admin/galeri_siswa/edit', $data);
  }

  // (Opsional) Method untuk mengupdate data edit
  public function update($userId, $galeriId)
  {
    if (!logged_in()) {
      return redirect()->to('auth/login');
    }

    // Aturan validasi (gambar tidak wajib diunggah ulang)
    $rules = [
      'level'     => 'required',
      'sub_level' => 'required',
    ];

    // Jika ada file gambar baru, tambahkan aturan validasi untuk gambar
    if ($this->request->getFile('gambar')->isValid() && !$this->request->getFile('gambar')->hasMoved()) {
      $rules['gambar'] = 'is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]';
    }

    if (!$this->validate($rules)) {
      return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    // Ambil data input
    $judul         = $this->request->getPost('judul');
    $deskripsi     = $this->request->getPost('deskripsi');
    $level         = $this->request->getPost('level');
    $level_lainnya = $this->request->getPost('level_lainnya');
    if ($level == 'Lainnya' && !empty($level_lainnya)) {
      $level = $level_lainnya;
    }
    $sub_level = $this->request->getPost('sub_level');

    // Dapatkan data galeri lama untuk cek file gambar
    $galeriLama = $this->galeriSiswaModel->find($galeriId);
    $gambarName = $galeriLama['gambar'];

    // Proses unggah gambar baru jika ada
    $gambarFile = $this->request->getFile('gambar');
    if ($gambarFile && $gambarFile->isValid() && !$gambarFile->hasMoved()) {
      // Hapus file gambar lama jika ada
      if (!empty($gambarName)) {
        $oldFile = FCPATH . 'uploads/galeri/' . $gambarName;
        if (is_file($oldFile)) {
          unlink($oldFile);
        }
      }
      $targetPath = FCPATH . 'uploads/galeri';
      if (!is_dir($targetPath)) {
        mkdir($targetPath, 0777, true);
      }
      $newName = $gambarFile->getRandomName();
      $gambarFile->move($targetPath, $newName);
      $gambarName = $newName;
    }

    $dataGaleri = [
      'judul'     => $judul,
      'deskripsi' => $deskripsi,
      'level'     => $level,
      'sub_level' => $sub_level,
      'gambar'    => $gambarName,
    ];

    $this->galeriSiswaModel->update($galeriId, $dataGaleri);
    session()->setFlashdata('success', 'Data galeri berhasil diperbarui.');
    return redirect()->to(base_url('admin/galeri/detail/' . $userId));
  }


  // Method untuk menghapus record galeri
  public function delete($userId, $galeriId)
  {
    if (!logged_in()) {
      return redirect()->to('auth/login');
    }
    $galeri = $this->galeriSiswaModel->find($galeriId);
    if (!$galeri) {
      return redirect()->back()->with('error', 'Data galeri tidak ditemukan.');
    }
    // Hapus file gambar jika ada
    $filePath = FCPATH . 'uploads/galeri/' . $galeri['gambar'];
    if (is_file($filePath)) {
      unlink($filePath);
    }
    $this->galeriSiswaModel->delete($galeriId);
    session()->setFlashdata('success', 'Data galeri berhasil dihapus.');
    return redirect()->to(base_url('admin/galeri/detail/' . $userId));
  }
}
