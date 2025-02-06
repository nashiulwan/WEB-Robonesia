<?php

namespace App\Controllers;

use Myth\Auth\Config\Auth;
use CodeIgniter\Controller;
use CodeIgniter\Session\Session;
use Myth\Auth\Config\Auth as AuthConfig;
use App\Libraries\CaptchaLib;
use Myth\Auth\Controllers\AuthController as MythAuthController;


class AuthController extends Controller
{

  protected $auth;

  /**
   * @var AuthConfig
   */
  protected $config;

  /**
   * @var Session
   */
  protected $session;

  public function __construct()
  {
    // Most services in this controller require
    // the session to be started - so fire it up!
    $this->session = service('session');

    $this->config = config('Auth');
    $this->auth   = service('authentication');
  }

  public function login()
  {
    $captchaLib = new CaptchaLib();
    $captchaImage = $captchaLib->generateCaptcha();

    $data = [
      'title' => 'Robonesia | Login',
      'captcha_image' => $captchaImage,
    ];

    return view('auth/login', $data);
  }

  public function attemptLogin()
  {
    $captchaInput = $this->request->getPost('captcha_answer');

    $captchaLib = new CaptchaLib();
    if (!$captchaLib->validateCaptcha($captchaInput)) {
      return redirect()->back()->withInput()->with('error', 'Captcha salah. Silakan coba lagi.');
    }

    $rules = [
      'login'    => 'required',
      'password' => 'required',
    ];
    if ($this->config->validFields === ['email']) {
      $rules['login'] .= '|valid_email';
    }

    if (! $this->validate($rules)) {
      return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    $login    = $this->request->getPost('login');
    $password = $this->request->getPost('password');
    $remember = (bool) $this->request->getPost('remember');

    // Determine credential type
    $type = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

    // Try to log them in...
    if (! $this->auth->attempt([$type => $login, 'password' => $password], $remember)) {
      return redirect()->back()->withInput()->with('error', $this->auth->error() ?? lang('Auth.badAttempt'));
    }

    // Is the user being forced to reset their password?
    if ($this->auth->user()->force_pass_reset === true) {
      return redirect()->to(route_to('reset-password') . '?token=' . $this->auth->user()->reset_hash)->withCookies();
    }

    $redirectURL = session('redirect_url') ?? site_url('/admin/dashboard');
    unset($_SESSION['redirect_url']);

    return redirect()->to($redirectURL)->withCookies()->with('message', lang('Auth.loginSuccess'));
  }

  public function logout()
  {
    // Memanggil fungsi logout bawaan Myth/Auth
    service('authentication')->logout();

    // Redirect ke halaman login atau halaman lain sesuai kebutuhan
    return redirect()->to('auth/login')->with('success', 'Anda berhasil logout.');
  }

  public function register(): string
  {
    // Menampilkan halaman registrasi, pastikan view register ada
    return view('auth/register');
  }

  public function admin(): string
  {
    // Menampilkan halaman dashboard admin setelah login berhasil
    return view('admin/dashboard');
  }
}
