<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\Manage_akunModel;
use App\Models\Manage_kelasModel;
use App\Models\PrestasiSertifikatModel;
use CodeIgniter\Controller;


class AdminController extends BaseController
{
    protected $artikelModel;
    protected $manage_akunModel;
    protected $manageKelasModel;
    protected $prestasiSertifikatModel;
    // protected $kategoriModel;

    public function __construct()
    {
        $this->prestasiSertifikatModel = new PrestasiSertifikatModel();
        $this->manageKelasModel = new Manage_kelasModel();
        $this->artikelModel = new ArtikelModel();
        $this->manage_akunModel = new Manage_akunModel();
    }

    // Method untuk dashboard
    public function dashboard()
    {
        $artikelModel = new ArtikelModel();
        $prestasi = $this->prestasiSertifikatModel->findAll();
        $classes = $this->manageKelasModel->getAllClassesWithMemberCount();

        $data = [
            'title' => 'Daftar Kelas',
        ];
        $data = [
            'title' => 'Dashboard',
            'jumlahArtikel' => $this->artikelModel->countAll(),
            'jumlahPengguna' => $this->manage_akunModel->countAll(),
            'artikel' => $artikelModel->findAll(), // Ambil semua artikel
            'classes' => $classes,
            'prestasi' => $prestasi,
        ];


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
