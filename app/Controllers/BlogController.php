<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KategoriModel;
use App\Models\ArtikelModel;

class BlogController extends BaseController
{
    protected $artikelModel;

    public function __construct() {
        $this->artikelModel = new ArtikelModel();
    }

    public function index()
    {   
        // $this->load->model('ArtikelModel'); // Memuat model
        $data = [
            'title' => 'BLOG',
            'artikel' => $this->artikelModel->getArtikelWithKategori(), // Data artikel dengan kategori
        ];
        // $data['artikel'] = $model->where('status', 'publish')->orderBy('created_at', 'DESC')->findAll();
        
        // return view('/pages/blog', $data);
    }
}