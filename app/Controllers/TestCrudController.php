<?php

namespace App\Controllers;

use App\Models\ArtikelModel;

class TestCrudController extends BaseController
{
    public function index()
    {
        // Inisialisasi model
        $artikelModel = new ArtikelModel();

        // CREATE: Menambahkan data baru
        $artikelModel->save([
            'judul' => 'tes',
            'kategori' => 'Berita',
            'konten' => 'tes',
        ]);

        // READ: Mengambil semua data dari tabel users
        $artikel = $artikelModel->findAll(); 
        echo "<h3>Daftar Artikel:</h3>";
        print_r($artikel);  // Tampilkan hasil data

        // READ: Mengambil data dari tabel users berdasarkan ID
        $artikelModel->delete(1);

        // Tes hasil operasi
        echo "<br><br><strong>Operasi CRUD selesai!</strong>";
    }
}
