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

    public function index() {

        if (!logged_in()) {
            return redirect()->to('/login');
        }
        $data = [
            'title' => 'Daftar Produk',
            'shop' => $this->shopModel->findAll()
        ];

        return view('admin/shop/index', $data);
    }
}


    