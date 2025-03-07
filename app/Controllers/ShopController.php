<?php

namespace App\Controllers;

use App\Models\ShopModel;

class ShopController extends BaseController
{
    protected $shopModel;
    public function __construct()
    {
        $this->shopModel = new ShopModel();
    }

    public function index()
    {

        if (!logged_in()) {
            return redirect()->to('/login');
        }
        $data = [
            'title' => 'Daftar Produk',
            'shop' => $this->shopModel->findAll()
        ];

        return view('admin/shop/index', $data);
    }

    public function tambah()
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Tambah Produk',
        ];

        return view('admin/shop/tambah', $data); // Kirim data ke view
    }

    public function simpan()
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }

        $shopModel = new ShopModel();

        $validationRules = [
            'nama_produk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama produk wajib diisi.'
                ]
            ],
            'harga' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Harga produk wajib diisi.',
                ]
            ],
            'deskripsi_produk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Deskripsi tidak boleh kosong.'
                ]
            ],
            'gambar_produk' => [
                'rules' => 'uploaded[gambar]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Gambar harus diunggah.',
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
            $file->move(FCPATH . 'uploads/shop/', $fileName);
            $data['gambar'] = $fileName;
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal mengunggah gambar.');
        }

        // Simpan shop menggunakan instance model langsung
        $success = $shopModel->save([
            'nama_produk' => $this->request->getPost('nama_produk'),
            'deskripsi_produk' => $this->request->getVar('deskripsi_produk', FILTER_UNSAFE_RAW),
            'harga' => $this->request->getPost('harga'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'gambar_produk' => $fileName,
        ]);

        if ($success) {
            return redirect()->to('/admin/shop')->with('success', 'Produk berhasil ditambahkan!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan produk, silakan coba lagi.');
        }
    }

    public function delete($id)
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }

        $shopModel = new ShopModel();
        $shop = $shopModel->find($id);

        if (empty($shop)) {
            return redirect()->to('/admin/shop')->with('error', 'Produk tidak ditemukan.');
        }

        // Hapus gambar jika ada
        if (!empty($shop['gambar']) && file_exists(FCPATH . 'uploads/' . $shop['gambar'])) {
            unlink(FCPATH . 'uploads/' . $shop['gambar']);
        }

        // Hapus shop
        $shopModel->delete($id);

        return redirect()->to('/admin/shop')->with('success', 'Artikel berhasil dihapus!');
    }

    public function edit($id)
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }

        $shopModel = new ShopModel();
        $shop = $shopModel->find($id);


        if (empty($shop)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Edit Produk',
            'shop' => $shop,
        ];

        return view('admin/shop/edit', $data);
    }
    public function update($id)
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }

        $shopModel = new ShopModel();
        $shop = $shopModel->find($id);

        if (empty($shop)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $validationRules = [
            'nama_produk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama produk wajib diisi.'
                ]
            ],
            'harga' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Harga produk wajib diisi.',
                ]
            ],
            'deskripsi_produk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Deskripsi tidak boleh kosong.'
                ]
            ],
            'gambar_produk' => [
                'rules' => 'is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'is_image' => 'File harus berupa gambar.',
                    'mime_in' => 'Format gambar harus JPG, JPEG, atau PNG.'
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Ambil inputan dari form dan buat data array awal
        $data = [
            'nama_produk'       => $this->request->getPost('nama_produk'),
            'deskripsi_produk'  => $this->request->getVar('deskripsi_produk', FILTER_UNSAFE_RAW),
            'harga'             => $this->request->getPost('harga'),
            'updated_at'        => date('Y-m-d H:i:s'),
        ];

        // Cek jika ada file gambar baru yang diunggah
        $file = $this->request->getFile('gambar');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Hapus gambar lama jika ada
            if (!empty($shop['gambar_produk']) && file_exists(FCPATH . 'uploads/shop/' . $shop['gambar_produk'])) {
                unlink(FCPATH . 'uploads/shop/' . $shop['gambar_produk']);
            }

            // Buat nama file acak dan pindahkan file ke folder uploads/shop/
            $fileName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/shop/', $fileName);
            $data['gambar_produk'] = $fileName;
        }

        // Cek apakah ada perubahan data sebelum update
        // (hanya membandingkan field yang ada di $data, sehingga jika gambar tidak diubah, field tersebut tidak akan ikut dibandingkan)
        $changes = array_diff_assoc($data, $shop);
        if (empty($changes)) {
            return redirect()->back()->with('error', 'Tidak ada perubahan yang dilakukan.');
        }

        // Jalankan update
        if ($shopModel->update($id, $data)) {
            return redirect()->to('/admin/shop')->with('success', 'Produk berhasil diperbarui!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan Produk, silakan coba lagi.');
        }
    }
}
