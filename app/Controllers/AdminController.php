<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use CodeIgniter\Controller;


class AdminController extends BaseController
{
    protected $artikelModel;
    // protected $kategoriModel;

    public function __construct()
    {
        $this->artikelModel = new ArtikelModel(); // Contoh penggunaan model
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

    // Method untuk Profil Pengguna
    public function pengguna()
    {
        $data['title'] = 'Data Pengguna';
        // Tambahkan data pengguna di sini
        return view('admin/pengguna', $data);
    }
}
