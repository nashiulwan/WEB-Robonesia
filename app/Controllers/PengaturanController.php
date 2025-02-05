<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class PengaturanController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Pengaturan'
        ];
        return view('admin/pengaturan/index', $data);
    }

    public function kontak()
    {
        $data = [
            'title' => 'Pengaturan Kontak'
        ];
        return view('admin/pengaturan/kontak', $data);
    }

    public function galeri()
    {
        $data = [
            'title' => 'Pengaturan Galeri'
        ];
        return view('admin/pengaturan/galeri', $data);
    }

    public function mitra()
    {
        $data = [
            'title' => 'Pengaturan Mitra'
        ];
        return view('admin/pengaturan/mitra', $data);
    }

    public function tim()
    {
        $data = [
            'title' => 'Pengaturan Tim'
        ];
        return view('admin/pengaturan/tim', $data);
    }

    public function prestasi()
    {
        $data = [
            'title' => 'Pengaturan Prestasi'
        ];
        return view('admin/pengaturan/prestasi', $data);
    }
}
