<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class LoginRedirectFilter implements FilterInterface
{
  public function before(RequestInterface $request, $arguments = null)
  {
    if (! session()->get('is_logged_in')) {
      session()->set('redirect_url', current_url());

      return redirect()->to('auth/login');
    }
  }

  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
