<?php

namespace App\Controllers;
use App\Models\KontakModel;

class PagesController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Robonesia | Rumah Robot Indonesia'
        ];
        echo view('layout/header', $data);
        echo view('pages/home');
        echo view('layout/footer');
    }

    public function hubungi()
    {
        $data = [
            'title' => 'Robonesia | Hubungi Kami'
        ];
        echo view('layout/header', $data);
        echo view('pages/hubungi');
        echo view('layout/footer');
    }

    public function galeri()
    {
        $data = [
            'title' => 'Robonesia | Galeri'
        ];
        echo view('layout/header', $data);
        echo view('pages/galeri');
        echo view('layout/footer');
    }

    public function partner()
    {
        $data = [
            'title' => 'Robonesia | Mitra Kami'
        ];
        echo view('layout/header', $data);
        echo view('pages/partner');
        echo view('layout/footer');
    }

    public function program()
    {
        $data = [
            'title' => 'Robonesia | Program Belajar'
        ];
        echo view('layout/header', $data);
        echo view('pages/program');
        echo view('layout/footer');
    }

    public function tentang()
    {
        $data = [
            'title' => 'Robonesia | Tentang Kami'
        ];
        echo view('layout/header', $data);
        echo view('pages/tentang');
        echo view('layout/footer');
    }

    public function testimoni()
    {
        $data = [
            'title' => 'Robonesia | Testimoni'
        ];
        echo view('layout/header', $data);
        echo view('pages/testimoni');
        echo view('layout/footer');
    }

    public function tim()
    {
        $data = [
            'title' => 'Robonesia | Tim Kami'
        ];
        echo view('layout/header', $data);
        echo view('pages/tim');
        echo view('layout/footer');
    }
}
