<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ShopModel;
use App\Models\KontakModel;

class FrontShopController extends BaseController
{
    protected $shopModel;
    protected $KontakModel;

    public function __construct()
    {
        $this->shopModel = new ShopModel();
        $this->kontakModel = new KontakModel();
    }

    public function convertOembedToIframe($content)
    {
        return preg_replace_callback(
            '/<oembed url="(.*?)"><\/oembed>/i',
            function ($matches) {
                $url = $matches[1];

                // Konversi URL Youtube ke format embed
                if (strpos($url, 'youtube.com') !== false || strpos($url, 'youtu.be') !== false) {
                    return '<iframe width="100%" height="400" src="' . str_replace("watch?v=", "embed/", $url) . '" frameborder="0" allowfullscreen></iframe>';
                }

                return $matches[0]; // Jika bukan YouTube, tetap tampilkan seperti biasa
            },
            $content
        );
    }


    public function index()
    {
        $data = [
            'title' => 'Robonesia | SHOP',
            'shop' => $this->shopModel
                ->orderBy('created_at', 'DESC')
                ->findAll(),
            'kontak' => $this->kontakModel->first()
        ];


        echo view('layout/header', $data);
        echo view('pages/shop');
        echo view('layout/footer');
    }

    // public function artikel($slug)
    // {
    //     // Mencari artikel berdasarkan slug
    //     $artikel = $this->artikelModel->where('slug', $slug)->first();

    //     // Jika artikel tidak ditemukan
    //     if (!$artikel) {
    //         throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    //     }


    //     // Ambil artikel terbaru kecuali artikel yang sedang ditampilkan
    //     $artikelTerbaru = $this->artikelModel
    //         ->where('status', 'publish')
    //         ->where('slug !=', $slug) // Filter agar tidak termasuk artikel yang sedang dibuka
    //         ->orderBy('created_at', 'DESC')
    //         ->findAll(5); // Ambil 5 artikel terbaru

    //     // Ambil kategori unik dari artikel
    //     $kategori = $this->artikelModel
    //         ->select('kategori, slug')
    //         ->distinct()
    //         ->findAll();

    //     $artikel['konten'] = $this->convertOembedToIframe(html_entity_decode($artikel['konten']));

    //     // Kirim data artikel ke view
    //     $data = [
    //         'title' => $artikel['judul'],
    //         'artikel' => $artikel,
    //         'artikelTerbaru' => $artikelTerbaru, // Kirim daftar artikel terbaru
    //         'kategori' => $kategori,
    //         'kontak' => $this->kontakModel->first() // Tambahkan data kontak
    //     ];

    //     echo view('layout/header', $data);
    //     echo view('pages/blog/artikel');
    //     echo view('layout/footer');
    // }
    public function shop($nama_produk)
    {
        $produk = $this->shopModel->where('nama_produk', $nama_produk)->first();

        if (!$produk) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $produkLainnya = $this->shopModel
            ->where('nama_produk !=', $nama_produk)
            ->orderBy('created_at', 'DESC')
            ->findAll(4);

        $produk['deskripsi_produk'] = $this->convertOembedToIframe(html_entity_decode($produk['deskripsi_produk']));

        $data = [
            'title' => $produk['nama_produk'],
            'produk' => $produk,
            'produkLainnya' => $produkLainnya,
            'kontak' => $this->kontakModel->first()
        ];

        echo view('layout/header', $data);
        echo view('pages/shop/produk', $data);
        echo view('layout/footer');
    }


    public function kategori($kategoriSlug)
    {
        //     // Ambil artikel berdasarkan kategori
        //     $artikelByKategori = $this->artikelModel
        //         ->where('status', 'publish')
        //         ->where('kategori', $kategoriSlug) // Filter berdasarkan kategori
        //         ->orderBy('created_at', 'DESC')
        //         ->findAll();

        //     // Jika tidak ada artikel dalam kategori ini
        //     if (empty($artikelByKategori)) {
        //         $message = "Belum ada artikel dalam kategori ini.";
        //     } else {
        //         $message = null;
        //     }

        //     $data = [
        //         'title' => 'Kategori: ' . ucfirst($kategoriSlug),
        //         'artikel' => $artikelByKategori,
        //         'message' => $message,
        //         'kontak' => $this->kontakModel->first() // Tambahkan data kontak
        //     ];

        //     echo view('layout/header', $data);
        //     echo view('pages/blog/kategori');
        //     echo view('layout/footer');
    }
}
