<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 $routes->group('', function ($routes) {
    // Routes untuk halaman utama dan public
    $routes->get('/', 'Pages::index');
    $routes->get('/beranda', 'Pages::index');
    $routes->get('/pages/hubungi', 'Pages::hubungi');
    $routes->get('/pages/galeri', 'Pages::galeri');
    $routes->get('/pages/partner', 'Pages::partner');
    $routes->get('/pages/program', 'Pages::program');
    $routes->get('/pages/tentang', 'Pages::tentang');
    $routes->get('/pages/testimoni', 'Pages::testimoni');
    $routes->get('/pages/blog', 'Pages::blog');
    $routes->get('/pages/tim', 'Pages::tim');
    $routes->get('/pages/blogdetail', 'Pages::blogDetail');
    // $routes->get('/login', 'Login::login');
    // $routes->get('/logout', 'Login::logout');
});

$routes->group('auth', function ($routes) {
    // Routes untuk otentikasi
    $routes->get('login', 'Login::login');
    $routes->get('register', 'Login::register');
    $routes->get('logout', 'Login::logout');
});

$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    // Routes untuk admin area (protected dengan filter auth)
    $routes->get('dashboard', 'Admin::dashboard');
    $routes->get('artikel', 'Admin::artikel');
    $routes->get('artikel/tambah', 'Admin::tambah');
    $routes->get('pengguna', 'Admin::pengguna');
    $routes->get('seo', 'Admin::seo');
    $routes->get('pengaturan', 'Admin::pengaturan');
    $routes->get('analytics', 'Admin::analytics');
});




// $routes->get('/', 'Pages::index');
// $routes->get('/beranda', 'Pages::index');
// $routes->get('/pages/hubungi', 'Pages::hubungi');
// $routes->get('/pages/galeri', 'Pages::galeri');
// $routes->get('/pages/partner', 'Pages::partner');
// $routes->get('/pages/program', 'Pages::program');
// $routes->get('/pages/tentang', 'Pages::tentang');
// $routes->get('/pages/testimoni', 'Pages::testimoni');
// $routes->get('/pages/blog', 'Pages::blog');
// $routes->get('/pages/tim', 'Pages::tim');
// $routes->get('/pages/blogdetail', 'Pages::blogDetail');


// $routes->get('/login', 'Login::login');
// $routes->get('/register', 'Login::register');
// $routes->get('/admin/dashboard', 'Login::admin');
// $routes->get('admin/dashboard', 'Admin::dashboard');
// $routes->get('admin/artikel', 'Admin::artikel');
// $routes->get('admin/artikel/tambah', 'Admin::tambah');
// $routes->get('admin/pengguna', 'Admin::pengguna');
// $routes->get('admin/seo', 'Admin::seo');
// $routes->get('admin/pengaturan', 'Admin::pengaturan');
// $routes->get('admin/analytics', 'Admin::analytics');



// $routes->group('admin', ['filter' => 'login'], function($routes) {
//     $routes->get('dashboard', 'Admin\Dashboard::index');
//     $routes->get('artikel', 'Admin\Artikel::index');
//     $routes->get('artikel/tambah', 'Admin\Artikel::tambah');
    
// });