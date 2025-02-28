<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ArtikelModel;
use App\Models\NotifikasiModel;
use App\Models\PrestasiSertifikatModel;
use App\Models\UserPrestasiModel;

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
        // Ambil user yang sedang login
        $user = auth()->user(); // Jika menggunakan Shield atau Auth, pastikan ini sesuai dengan sistem autentikasi Anda.
        $user_id = $user->id;

        // Ambil daftar prestasi yang terkait dengan user
        $userPrestasi = $this->userPrestasiModel
            ->where('user_id', $user_id)
            ->findAll();

        // Ambil ID prestasi dari tabel pivot
        $prestasiIds = array_column($userPrestasi, 'prestasi_id');

        // Ambil data prestasi berdasarkan ID yang diperoleh
        $prestasi = [];
        if (!empty($prestasiIds)) {
            $prestasi = $this->prestasiModel
                ->whereIn('id', $prestasiIds)
                ->orderBy('tahun', 'DESC')
                ->findAll();
        }

        $data = [
            'title'     => 'Prestasi Saya',
            'prestasi'  => $prestasi,
        ];

        $this->renderViewDashboardSiswa('siswa/prestasi_nilai/prestasi', $data);
    }
}
