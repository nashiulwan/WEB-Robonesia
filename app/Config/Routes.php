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
    $routes->get('/pages/blog', 'BlogController::index');
    $routes->get('/blog/detail/(:segment)', 'BlogController::detail/$1'); // Menampilkan detail artikel
    // $routes->get('/pages/blog', 'Pages::blog');
    $routes->get('/pages/tim', 'Pages::tim');
    // $routes->get('/pages/blogdetail', 'Pages::blogDetail');
    $routes->get('/login', 'Login::login');
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
    $routes->get('pengguna', 'Admin::pengguna');
    $routes->get('seo', 'Admin::seo');
    $routes->get('pengaturan', 'Admin::pengaturan');
    $routes->get('analytics', 'Admin::analytics');
    $routes->get('profil', 'Admin::profil');


    // Routes untuk artikel
    $routes->get('artikel', 'Artikel::index'); // Menampilkan daftar artikel
    $routes->get('artikel/tambah', 'Artikel::tambah'); // Menampilkan form tambah
    $routes->post('artikel/simpan', 'Artikel::simpan'); // Menyimpan artikel
    $routes->get('artikel/edit/(:num)', 'Artikel::edit/$1'); // Menampilkan form edit
    $routes->post('artikel/update/(:num)', 'Artikel::update/$1'); // Mengupdate artikel
    $routes->get('artikel/hapus/(:num)', 'Artikel::hapus/$1'); // Menghapus artikel
    

});

// $routes->get('/testcrudcontroller', 'TestCrudController::index');
