<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ArtikelModel;
use App\Models\NotifikasiModel;
use App\Models\PrestasiSertifikatModel;
use App\Models\UserPrestasiModel;
use CodeIgniter\Shield\Authentication\Authenticators\Session;

class SiswaController extends BaseController
{
    protected $artikelModel;
    protected $notifikasiModel;
    protected $prestasiModel;
    protected $userPrestasiModel;

    public function __construct()
    {
        $this->artikelModel = new ArtikelModel();
        $this->notifikasiModel = new NotifikasiModel();
        $this->prestasiModel = new PrestasiSertifikatModel();
        $this->userPrestasiModel = new UserPrestasiModel();
    }

    public function dashboard()
    {

        $data = [
            'title'             => 'Dashboard Siswa',
            'event_artikel'     => $this->artikelModel
                ->whereIn('kategori', ['kompetisi', 'event', 'berita'])
                ->where('created_at >=', date('Y-m-d', strtotime('-7 days')))
                ->orderBy('created_at', 'DESC')
                ->findAll(),
        ];

        $this->renderViewDashboardSiswa('siswa/dashboard', $data);
    }

    public function markAsRead($id)
    {
        $this->notifikasiModel->update($id, ['status' => 'read']);
        return redirect()->to(base_url('siswa/notifikasi')); // Redirect ke halaman notifikasi
    }


    // HALAMAN NOTIFIKASI
    public function notifikasi()
    {
        $notifikasiModel = new NotifikasiModel();

        $notifikasi = $notifikasiModel
            ->where('siswa_id', session('id'))
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $data = [
            'title'      => 'Semua Notifikasi',
            'notifikasi' => $notifikasi
        ];

        $this->renderViewDashboardSiswa('siswa/notifikasi', $data);
    }

    // HALAMAN EVENT DAN LOMBA
    public function pengumumanEvent()
    {
         $data = [
            'title'             => 'Event dan Lomba',
            'event_artikel'     => $this->artikelModel
                ->whereIn('kategori', ['kompetisi', 'event'])
                ->orderBy('created_at', 'DESC')
                ->findAll(),
        ];

        $this->renderViewDashboardSiswa('siswa/pengumuman/event', $data);
    }

    // HALAMAN PENGUMUMAN SEKOLAH
    public function pengumumanSekolah()
    {
         $data = [
            'title'             => 'Pengumuman Sekolah',
            'berita_artikel'     => $this->artikelModel->where('kategori', 'berita')
                ->orderBy('created_at', 'DESC')
                ->findAll(),
        ];

        $this->renderViewDashboardSiswa('siswa/pengumuman/sekolah', $data);
    }

    // HALAMAN PRESTASI
    public function prestasi()
    {
        // Mendapatkan user yang sedang login
        $auth = service('authentication');
        $user = $auth->user();
        
        if (!$user) {
            return redirect()->to('auth/login');
        }

        // Ambil semua prestasi berdasarkan user_id yang sedang login
        $prestasiUser = $this->userPrestasiModel
            ->select('prestasi.*')
            ->join('prestasi', 'prestasi.id = user_prestasi.prestasi_id')
            ->where('user_prestasi.user_id', $user->id)
            ->orderBy('prestasi.tahun', 'DESC')
            ->findAll();

        $data = [
            'title'    => 'Prestasi Saya',
            'prestasi' => $prestasiUser,
        ];

        $this->renderViewDashboardSiswa('siswa/prestasi_nilai/prestasi', $data);
    }
}
