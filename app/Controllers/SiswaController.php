<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ArtikelModel;
use App\Models\NotifikasiModel;

class SiswaController extends BaseController
{
    protected $artikelModel;
    protected $notifikasiModel;

    public function __construct()
    {
        $this->artikelModel = new ArtikelModel();
        $this->notifikasiModel = new NotifikasiModel();
    }

    public function dashboard()
    {

        $data = [
            'title'             => 'Dashboard Siswa',
            'event_artikel'     => $this->artikelModel->where('kategori', 'event')
                ->where('created_at >=', date('Y-m-d', strtotime('-30 days')))
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
    public function eventLomba()
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
}
