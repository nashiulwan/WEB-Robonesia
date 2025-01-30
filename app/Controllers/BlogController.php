<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ArtikelModel;

class BlogController extends BaseController
{
    protected $artikelModel;

    public function __construct() {
        $this->artikelModel = new ArtikelModel();
    }

    public function index()
    {   
        $data = [
            'title' => 'Robonesia | BLOG',
            'artikel' => $this->artikelModel
                ->where('status', 'publish')
                ->orderBy('created_at', 'DESC')
                ->findAll(), // Mengambil artikel yang sudah dipublish
        ];

        echo view('layout/header', $data);
        echo view('pages/blog');
        echo view('layout/footer');
    }
    
    public function detail($slug)
    {
        // Mencari artikel berdasarkan slug
        $artikel = $this->artikelModel->where('slug', $slug)->first();

        // Jika artikel tidak ditemukan
        if (!$artikel) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Kirim data artikel ke view
        $data = [
            'title' => $artikel['judul'],
            'artikel' => $artikel,
        ];

        echo view('layout/header', $data);
        echo view('pages/blog/detail');
        echo view('layout/footer');
    }

}