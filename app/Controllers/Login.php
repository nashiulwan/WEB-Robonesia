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

  public function register(): string
  {
    return view('auth/register');
  }
  public function admin(): string
  {
    return view('admin/dashboard');
  }
}
