<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KategoriModel;
use App\Models\ArtikelModel;

class BlogController extends BaseController
{
    public function index()
    {
        $model = new ArtikelModel();
        $data['artikel'] = $model->where('status', 'publish')->orderBy('created_at', 'DESC')->findAll();
        
        return view('/pages/blog', $data);
    }
}