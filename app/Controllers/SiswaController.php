<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class SiswaController extends BaseController
{
    public function dashboard()
    {
        $data = [
            'title' => 'Dashboard Siswa'
        ];
        return view('siswa/dashboard', $data);
    }
}
