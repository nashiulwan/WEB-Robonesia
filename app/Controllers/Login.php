<?php

namespace App\Controllers;

use Myth\Auth\Config\Auth;

class Login extends BaseController
{
  public function login(): string
  {

    $data = [
      'title' => 'Robonesia | Login',
      'config' => new Auth()
    ];
    return view('auth/login', $data);
  }

  public function logout()
  {
    // Memanggil fungsi logout bawaan Myth:Auth
    service('authentication')->logout();

    // Redirect ke halaman login atau halaman lain sesuai kebutuhan
    return redirect()->to('auth/login')->with('success', 'Anda berhasil logout.');
  }

  public function register(): string
  {
    return view('auth/register');
  }
  public function admin(): string
  {
    return view('admin/dashboard');
  }
}
