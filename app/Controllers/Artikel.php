<?php

namespace App\Controllers;

use App\Controllers\BaseController;
// use App\Models\KategoriModel; 
use App\Models\ArtikelModel;

class Artikel extends BaseController
{
    // protected $artikelModel;
    // public function __construct()
    // {
    //     $this->artikelModel = new ArtikelModel();
    // }

    public function index()
    {

        if (!logged_in()) {
            return redirect()->to('/login');
        }   

        $artikelModel = new ArtikelModel();
        $data = [
            'title' => 'Daftar Artikel',
            'artikel' => $artikelModel->findAll(), // Ambil semua artikel
        ];

        return view('admin/artikel/index', $data);
    }

    public function tambah()
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }

        // $kategoriModel = new artikelModel(); // Load kategori
        // $kategoriList = $kategoriModel->select('kategori')->distinct()->findAll();
        $kategoriList = ['Berita', 'Kompetisi', 'Event', 'Belajar', 'Lainnya'];


        // Jika tidak ada kategori sama sekali, set default ke kategori Lainnya
        // if (empty($kategoriList)) {
        //     $kategoriList = [['kategori'=>'Lainnya']];
        // }

        $data = [
            'title' => 'Tambah Artikel',
            'kategoriList' => $kategoriList,
        ];

        return view('admin/artikel/tambah', $data); // Kirim data ke view
    }

    // public function simpan()
    // {
    //     $artikelModel = new ArtikelModel();
    //     $validKategori = ['Berita', 'Kompetisi', 'Event', 'Belajar', 'Lainnya'];

    //     $validation = $this->validate([
    //         'judul' => 'required',
    //         'kategori' => 'required|in_list[Berita,Kompetisi,Event,Belajar,Lainnya]',
    //         'konten' => 'required',
    //         'gambar' => 'uploaded[gambar]|max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
    //     ]);

    //     if (!$validation) {
    //         return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    //     }

    //     // Upload gambar
    //     $file = $this->request->getFile('gambar');
    //     $fileName = $file->getRandomName();
    //     $file->move(WRITEPATH . 'uploads', $fileName);

    //     // Simpan artikel
    //     artikelModel->save([
    //         'judul' => $this->request->getPost('judul'),
    //         'slug' => url_title($this->request->getPost('judul'), '-', true),
    //         'konten' => $this->request->getPost('konten'),
    //         'kategori' => $this->request->getPost('kategori'),
    //         // 'penulis_id' => 1,
    //         'status' => 'publish',
    //         'created_at' => date('Y-m-d H:i:s'),
    //         'updated_at' => date('Y-m-d H:i:s'),
    //         'gambar' => $fileName,
    //     ]);

    //     return redirect()->to('/admin/artikel')->with('success', 'Artikel berhasil ditambahkan!');
    // }

    public function simpan()
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }

        $artikelModel = new ArtikelModel();

        $validationRules = [
            'judul' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Judul artikel wajib diisi.'
                ]
            ],
            'kategori' => [
                'rules' => 'required|in_list[Berita,Kompetisi,Event,Belajar,Lainnya]',
                'errors' => [
                    'required' => 'Kategori harus dipilih.',
                    'in_list' => 'Kategori yang dipilih tidak valid.'
                ]
            ],
            'konten' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Konten artikel tidak boleh kosong.'
                ]
            ],
            'gambar' => [
                'rules' => 'uploaded[gambar]|max_size[gambar,5000]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Gambar harus diunggah.',
                    'max_size' => 'Ukuran gambar maksimal adalah 5MB.',
                    'is_image' => 'File harus berupa gambar.',
                    'mime_in' => 'Format gambar harus JPG, JPEG, atau PNG.'
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Upload gambar
        $file = $this->request->getFile('gambar');
        if ($file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/', $fileName);
            $data['gambar'] = $fileName;
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal mengunggah gambar.');
        }

        // Simpan artikel menggunakan instance model langsung
        $success = $artikelModel->save([
            'judul' => $this->request->getPost('judul'),
            'slug' => url_title($this->request->getPost('judul'), '-', true),
            'konten' => $this->request->getPost('konten'),
            'kategori' => $this->request->getPost('kategori'),
            'penulis_id' => 1,
            'status' => 'publish',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'gambar' => $fileName,
        ]);

        if ($success) {
            return redirect()->to('/admin/artikel')->with('success', 'Artikel berhasil ditambahkan!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan artikel, silakan coba lagi.');
        }

    }

    public function edit($id)
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }

        $artikelModel = new ArtikelModel();
        $artikel = $artikelModel->find($id);

        if (empty($artikel)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $kategoriList = ['Berita', 'Kompetisi', 'Event', 'Belajar', 'Lainnya'];

        $data = [
            'title' => 'Edit Artikel',
            'artikel' => $artikel,
            'kategoriList' => $kategoriList,
        ];

        return view('admin/artikel/edit', $data);
    }

    public function update($id)
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }

        $artikelModel = new ArtikelModel();
        $artikel = $artikelModel->find($id);

        if (empty($artikel)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $validationRules = [
            'judul' => [
                'rules' => 'required',
                'errors' => ['required' => 'Judul artikel wajib diisi.']
            ],
            'kategori' => [
                'rules' => 'required|in_list[Berita,Kompetisi,Event,Belajar,Lainnya]',
                'errors' => [
                    'required' => 'Kategori harus dipilih.',
                    'in_list' => 'Kategori yang dipilih tidak valid.'
                ]
            ],
            'konten' => [
                'rules' => 'required',
                'errors' => ['required' => 'Konten artikel tidak boleh kosong.']
            ],
            'gambar' => [
                'rules' => 'max_size[gambar,5000]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar maksimal adalah 5MB.',
                    'is_image' => 'File harus berupa gambar.',
                    'mime_in' => 'Format gambar harus JPG, JPEG, atau PNG.'
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Ambil inputan dari form
        $data = [
            'judul' => $this->request->getPost('judul'),
            'slug' => url_title($this->request->getPost('judul'), '-', true),
            'konten' => $this->request->getPost('konten'),
            'kategori' => $this->request->getPost('kategori'),
            'penulis_id' => 1,
            'status' => 'publish',
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Cek jika ada gambar baru yang diunggah
        $file = $this->request->getFile('gambar');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Hapus gambar lama jika ada
            if (!empty($artikel['gambar']) && file_exists(FCPATH . 'uploads/' . $artikel['gambar'])) {
                unlink(FCPATH . 'uploads/' . $artikel['gambar']);
            }

            // Upload gambar baru
            $fileName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/', $fileName);
            $data['gambar'] = $fileName;
        }

        // Cek apakah ada perubahan data sebelum update
        if ($artikel == $data) {
            return redirect()->back()->with('error', 'Tidak ada perubahan yang dilakukan.');
        }

        // Jalankan update
        if ($artikelModel->update($id, $data)) {
            return redirect()->to('/admin/artikel')->with('success', 'Artikel berhasil diperbarui!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan artikel, silakan coba lagi.');
        }
    }

    public function delete($id)
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }
    
        $artikelModel = new ArtikelModel();
        $artikel = $artikelModel->find($id);
    
        if (empty($artikel)) {
            return redirect()->to('/admin/artikel')->with('error', 'Artikel tidak ditemukan.');
        }
    
        // Hapus gambar jika ada
        if (!empty($artikel['gambar']) && file_exists(FCPATH . 'uploads/' . $artikel['gambar'])) {
            unlink(FCPATH . 'uploads/' . $artikel['gambar']);
        }
    
        // Hapus artikel
        $artikelModel->delete($id);
    
        return redirect()->to('/admin/artikel')->with('success', 'Artikel berhasil dihapus!');
    }
    

}