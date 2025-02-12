<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\KontakModel;
use App\Models\PartnerModel;
use App\Models\TimModel;

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

    public function editMitra($id = null)
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }   

        if ($id === null) {
            return redirect()->to('/admin/pengaturan/mitra')->with('error', 'ID tidak ditemukan');
        }

        $model = new PartnerModel();
        $mitra = $model->find($id);

        if (!$mitra) {
            return redirect()->to('/admin/pengaturan/mitra')->with('error', 'Anggota tim tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Partner',
            'mitra' => $mitra
        ];
        return view('admin/pengaturan/mitra/edit', $data);
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
                    'uploaded' => 'Logo harus diunggah.',
                    'max_size' => 'Ukuran logo maksimal adalah 5MB.',
                    'is_image' => 'File harus berupa gambar.',
                    'mime_in' => 'Format logo harus JPG, JPEG, atau PNG.'
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('logo');
        if ($file->isValid() && !$file->hasMoved()) {
            $filePath = $file->getTempName();
            list($width, $height) = getimagesize($filePath); // Mendapatkan dimensi gambar

            if ($width !== $height) {
                return redirect()->back()->withInput()->with('error', 'Logo harus memiliki rasio aspek 1:1 (persegi).');
            }

            $fileName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/', $fileName);

            $data = [
                'partner' => $this->request->getPost('partner'),
                'alamat' => $this->request->getPost('alamat'),
                'maps' => $this->request->getPost('maps'),
                'logo' => $fileName,
            ];

            if ($model->save($data)) {
                return redirect()->to('/admin/pengaturan/mitra')->with('success', 'Mitra berhasil ditambahkan!');
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal menyimpan mitra, silakan coba lagi.');
            }
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal mengunggah logo.');
        }
    }


    public function hapusMitra($id)
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }
    
        $model = new PartnerModel();
    
        // Cek apakah data mitra ada
        $mitra = $model->find($id);
        if (!$mitra) {
            return redirect()->to('/admin/pengaturan/mitra')->with('error', 'Mitra tidak ditemukan.');
        }
    
        // Hapus logo jika ada
        if (!empty($mitra['logo']) && file_exists(FCPATH . 'uploads/' . $mitra['logo'])) {
            unlink(FCPATH . 'uploads/' . $mitra['logo']);
        }
    
        // Hapus data mitra dari database
        if ($model->delete($id)) {
            return redirect()->to('/admin/pengaturan/mitra')->with('success', 'Mitra berhasil dihapus.');
        } else {
            return redirect()->to('/admin/pengaturan/mitra')->with('error', 'Gagal menghapus mitra.');
        }
    }
    

    // ==================================================
    // EDIT TIM
    public function tim()
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }   
        $model = new TimModel();
        $tim = $model->findAll();

        $data = [
            'title' => 'Pengaturan Tim',
            'tim' => $tim
        ];
        return view('admin/pengaturan/tim', $data);
    }

    public function tambahTim() 
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }   

        $model = new TimModel();
        $tim = $model->findAll();

        $data = [
            'title' => 'Tambahkan Anggota Tim',
            'tim' => $tim
        ];
        return view('admin/pengaturan/tim/tambah', $data);
    }

    public function editTim($id = null)
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }   

        if ($id === null) {
            return redirect()->to('/admin/pengaturan/tim')->with('error', 'ID tidak ditemukan');
        }

        $model = new TimModel();
        $tim = $model->find($id);

        if (!$tim) {
            return redirect()->to('/admin/pengaturan/tim')->with('error', 'Anggota tim tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Anggota Tim',
            'tim' => $tim
        ];
        return view('admin/pengaturan/tim/edit', $data);
    }


    public function simpanTim()
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }

        if (!$this->validate([
            'nama' => 'required|min_length[3]',
            'peran' => 'required',
            'foto' => 'is_image[foto]|mime_in[foto,image/png,image/jpeg,image/jpg]|max_size[foto,2048]'
        ])) {
            return redirect()->to('/admin/pengaturan/tim/tambah')->with('error', 'Pastikan data valid dan ukuran foto tidak lebih dari 2MB.');
        }

        $model = new TimModel();
        $foto = $this->request->getFile('foto');

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $fotoName = $foto->getRandomName();
            $foto->move('uploads/tim/', $fotoName);
        } else {
            $fotoName = 'default.svg';
        }

        $data = [
            'nama' => $this->request->getPost('nama'),
            'peran' => $this->request->getPost('peran'),
            'foto' => $fotoName,
            'facebook' => $this->request->getPost('facebook'),
            'whatsapp' => $this->request->getPost('whatsapp'),
            'twitter' => $this->request->getPost('twitter'),
            'instagram' => $this->request->getPost('instagram'),
        ];

        if ($model->insert($data)) {
            return redirect()->to('/admin/pengaturan/tim')->with('success', 'Anggota tim berhasil ditambahkan');
        } else {
            return redirect()->to('/admin/pengaturan/tim/tambah')->with('error', 'Gagal menambahkan anggota tim');
        }
    }



    public function updateTim($id)
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }

        $model = new TimModel();
        $tim = $model->find($id);

        if (empty($tim)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Validasi input
        $validationRules = [
            'nama' => [
                'rules' => 'required',
                'errors' => ['required' => 'Nama anggota tim wajib diisi.']
            ],
            'peran' => [
                'rules' => 'required',
                'errors' => ['required' => 'Peran anggota tim wajib diisi.']
            ],
            'foto' => [
                'rules' => 'max_size[foto,5000]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran foto maksimal 5MB.',
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
            'nama' => $this->request->getPost('nama'),
            'peran' => $this->request->getPost('peran'),
            'facebook' => $this->request->getPost('facebook'),
            'whatsapp' => $this->request->getPost('whatsapp'),
            'twitter' => $this->request->getPost('twitter'),
            'instagram' => $this->request->getPost('instagram'),
        ];

        // Cek jika ada foto baru yang diunggah
        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            // Hapus foto lama jika bukan default
            if (!empty($tim['foto']) && $tim['foto'] !== 'default.jpg' && file_exists(FCPATH . 'uploads/tim/' . $tim['foto'])) {
                unlink(FCPATH . 'uploads/tim/' . $tim['foto']);
            }

            // Upload foto baru
            $fotoName = $foto->getRandomName();
            $foto->move(FCPATH . 'uploads/tim/', $fotoName);
            $data['foto'] = $fotoName;
        } else {
            $data['foto'] = $tim['foto']; // Gunakan foto lama jika tidak ada unggahan baru
        }

        // Cek apakah ada perubahan data sebelum update
        if ($tim == $data) {
            return redirect()->back()->with('error', 'Tidak ada perubahan yang dilakukan.');
        }

        // Jalankan update
        if ($model->update($id, $data)) {
            return redirect()->to('/admin/pengaturan/tim')->with('success', 'Data tim berhasil diperbarui.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data, silakan coba lagi.');
        }
    }




    public function hapusTim($id)
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }   

        $model = new TimModel();
        $tim = $model->find($id);

        if (!$tim) {
            return redirect()->to('/admin/pengaturan/tim')->with('error', 'Data tim tidak ditemukan');
        }

        if ($tim['foto'] !== 'default.jpg') {
            unlink('uploads/tim/' . $tim['foto']);
        }

        $model->delete($id);

        return redirect()->to('/admin/pengaturan/tim')->with('success', 'Data tim berhasil dihapus');
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
