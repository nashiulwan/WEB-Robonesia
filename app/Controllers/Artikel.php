<?php

namespace App\Controllers\Admin;

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

    // Method simpan
    public function simpan()
    {
        $this->artikelModel->save([
            'judul' => $this->request->getPost('judul'),
            'slug' => url_title($this->request->getPost('judul'), '-', true),
            'konten' => $this->request->getPost('konten'),
            'kategori_id' => $this->request->getPost('kategori_id'),
            'penulis_id' => 1, // ID penulis (misalnya default 1)
            'status' => $this->request->getPost('status'),
        ]);

        return redirect()->to('/admin/artikel/index');
    }
}
