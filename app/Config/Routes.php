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
    $routes->get('dashboard', 'Admin::dashboard', ['filter' => 'role:admin,guru']);
    $routes->get('pengguna', 'Admin::pengguna', ['filter' => 'role:admin']);
    $routes->get('seo', 'Admin::seo', ['filter' => 'role:admin']);
    $routes->get('pengaturan', 'Admin::pengaturan', ['filter' => 'role:admin']);
    $routes->get('analytics', 'Admin::analytics', ['filter' => 'role:admin']);
    $routes->get('profil', 'Admin::profil', ['filter' => 'role:admin']);


    // Routes untuk artikel
    $routes->get('artikel', 'Artikel::index', ['filter' => 'role:admin']); // Menampilkan daftar artikel
    $routes->get('artikel/tambah', 'Artikel::tambah', ['filter' => 'role:admin']); // Menampilkan form tambah
    $routes->post('artikel/simpan', 'Artikel::simpan', ['filter' => 'role:admin']); // Menyimpan artikel
    $routes->get('artikel/edit/(:num)', 'Artikel::edit/$1', ['filter' => 'role:admin']); // Menampilkan form edit
    $routes->post('artikel/update/(:num)', 'Artikel::update/$1', ['filter' => 'role:admin']); // Mengupdate artikel
    $routes->post('artikel/delete/(:num)', 'Artikel::delete/$1', ['filter' => 'role:admin']); // Menghapus artikel


    // Routes untuk pengaturan
    $routes->get('pengaturan', 'PengaturanController::index', ['filter' => 'role:admin']);
    $routes->get('pengaturan/kontak', 'PengaturanController::kontak', ['filter' => 'role:admin']);
    $routes->get('pengaturan/galeri', 'PengaturanController::galeri', ['filter' => 'role:admin']);
    $routes->get('pengaturan/mitra', 'PengaturanController::mitra', ['filter' => 'role:admin']);
    $routes->get('pengaturan/tim', 'PengaturanController::tim', ['filter' => 'role:admin']);
    $routes->get('pengaturan/prestasi', 'PengaturanController::prestasi', ['filter' => 'role:admin']);
});
// $routes->get('/testcrudcontroller', 'TestCrudController::index');
