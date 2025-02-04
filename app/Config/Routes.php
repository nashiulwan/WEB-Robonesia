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
    $routes->get('/hubungi', 'Pages::hubungi');

    $routes->get('/pages/galeri', 'Pages::galeri');
    $routes->get('/galeri', 'Pages::galeri');
    
    $routes->get('/pages/partner', 'Pages::partner');
    $routes->get('/partner', 'Pages::partner');

    $routes->get('/pages/program', 'Pages::program');
    $routes->get('/program', 'Pages::program');

    $routes->get('/pages/tentang', 'Pages::tentang');
    $routes->get('/tentang', 'Pages::tentang');

    $routes->get('/pages/testimoni', 'Pages::testimoni');
    $routes->get('/testimoni', 'Pages::testimoni');

    $routes->get('/pages/tim', 'Pages::tim');
    $routes->get('/tim', 'Pages::tim');

    $routes->get('/pages/blog', 'BlogController::index');
    $routes->get('/blog', 'BlogController::index');

    $routes->get('/(:segment)', 'BlogController::artikel/$1'); // Menampilkan detail artikel

    $routes->get('/login', 'Login::login');
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
    $routes->post('artikel/delete/(:num)', 'Artikel::delete/$1'); // Menghapus artikel
});

// $routes->get('/testcrudcontroller', 'TestCrudController::index');
