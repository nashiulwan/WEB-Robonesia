<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KategoriModel; // Tambahkan ini
use App\Models\ArtikelModel; // Tambahkan ini

class Artikel extends BaseController
{
    protected $artikelModel;

    public function __construct()
    {
        $this->artikelModel = new ArtikelModel();
    }

    public function index()
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }

        return view('admin/artikel/index');
    }

    public function tambah()
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }

        return view('admin/artikel/tambah');
    }

    
    public function simpan()
    {
        // Validasi data
        $validation = $this->validate([
            'judul' => 'required',
            'kategori' => 'required',
            'konten' => 'required',
            'gambar' => 'uploaded[gambar]|max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
        ]);

        if (!$validation) {
            // Log error validasi
            log_message('error', 'Validasi gagal: ' . json_encode($this->validator->getErrors()));
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Upload gambar
        $file = $this->request->getFile('gambar');
        $fileName = $file->getRandomName();
        $file->move(WRITEPATH . 'uploads', $fileName);

        $this->artikelModel->save([
            'judul' => $this->request->getPost('judul'),
            'slug' => url_title($this->request->getPost('judul'), '-', true),
            'konten' => $this->request->getPost('konten'),
            'kategori_id' => $this->request->getPost('kategori'),
            'penulis_id' => 1, // Ambil dari sesi pengguna yang login
            'status' => 'publish', // Default langsung publish
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'gambar' => $fileName, // Simpan nama file gambar
        ]);

        return redirect()->to('/admin/artikel/index')->with('success', 'Artikel berhasil ditambahkan!');
    }
}
