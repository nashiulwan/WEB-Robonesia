<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('', function ($routes) {
    // Routes untuk halaman utama dan public
    $routes->get('/', 'PagesController::index');
    $routes->get('/beranda', 'PagesController::index');

    $routes->get('/pages/hubungi', 'PagesController::hubungi');
    $routes->get('/hubungi', 'PagesController::hubungi');

    $routes->get('/pages/galeri', 'PagesController::galeri');
    $routes->get('/galeri', 'PagesController::galeri');

    $routes->get('/pages/partner', 'PagesController::partner');
    $routes->get('/partner', 'PagesController::partner');

    $routes->get('/pages/program', 'PagesController::program');
    $routes->get('/program', 'PagesController::program');

    $routes->get('/pages/tentang', 'PagesController::tentang');
    $routes->get('/tentang', 'PagesController::tentang');

    $routes->get('/pages/testimoni', 'PagesController::testimoni');
    $routes->get('/testimoni', 'PagesController::testimoni');

    $routes->get('/pages/tim', 'PagesController::tim');
    $routes->get('/tim', 'PagesController::tim');

    $routes->get('/pages/blog', 'BlogController::index');
    $routes->get('/blog', 'BlogController::index');

    $routes->get('/(:segment)', 'BlogController::artikel/$1'); // Menampilkan detail artikel

    $routes->get('/login', 'AuthController::login');
});

$routes->group('auth', function ($routes) {
    // Routes untuk otentikasi
    $routes->get('login', 'AuthController::login');
    $routes->get('register', 'AuthController::register');
    $routes->get('logout', 'AuthController::logout');
});

$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    // Routes untuk admin area (protected dengan filter auth)
    $routes->get('dashboard', 'AdminController::dashboard');
    $routes->get('pengguna', 'AdminController::pengguna');
    $routes->get('seo', 'AdminController::seo');
    $routes->get('pengaturan', 'AdminController::pengaturan');
    $routes->get('analytics', 'AdminController::analytics');
    $routes->get('profil', 'AdminController::profil');


    // Routes untuk artikel
    $routes->get('artikel', 'ArtikelController::index'); // Menampilkan daftar artikel
    $routes->get('artikel/tambah', 'ArtikelController::tambah'); // Menampilkan form tambah
    $routes->post('artikel/simpan', 'ArtikelController::simpan'); // Menyimpan artikel
    $routes->get('artikel/edit/(:num)', 'ArtikelController::edit/$1'); // Menampilkan form edit
    $routes->post('artikel/update/(:num)', 'ArtikelController::update/$1'); // Mengupdate artikel
    $routes->post('artikel/delete/(:num)', 'ArtikelController::delete/$1'); // Menghapus artikel


    // Routes untuk pengaturan
    $routes->get('pengaturan', 'PengaturanController::index');
    $routes->get('pengaturan/galeri', 'PengaturanController::galeri');
    $routes->get('pengaturan/mitra', 'PengaturanController::mitra');
    $routes->get('pengaturan/tim', 'PengaturanController::tim');
    $routes->get('pengaturan/prestasi', 'PengaturanController::prestasi');

    $routes->get('pengaturan/kontak', 'PengaturanController::kontak');
    $routes->post('pengaturan/kontak/update', 'PengaturanController::updateKontak');

});

// $routes->get('/testcrudcontroller', 'TestCrudController::index');
