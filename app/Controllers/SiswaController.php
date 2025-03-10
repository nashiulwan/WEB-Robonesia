<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ArtikelModel;
use App\Models\PrestasiSertifikatModel;
use App\Models\UserPrestasiModel;
use App\Models\Manage_kelasModel;
use App\Models\GaleriSiswaModel;
use App\Models\SertifikatModel;
use CodeIgniter\Shield\Authentication\Authenticators\Session;

class SiswaController extends BaseController
{
    protected $artikelModel;
    protected $prestasiModel;
    protected $userPrestasiModel;
    protected $kelasModel;
    protected $user;
    protected $galeriSiswaModel;
    protected $sertifikatModel;

    public function __construct()
    {
        $this->artikelModel = new ArtikelModel();
        $this->prestasiModel = new PrestasiSertifikatModel();
        $this->userPrestasiModel = new UserPrestasiModel();
        $this->kelasModel = new Manage_kelasModel();
        $this->sertifikatModel = new SertifikatModel();
        $this->galeriSiswaModel = new GaleriSiswaModel();

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
        $galeriModel = new GaleriSiswaModel();
        $userId = $this->user->id;

        $galeri = $galeriModel->getGaleryByUserId($userId);

        // Kelompokkan berdasarkan level dan sub level
        $galeriData = [];
        foreach ($galeri as $item) {
            $level = $item['level'];
            $subLevel = $item['sub_level'];

            if (!isset($galeriData[$level])) {
                $galeriData[$level] = [];
            }

            if (!isset($galeriData[$level][$subLevel])) {
                $galeriData[$level][$subLevel] = [];
            }

            $galeriData[$level][$subLevel][] = $item;
        }

        $data = [
            'title' => 'Galeri Kegiatan',
            'galeri' => $galeriData
        ];

        $this->renderViewDashboardSiswa('siswa/galeri/index', $data);
    }

    public function galeriDetail($level, $subLevel = null)
    {
        $galeriModel = $this->galeriSiswaModel;
        $userId = $this->user->id;

        // Ambil gambar berdasarkan level dan sublevel (jika ada)
        if ($subLevel) {
            $galeri = $galeriModel->where('level', $level)->where('sub_level', $subLevel)->findAll();
        } else {
            $galeri = $galeriModel->where('level', $level)->findAll();
        }

        $data = [
            'title' => 'Galeri Kegiatan',
            'galeri' => $galeri,
            'level' => $level,
            'subLevel' => $subLevel,
        ];

        $this->renderViewDashboardSiswa('siswa/galeri/detail', $data);
    }




    public function projectNilai()
    {
        $data = ['title' => 'Project dan Nilai'];
        $this->renderViewDashboardSiswa('siswa/prestasi_nilai/project_nilai', $data);
    }

    public function sertifikat()
    {
        $userId = $this->user->id;

        // Sertifikat Berdasarkan User
        $sertifikatUser = $this->sertifikatModel->getSertifikatByUser($userId);

        // Sertifikat Berdasarkan Prestasi
        $prestasiUser = $this->userPrestasiModel
            ->select('prestasi.id, prestasi.nama_kegiatan')
            ->join('prestasi', 'prestasi.id = user_prestasi.prestasi_id')
            ->where('user_prestasi.user_id', $userId)
            ->findAll();
        $sertifikatPrestasi = [];
        foreach ($prestasiUser as $prestasi) {
            $sertifikatPrestasi[$prestasi['nama_kegiatan']] = $this->sertifikatModel->getSertifikatByPrestasi($prestasi['id']);
        }

        // Sertifikat Berdasarkan Kelas
        $kelasUser = $this->kelasModel->getClassesByUserId($userId);
        $sertifikatKelas = [];
        foreach ($kelasUser as $kelas) {
            $sertifikatKelas[$kelas['nama_kelas']] = $this->sertifikatModel->getSertifikatByKelas($kelas['id']);
        }

        $data = [
            'title' => 'Sertifikat',
            'sertifikatUser' => $sertifikatUser,
            'sertifikatPrestasi' => $sertifikatPrestasi,
            'sertifikatKelas' => $sertifikatKelas,
        ];

        $this->renderViewDashboardSiswa('siswa/prestasi_nilai/sertifikat', $data);
    }

}
