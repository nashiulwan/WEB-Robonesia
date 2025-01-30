<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KategoriModel; 
use App\Models\ArtikelModel;

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

        $data = [
            'title' => 'Daftar Artikel',
            'artikel' => $this->artikelModel->getArtikelWithKategori(), // Data artikel dengan kategori
        ];

        return view('admin/artikel/index', $data); // Kirim data ke view
    }

    public function tambah()
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }

        $kategoriModel = new KategoriModel(); // Load kategori
        $data = [
            'title' => 'Tambah Artikel',
            'kategori' => $kategoriModel->findAll(), // Kirim kategori ke view
        ];

        return view('admin/artikel/tambah', $data);
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
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Upload gambar
        $file = $this->request->getFile('gambar');
        $fileName = $file->getRandomName();
        $file->move('uploads', $fileName); // Pindahkan ke folder public/uploads

        $this->artikelModel->save([
            'judul' => $this->request->getPost('judul'),
            'slug' => url_title($this->request->getPost('judul'), '-', true),
            'konten' => $this->request->getPost('konten'),
            'kategori_id' => $this->request->getPost('kategori'),
            'penulis_id' => session()->get('id'), // Ambil ID dari sesi
            'status' => 'publish', // Default langsung publish
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'gambar' => $fileName, // Simpan nama file gambar
        ]);

        return redirect()->to('/admin/artikel')->with('success', 'Artikel berhasil ditambahkan!');
    }
}