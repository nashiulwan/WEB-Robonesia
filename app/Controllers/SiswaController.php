<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ArtikelModel;
use App\Models\PrestasiSertifikatModel;
use App\Models\UserPrestasiModel;
use App\Models\Manage_kelasModel;
use CodeIgniter\Shield\Authentication\Authenticators\Session;

class SiswaController extends BaseController
{
    protected $artikelModel;
    protected $prestasiModel;
    protected $userPrestasiModel;
    protected $kelasModel;
    protected $user;

    public function __construct()
    {
        $this->artikelModel = new ArtikelModel();
        $this->prestasiModel = new PrestasiSertifikatModel();
        $this->userPrestasiModel = new UserPrestasiModel();
        $this->kelasModel = new Manage_kelasModel();

        // Mendapatkan user yang sedang login
        $auth = service('authentication');
        $this->user = $auth->user();
                
        if (!$this->user) {
            return redirect()->to('auth/login')->send();
        }

    }

    public function dashboard()
    {
        $userId = $this->user->id;

        $data = [
            'title'         => 'Dashboard Siswa',
            'event_artikel' => $this->artikelModel
                ->whereIn('kategori', ['kompetisi', 'event', 'berita'])
                ->where('created_at >=', date('Y-m-d', strtotime('-7 days')))
                ->orderBy('created_at', 'DESC')
                ->findAll(),
            'kelasSaya'     => $this->kelasModel->getClassesByUserId($userId),
        ];

        $this->renderViewDashboardSiswa('siswa/dashboard', $data);
    }

    public function pengumumanEvent()
    {
        $data = [
            'title'         => 'Event dan Lomba',
            'event_artikel' => $this->artikelModel
                ->whereIn('kategori', ['kompetisi', 'event'])
                ->orderBy('created_at', 'DESC')
                ->findAll(),
        ];

        $this->renderViewDashboardSiswa('siswa/pengumuman/event', $data);
    }

    public function pengumumanSekolah()
    {
        $data = [
            'title'          => 'Pengumuman Sekolah',
            'berita_artikel' => $this->artikelModel->where('kategori', 'berita')
                ->orderBy('created_at', 'DESC')
                ->findAll(),
        ];

        $this->renderViewDashboardSiswa('siswa/pengumuman/sekolah', $data);
    }

    public function prestasi()
    {
        $prestasiUser = $this->userPrestasiModel
            ->select('prestasi.*')
            ->join('prestasi', 'prestasi.id = user_prestasi.prestasi_id')
            ->where('user_prestasi.user_id', $this->user->id)
            ->orderBy('prestasi.tahun', 'DESC')
            ->findAll();

        $data = [
            'title'    => 'Prestasi Saya',
            'prestasi' => $prestasiUser,
        ];

        $this->renderViewDashboardSiswa('siswa/prestasi_nilai/prestasi', $data);
    }

    public function galeriKegiatan()
    {
        $data = ['title' => 'Galeri Kegiatan'];
        $this->renderViewDashboardSiswa('siswa/galeri_kegiatan', $data);
    }

    public function projectNilai()
    {
        $data = ['title' => 'Project dan Nilai'];
        $this->renderViewDashboardSiswa('siswa/prestasi_nilai/project_nilai', $data);
    }

    public function sertifikat()
    {
        $data = ['title' => 'Sertifikat dan Level'];
        $this->renderViewDashboardSiswa('siswa/prestasi_nilai/sertifikat', $data);
    }
}
