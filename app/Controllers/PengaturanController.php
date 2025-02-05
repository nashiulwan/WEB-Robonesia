<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\KontakModel;

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
        $model = new KontakModel();
        $kontak = $model->first(); // Ambil data pertama dari tabel
        
        return view('admin/pengaturan/kontak', [
            'title' => 'Pengaturan Kontak',
            'kontak' => $kontak
        ]);
    }

    public function updateKontak()
    {
        $model = new KontakModel();

        $data = [
            'no_hp' => $this->request->getPost('no_hp'),
            'email' => $this->request->getPost('email'),
            'alamat' => $this->request->getPost('alamat'),
            'maps' => $this->request->getPost('maps'),
            'facebook' => $this->request->getPost('facebook'),
            'instagram' => $this->request->getPost('instagram'),
            'x' => $this->request->getPost('x'),
            'tiktok' => $this->request->getPost('tiktok'),
            'youtube' => $this->request->getPost('youtube'),
        ];

        $model->update(1, $data);

        return redirect()->back()->with('success', 'Pengaturan kontak berhasil diperbarui!');
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
