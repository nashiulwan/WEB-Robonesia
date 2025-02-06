<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\KontakModel;
use App\Models\PartnerModel;

class PengaturanController extends BaseController
{
    public function index()
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }   

        $data = [
            'title' => 'Pengaturan'
        ];
        return view('admin/pengaturan/index', $data);
    }

    // ==============================================================
    // EDIT KONTAK
    public function kontak()
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }   

        $model = new KontakModel();
        $kontak = $model->first(); // Ambil data pertama dari tabel
        
        return view('admin/pengaturan/kontak', [
            'title' => 'Pengaturan Kontak',
            'kontak' => $kontak
        ]);
    }

    public function updateKontak()
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }   

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

    // ==================================================
    // EDIT GALERI
    public function galeri()
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }   

        $data = [
            'title' => 'Pengaturan Galeri'
        ];
        return view('admin/pengaturan/galeri', $data);
    }

    // ==================================================
    // EDIT MITRA
    public function mitra()
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }   

        $model = new PartnerModel();
        $mitra = $model->findAll();

        $data = [
            'title' => 'Pengaturan Mitra',
            'mitra' => $mitra
        ];
        return view('admin/pengaturan/mitra', $data);
    }

    public function editMitra()
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }   


    }

    public function tambahMitra()
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }   

        $model = new PartnerModel();
        $mitra = $model->findAll();

        $data = [
            'title' => 'Tambahkan Mitra',
            'mitra' => $mitra
        ];
        return view('admin/pengaturan/mitra/tambah', $data);
    }

    public function simpanMitra()
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }  

        $model = new PartnerModel();

        $validationRules = [
            'partner' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Masukkan nama sekolah/mitra.'
                ]
            ],
            'alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Masukkan alamat sekolah/mitra',
                ]
            ],
            'logo' => [
                'rules' => 'uploaded[logo]|max_size[logo,5000]|is_image[logo]|mime_in[logo,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'logo harus diunggah.',
                    'max_size' => 'Ukuran logo maksimal adalah 5MB.',
                    'is_image' => 'File harus berupa logo.',
                    'mime_in' => 'Format logo harus JPG, JPEG, atau PNG.'
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('logo');
        if ($file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/', $fileName);
            $data['logo'] = $fileName;
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal mengunggah logo.');
        }

        // Simpan artikel menggunakan instance model langsung
        $success = $artikelModel->save([
            'partner' => $this->request->getPost('partner'),
            'alamat' => $this->request->getPost('alamat'),
            'maps' => $this->request->getPost('maps'),
            'logo' => $fileName,
        ]);

        if ($success) {
            return redirect()->to('/admin/pengaturan/mitra')->with('success', 'Artikel berhasil ditambahkan!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan artikel, silakan coba lagi.');
        }

        $model->update(1, $data);

        return redirect()->back()->with('success', 'Pengaturan partner berhasil diperbarui!');
    }

    public function deleteMitra()
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }   


    }

    // ==================================================
    // EDIT TIM
    public function tim()
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }   

        $data = [
            'title' => 'Pengaturan Tim'
        ];
        return view('admin/pengaturan/tim', $data);
    }

    // ==================================================
    // EDIT PRESTASI
    public function prestasi()
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }   

        $data = [
            'title' => 'Pengaturan Prestasi'
        ];
        return view('admin/pengaturan/prestasi', $data);
    }
}
