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

    public function kelasSaya()
    {
        $userId = $this->user->id;

        $data = [
            'title'         => 'Kelas Saya',
            'kelasSaya'     => $this->kelasModel->getClassesByUserId($userId),
        ];

        $this->renderViewDashboardSiswa('siswa/kelas_saya/index', $data);
    }

    public function kelasSayaDetail($kelasId)
    {
        $userId = $this->user->id;
        $members = $this->kelasModel->getAnggotaByKelas($kelasId);
        $kelas = $this->kelasModel->getClassWithMemberCountById($kelasId);

        $data = [
            'title'         => 'Informasi Kelas',
            'members' => $members,
            'kelas'     => $kelas,
            'userId'  => $userId,
        ];

        $this->renderViewDashboardSiswa('siswa/kelas_saya/detail', $data);
    }

    public function gabungKelas()
    {
        $userId = $this->user->id;

        $data = [
            'title'         => 'Gabung Kelas',
        ];

        $this->renderViewDashboardSiswa('siswa/kelas_saya/gabung_kelas', $data);
    }

    public function kelasSearch()
    {

        $userId = $this->user->id;

        $kode = $this->request->getGet('kode');

        if ($kode) {
            // Gunakan metode explicit SQL untuk memastikan case-sensitive comparison
            $db = \Config\Database::connect();
            $query = $db->query("SELECT * FROM manage_kelas WHERE BINARY kode_kelas = ?", [$kode]);
            $kelas = $query->getRowArray(); // Mengambil satu hasil dalam bentuk array

            if (!$kelas) {
                session()->setFlashdata('error', 'Kelas tidak ditemukan. Silahkan periksa kembali kode kelas Anda.');
            }
        } else {
            $kelas = [];
        }

        $data = [
            'title' => 'Gabung Kelas',
            'kelas' => $kelas,
            'userId'  => $userId,
        ];

        return view('siswa/kelas_saya/gabung_kelas', $data);
    }

    public function kelasGabung($kelasId, $userId)
    {
        $result = $this->kelasModel->addAnggota($kelasId, $userId);

        if ($result === 'already_joined') {
            session()->setFlashdata('error', 'Anda sudah bergabung di kelas ini.');
        } elseif ($result === false) {
            session()->setFlashdata('error', 'Gagal bergabung di kelas. Silahkan coba lagi.');
        } else {
            session()->setFlashdata('success', 'Berhasil bergabung di kelas.');
        }

        return redirect()->to(base_url('siswa/kelas'));
    }

    public function kelasKeluar($kelasId, $userId)
    {
        $result = $this->kelasModel->removeAnggota($kelasId, $userId);

        if ($result) {
            session()->setFlashdata('success', 'Anda berhasil keluar dari kelas.');
        } else {
            session()->setFlashdata('error', 'Gagal keluar dari kelas. Silahkan coba lagi.');
        }

        // Redirect ke halaman kelas siswa (sesuaikan URL redirect dengan alur aplikasi Anda)
        return redirect()->to(base_url('siswa/kelas'));
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
        $nama = $this->user->username ?? fullname;
        
        

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

        // Ambil sertifikat berdasarkan kelas & user
        $sertifikatKelas = $this->sertifikatModel->getSertifikatByKelasDanUser($userId, $nama);
        

        $data = [
            'title' => 'Sertifikat',
            'sertifikatUser' => $sertifikatUser,
            'sertifikatPrestasi' => $sertifikatPrestasi,
            'sertifikatKelas' => $sertifikatKelas,
        ];

        $this->renderViewDashboardSiswa('siswa/prestasi_nilai/sertifikat', $data);
    }
    
    /**
    public function viewPdf($filename)
    {
        $filepath = WRITEPATH . 'uploads/' . $filename;
    
        if (file_exists($filepath)) {
            return $this->response
                ->setHeader('Content-Type', 'application/pdf')
                ->setHeader('Content-Disposition', 'inline; filename="' . $filename . '"')
                ->setBody(file_get_contents($filepath));
        }
    
        return $this->response->setStatusCode(404, 'File Not Found');
    }
    **/

}
