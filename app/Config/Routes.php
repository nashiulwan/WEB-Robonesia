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
    $routes->get('dashboard', 'AdminController::dashboard', ['filter' => 'role:admin']);
    $routes->get('pengguna', 'AdminController::pengguna', ['filter' => 'role:admin']);
    $routes->get('seo', 'AdminController::seo', ['filter' => 'role:admin']);
    $routes->get('pengaturan', 'AdminController::pengaturan', ['filter' => 'role:admin']);
    $routes->get('analytics', 'AdminController::analytics', ['filter' => 'role:admin']);
    $routes->get('profil', 'AdminController::profil', ['filter' => 'role:admin']);


    // Routes untuk artikel
    $routes->get('artikel', 'ArtikelController::index', ['filter' => 'role:admin']); // Menampilkan daftar artikel
    $routes->get('artikel/tambah', 'ArtikelController::tambah', ['filter' => 'role:admin']); // Menampilkan form tambah
    $routes->post('artikel/simpan', 'ArtikelController::simpan', ['filter' => 'role:admin']); // Menyimpan artikel
    $routes->get('artikel/edit/(:num)', 'ArtikelController::edit/$1', ['filter' => 'role:admin']); // Menampilkan form edit
    $routes->post('artikel/update/(:num)', 'ArtikelController::update/$1', ['filter' => 'role:admin']); // Mengupdate artikel
    $routes->post('artikel/delete/(:num)', 'ArtikelController::delete/$1', ['filter' => 'role:admin']); // Menghapus artikel


    // Routes untuk pengaturan
    $routes->get('pengaturan', 'PengaturanController::index', ['filter' => 'role:admin']);
    $routes->get('pengaturan/galeri', 'PengaturanController::galeri', ['filter' => 'role:admin']);
    $routes->get('pengaturan/mitra', 'PengaturanController::mitra', ['filter' => 'role:admin']);
    $routes->get('pengaturan/tim', 'PengaturanController::tim', ['filter' => 'role:admin']);
    $routes->get('pengaturan/prestasi', 'PengaturanController::prestasi', ['filter' => 'role:admin']);

    $routes->get('pengaturan/kontak', 'PengaturanController::kontak', ['filter' => 'role:admin']);
    $routes->post('pengaturan/kontak/update', 'PengaturanController::updateKontak', ['filter' => 'role:admin']);
});


$routes->group('guru', ['filter' => 'auth'], function ($routes) {});
$routes->group('siswa', ['filter' => 'auth'], function ($routes) {});
// $routes->get('/testcrudcontroller', 'TestCrudController::index');
