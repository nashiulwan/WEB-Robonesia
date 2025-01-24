<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use CodeIgniter\Controller;
use App\Models\KategoriModel;

class Admin extends BaseController
{
    protected $artikelModel;
    protected $kategoriModel;

    public function __construct()
    {
        $this->artikelModel = new ArtikelModel(); // Contoh penggunaan model
        $this->kategoriModel = new KategoriModel();
    }

    // Method untuk dashboard
    public function dashboard()
    {
        $data['title'] = 'Dashboard';
        return view('admin/dashboard', $data);
    }

    // Method untuk Analytics
    public function analytics()
    {
        $data['title'] = 'Analytics';
        // Bisa tambahkan data yang berhubungan dengan analitik
        return view('admin/analytics', $data);
    }

    // Method untuk SEO
    public function seo()
    {
        $data['title'] = 'SEO Settings';
        // Bisa tambahkan data atau form terkait pengaturan SEO
        return view('admin/seo', $data);
    }

    // Method untuk Artikel/Posting
    public function artikel()
    {
        $data['title'] = 'Semua Artikel';
        $data['artikels'] = $this->artikelModel->findAll(); // Ambil semua artikel
        return view('admin/artikel', $data);
    }

    // Method untuk Tambah Artikel
    public function tambah()
    {
        $data['title'] = 'Tambah Artikel';
        $data['kategoris'] = $this->kategoriModel->findAll(); // Semua data kategori
        return view('admin/artikel/tambah', $data);
    }

    // Method untuk Pengaturan
    public function pengaturan()
    {
        $data['title'] = 'Pengaturan Sistem';
        // Tambahkan data untuk pengaturan di sini
        return view('admin/pengaturan', $data);
    }

    // Method untuk Profil Pengguna
    public function profil()
    {
        $data['title'] = 'Profil Pengguna';
        // Tambahkan data pengguna di sini
        return view('admin/profil', $data);
    }

    // Method untuk Profil Pengguna
    public function pengguna()
    {
        $data['title'] = 'Data Pengguna';
        // Tambahkan data pengguna di sini
        return view('admin/pengguna', $data);
    }
}