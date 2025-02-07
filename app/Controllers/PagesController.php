<?php

namespace App\Controllers;
// use App\Models\PartnerModel;

class PagesController extends BaseController
{
    // protected $partnerModel;

    // public function __construct() {
    //     $this->partnerModel = new PartnerModel();
    // }

    public function index()
    {
        $data = [
            'title' => 'Robonesia | Rumah Robot Indonesia', 
            // 'partner' => $this->partnerModel->findAll()
        ];
        $this->renderView('pages/home', $data);
    }

    public function hubungi()
    {
        $data = ['title' => 'Robonesia | Hubungi Kami',];
        $this->renderView('pages/hubungi', $data);
    }

    public function galeri()
    {
        $data = ['title' => 'Robonesia | Galeri'];
        $this->renderView('pages/galeri', $data);
    }

    public function partner()
    {
        $data = ['title' => 'Robonesia | Mitra Kami'];
        $this->renderView('pages/partner', $data);
    }

    public function program()
    {
        $data = ['title' => 'Robonesia | Program Belajar'];
        $this->renderView('pages/program', $data);
    }

    public function tentang()
    {
        $data = ['title' => 'Robonesia | Tentang Kami'];
        $this->renderView('pages/tentang', $data);
    }

    public function testimoni()
    {
        $data = ['title' => 'Robonesia | Testimoni'];
        $this->renderView('pages/testimoni', $data);
    }

    public function tim()
    {
        $data = ['title' => 'Robonesia | Tim Kami'];
        $this->renderView('pages/tim', $data);
    }
}
