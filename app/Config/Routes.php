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
    $routes->get('/api/tim', 'PagesController::getTim');

    $routes->get('/pages/blog', 'BlogController::index');
    $routes->get('/blog', 'BlogController::index');

    $routes->get('/pages/shop', 'FrontShopController::index');
    $routes->get('/shop', 'FrontShopController::index');

    $routes->get('/(:segment)', 'BlogController::artikel/$1');
    $routes->get('blog/kategori/(:segment)', 'BlogController::kategori/$1');

    $routes->get('/shop/(:segment)', 'FrontShopController::shop/$1');

    $routes->get('/login', 'AuthController::login');
});

$routes->group('auth', function ($routes) {
    // Routes untuk otentikasi
    $routes->get('login', 'AuthController::login');
    $routes->post('login', 'AuthController::attemptLogin');
    $routes->get('register', 'AuthController::register');
    $routes->get('logout', 'AuthController::logout');
});

$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    // Routes untuk admin area (protected dengan filter auth)
    $routes->get('dashboard', 'AdminController::dashboard', ['filter' => 'role:admin']);
    $routes->get('pengguna', 'AdminController::pengguna', ['filter' => 'role:admin']);
    $routes->get('pengaturan', 'AdminController::pengaturan', ['filter' => 'role:admin']);
    $routes->get('analytics', 'AdminController::analytics', ['filter' => 'role:admin']);

    // Routes untuk profil
    $routes->get('profil', 'ProfilController::index', ['filter' => 'role:admin']);
    $routes->get('profil/edit', 'ProfilController::edit', ['filter' => 'role:admin']);
    $routes->post('profil/update', 'ProfilController::update', ['filter' => 'role:admin']);

    // Routes untuk manage akun
    $routes->get('manage_akun', 'Manage_akunController::index', ['filter' => 'role:admin']);
    $routes->post('manage_akun/updateRole', 'Manage_akunController::updateRole', ['filter' => 'role:admin']);
    $routes->get('manage_akun/tambah', 'Manage_akunController::tambah', ['filter' => 'role:admin']);
    $routes->post('manage_akun/simpan', 'Manage_akunController::simpan', ['filter' => 'role:admin']);
    $routes->get('manage_akun/edit/(:num)', 'Manage_akunController::edit/$1', ['filter' => 'role:admin']);
    $routes->post('manage_akun/update/(:num)', 'Manage_akunController::update/$1', ['filter' => 'role:admin']);
    $routes->post('manage_akun/delete/(:num)', 'Manage_akunController::delete/$1', ['filter' => 'role:admin']);

    // Routes untuk manage kelas
    // Manage kelas (daftar kelas & tambah kelas)
    $routes->get('manage_kelas', 'Manage_kelasController::index', ['filter' => 'role:admin']);
    $routes->get('manage_kelas/tambah', 'Manage_kelasController::tambah', ['filter' => 'role:admin']);
    $routes->post('manage_kelas/simpan', 'Manage_kelasController::simpan', ['filter' => 'role:admin']);
    $routes->get('manage_kelas/edit/(:num)', 'Manage_kelasController::edit/$1', ['filter' => 'role:admin']);
    $routes->post('manage_kelas/update/(:num)', 'Manage_kelasController::update/$1', ['filter' => 'role:admin']);
    $routes->post('manage_kelas/delete/(:num)', 'Manage_kelasController::delete/$1', ['filter' => 'role:admin']);

    //  Manage kelas (kelola anggota)
    $routes->get('manage_kelas/kelola_anggota', 'Manage_kelasController::kelola_anggota', ['filter' => 'role:admin']);
    $routes->get('manage_kelas/kelola_anggota/detail/(:num)', 'Manage_kelasController::detail/$1', ['filter' => 'role:admin']);
    $routes->get('manage_kelas/kelola_anggota/tambah/(:num)', 'Manage_kelasController::tambah_anggota/$1', ['filter' => 'role:admin']);
    $routes->post('manage_kelas/kelola_anggota/simpan', 'Manage_kelasController::simpan_anggota', ['filter' => 'role:admin']);
    $routes->post('manage_kelas/kelola_anggota/tambah_anggota', 'Manage_kelasController::addMemberToClass', ['filter' => 'role:admin']);
    $routes->post('manage_kelas/kelola_anggota/hapus/(:num)', 'Manage_kelasController::hapus_anggota/$1', ['filter' => 'role:admin']);
    $routes->post('manage_kelas/kelola_anggota/hapus_anggota/(:num)/(:num)', 'Manage_kelasController::hapus_anggota_kelas/$1/$2', ['filter' => 'role:admin']);

    // Routes untuk manage artikel
    $routes->get('artikel', 'ArtikelController::index', ['filter' => 'role:admin']); // Menampilkan daftar artikel
    $routes->get('artikel/tambah', 'ArtikelController::tambah', ['filter' => 'role:admin']); // Menampilkan form tambah
    $routes->post('artikel/simpan', 'ArtikelController::simpan', ['filter' => 'role:admin']); // Menyimpan artikel
    $routes->get('artikel/edit/(:num)', 'ArtikelController::edit/$1', ['filter' => 'role:admin']); // Menampilkan form edit
    $routes->post('artikel/update/(:num)', 'ArtikelController::update/$1', ['filter' => 'role:admin']); // Mengupdate artikel
    $routes->post('artikel/delete/(:num)', 'ArtikelController::delete/$1', ['filter' => 'role:admin']); // Menghapus artikel
    $routes->post('artikel/upload', 'ArtikelController::upload');

    // Routes untuk Prestasi & Sertifikat
    // Routes untuk Prestasi
    $routes->get('prestasi', 'PrestasiSertifikatController::index', ['filter' => 'role:admin']);
    //Prestasi Perorangan
    $routes->get('prestasi/prestasi_detail/(:num)', 'PrestasiSertifikatController::prestasiDetail/$1', ['filter' => 'role:admin']);
    $routes->get('prestasi/tambah_prestasi/(:num)', 'PrestasiSertifikatController::prestasiDetailTambah/$1', ['filter' => 'role:admin']);
    $routes->post('prestasi/tambah_prestasi/simpan', 'PrestasiSertifikatController::prestasiDetailSimpan', ['filter' => 'role:admin']);
    $routes->get('prestasi/prestasi_detail/info/(:num)/(:num)', 'PrestasiSertifikatController::prestasiDetailInfo/$1/$2', ['filter' => 'role:admin']);
    $routes->get('prestasi/prestasi_detail/edit/(:num)/(:num)', 'PrestasiSertifikatController::prestasiDetailEdit/$1/$2', ['filter' => 'role:admin']);
    $routes->post('prestasi/prestasi_detail/update/(:num)/(:num)', 'PrestasiSertifikatController::prestasiDetailUpdate/$1/$2', ['filter' => 'role:admin']);
    $routes->post('prestasi/prestasi_detail/delete/(:num)', 'PrestasiSertifikatController::prestasiDetailDelete/$1', ['filter' => 'role:admin']);

    //Prestasi Umum
    $routes->get('prestasi/detail/(:num)', 'PrestasiSertifikatController::prestasiInfo/$1', ['filter' => 'role:admin']);
    $routes->get('prestasi/tambah', 'PrestasiSertifikatController::prestasiTambah', ['filter' => 'role:admin']);
    $routes->post('prestasi/simpan', 'PrestasiSertifikatController::prestasiSimpan', ['filter' => 'role:admin']);
    $routes->get('prestasi/edit/(:num)', 'PrestasiSertifikatController::prestasiEdit/$1', ['filter' => 'role:admin']);
    $routes->post('prestasi/update/(:num)', 'PrestasiSertifikatController::prestasiUpdate/$1', ['filter' => 'role:admin']);
    $routes->post('prestasi/delete/(:num)', 'PrestasiSertifikatController::prestasiDelete/$1', ['filter' => 'role:admin']);

    // Routes untuk Grade/Kelas
    $routes->get('grade_level', 'PrestasiSertifikatController::gradeIndex', ['filter' => 'role:admin']);
    $routes->get('grade_level/detail/(:num)', 'PrestasiSertifikatController::gradeDetail/$1', ['filter' => 'role:admin']);
    $routes->get('grade_level/level/(:num)', 'PrestasiSertifikatController::gradeLevel/$1', ['filter' => 'role:admin']);
    $routes->post('grade_level/update_level/(:num)', 'PrestasiSertifikatController::gradeLevelUpdate/$1', ['filter' => 'role:admin']);
    $routes->get('grade_level/proyek/(:num)', 'PrestasiSertifikatController::gradeProyek/$1', ['filter' => 'role:admin']);
    $routes->get('grade_level/proyek/tambah/(:num)', 'PrestasiSertifikatController::gradeProyekTambah/$1', ['filter' => 'role:admin']);
    $routes->post('grade_level/proyek/simpan/(:num)', 'PrestasiSertifikatController::gradeProyekSimpan/$1', ['filter' => 'role:admin']);
    $routes->get('grade_level/proyek/edit/(:num)/(:num)', 'PrestasiSertifikatController::gradeProyekEdit/$1/$2', ['filter' => 'role:admin']);
    $routes->post('grade_level/proyek/update/(:num)/(:num)', 'PrestasiSertifikatController::gradeProyekUpdate/$1/$2', ['filter' => 'role:admin']);
    $routes->get('grade_level/proyek/delete/(:num)/(:num)', 'PrestasiSertifikatController::gradeProyekDelete/$1/$2', ['filter' => 'role:admin']);

    // Routes untuk Sertifikat
    $routes->get('sertifikat', 'PrestasiSertifikatController::sertifikatIndex', ['filter' => 'role:admin']);
    // Routes untuk Sertifikat umum
    $routes->get('sertifikat/detail/(:num)', 'PrestasiSertifikatController::sertifikatDetail/$1', ['filter' => 'role:admin']);
    $routes->get('sertifikat/edit/(:num)', 'PrestasiSertifikatController::sertifikatEdit/$1', ['filter' => 'role:admin']);
    $routes->post('sertifikat/update/(:num)', 'PrestasiSertifikatController::sertifikatUpdate/$1', ['filter' => 'role:admin']);
    $routes->post('sertifikat/delete/(:num)', 'PrestasiSertifikatController::sertifikatDelete/$1', ['filter' => 'role:admin']);
    // Routes untuk Sertifikat berdasarkan prestasi
    $routes->get('sertifikat/prestasi/(:num)', 'PrestasiSertifikatController::sertifikatPrestasiDetail/$1', ['filter' => 'role:admin']);
    $routes->get('sertifikat/prestasi/tambah/(:num)', 'PrestasiSertifikatController::sertifikatPrestasiTambah/$1', ['filter' => 'role:admin']);
    $routes->post('sertifikat/prestasi/simpan/(:num)', 'PrestasiSertifikatController::sertifikatPrestasiSimpan/$1/$2', ['filter' => 'role:admin']);
    $routes->get('sertifikat/prestasi/edit/(:num)/(:num)', 'PrestasiSertifikatController::sertifikatPrestasiEdit/$1/$2', ['filter' => 'role:admin']);
    $routes->post('sertifikat/prestasi/update/(:num)/(:num)', 'PrestasiSertifikatController::sertifikatPrestasiUpdate/$1/$2', ['filter' => 'role:admin']);
    $routes->post('sertifikat/prestasi/delete/(:num)/(:num)', 'PrestasiSertifikatController::sertifikatPrestasiDelete/$1/$2', ['filter' => 'role:admin']);
    // Routes untuk Sertifikat berdasarkan akun
    $routes->get('sertifikat/akun/(:num)', 'PrestasiSertifikatController::sertifikatAkunDetail/$1', ['filter' => 'role:admin']);
    $routes->get('sertifikat/akun/tambah/(:num)', 'PrestasiSertifikatController::sertifikatAkunTambah/$1', ['filter' => 'role:admin']);
    $routes->post('sertifikat/akun/simpan/(:num)', 'PrestasiSertifikatController::sertifikatAkunSimpan/$1/$2', ['filter' => 'role:admin']);
    $routes->get('sertifikat/akun/edit/(:num)/(:num)', 'PrestasiSertifikatController::sertifikatAkunEdit/$1/$2', ['filter' => 'role:admin']);
    $routes->post('sertifikat/akun/update/(:num)/(:num)', 'PrestasiSertifikatController::sertifikatAkunUpdate/$1/$2', ['filter' => 'role:admin']);
    $routes->post('sertifikat/akun/delete/(:num)/(:num)', 'PrestasiSertifikatController::sertifikatAkunDelete/$1/$2', ['filter' => 'role:admin']);
    // Routes untuk Sertifikat berdasarkan kelas
    $routes->get('sertifikat/kelas/(:num)', 'PrestasiSertifikatController::sertifikatKelasDetail/$1', ['filter' => 'role:admin']);
    $routes->get('sertifikat/kelas/tambah/(:num)', 'PrestasiSertifikatController::sertifikatKelasTambah/$1', ['filter' => 'role:admin']);
    $routes->post('sertifikat/kelas/simpan/(:num)', 'PrestasiSertifikatController::sertifikatKelasSimpan/$1/$2', ['filter' => 'role:admin']);
    $routes->get('sertifikat/kelas/edit/(:num)/(:num)', 'PrestasiSertifikatController::sertifikatKelasEdit/$1/$2', ['filter' => 'role:admin']);
    $routes->post('sertifikat/kelas/update/(:num)/(:num)', 'PrestasiSertifikatController::sertifikatKelasUpdate/$1/$2', ['filter' => 'role:admin']);
    $routes->post('sertifikat/kelas/delete/(:num)/(:num)', 'PrestasiSertifikatController::sertifikatKelasDelete/$1/$2', ['filter' => 'role:admin']);

    // Routes untuk pengaturan
    $routes->get('pengaturan', 'PengaturanController::index', ['filter' => 'role:admin']);

    // Pengaturan mitra
    $routes->get('pengaturan/mitra', 'PengaturanController::mitra', ['filter' => 'role:admin']);
    $routes->get('pengaturan/mitra/tambah', 'PengaturanController::tambahMitra', ['filter' => 'role:admin']);
    $routes->post('pengaturan/mitra/simpan', 'PengaturanController::simpanMitra', ['filter' => 'role:admin']);
    $routes->get('pengaturan/mitra/edit/(:num)', 'PengaturanController::editMitra/$1', ['filter' => 'role:admin']);
    $routes->post('pengaturan/mitra/update/(:num)', 'PengaturanController::updateMitra/$1', ['filter' => 'role:admin']);
    $routes->get('pengaturan/mitra/hapus/(:num)', 'PengaturanController::hapusMitra/$1', ['filter' => 'role:admin']);


    // Pengaturan tim
    $routes->get('pengaturan/tim', 'PengaturanController::tim', ['filter' => 'role:admin']);
    $routes->get('pengaturan/tim/tambah', 'PengaturanController::tambahTim', ['filter' => 'role:admin']);
    $routes->post('pengaturan/tim/simpan', 'PengaturanController::simpanTim', ['filter' => 'role:admin']);
    $routes->get('pengaturan/tim/edit/(:num)', 'PengaturanController::editTim/$1', ['filter' => 'role:admin']);
    $routes->post('pengaturan/tim/update/(:num)', 'PengaturanController::updateTim/$1', ['filter' => 'role:admin']);
    $routes->get('pengaturan/tim/hapus/(:num)', 'PengaturanController::hapusTim/$1', ['filter' => 'role:admin']);

    $routes->get('pengaturan/prestasi', 'PengaturanController::prestasi', ['filter' => 'role:admin']);

    // Pengaturan kontak
    $routes->get('pengaturan/kontak', 'PengaturanController::kontak', ['filter' => 'role:admin']);
    $routes->post('pengaturan/kontak/update', 'PengaturanController::updateKontak', ['filter' => 'role:admin']);

    $routes->get('pengaturan/galeri', 'PengaturanController::galeri', ['filter' => 'role:admin']);

    //Routes untuk Galeri Siswa
    $routes->get('galeri', 'GaleriSiswaController::index', ['filter' => 'role:admin']);
    $routes->get('galeri/detail/(:num)', 'GaleriSiswaController::detail/$1', ['filter' => 'role:admin']);
    $routes->get('galeri/tambah/(:num)', 'GaleriSiswaController::tambah/$1', ['filter' => 'role:admin']);
    $routes->post('galeri/simpan/(:num)', 'GaleriSiswaController::simpan/$1', ['filter' => 'role:admin']);
    $routes->get('galeri/edit/(:num)/(:num)', 'GaleriSiswaController::edit/$1/$2', ['filter' => 'role:admin']);
    $routes->post('galeri/update/(:num)/(:num)', 'GaleriSiswaController::update/$1/$2', ['filter' => 'role:admin']);
    $routes->post('galeri/delete/(:num)/(:num)', 'GaleriSiswaController::delete/$1/$2', ['filter' => 'role:admin']);

    // Routes untuk shop
    $routes->get('shop', 'ShopController::index', ['filter' => 'role:admin']);
    $routes->get('shop/detail', 'ShopController::detail', ['filter' => 'role:admin']);
    $routes->get('shop/tambah', 'ShopController::tambah', ['filter' => 'role:admin']);
    $routes->post('shop/simpan', 'ShopController::simpan', ['filter' => 'role:admin']);
    $routes->get('shop/edit/(:num)', 'ShopController::edit/$1', ['filter' => 'role:admin']);
    $routes->post('shop/update/(:num)', 'ShopController::update/$1', ['filter' => 'role:admin']);
    $routes->post('shop/delete/(:num)', 'ShopController::delete/$1', ['filter' => 'role:admin']);
});

$routes->group('siswa', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', 'SiswaController::dashboard', ['filter' => 'role:siswa']);

    // Routes untuk profil
    $routes->get('profil', 'SiswaProfilController::index', ['filter' => 'role:siswa']);
    $routes->get('profil/edit', 'SiswaProfilController::edit', ['filter' => 'role:siswa']);
    $routes->post('profil/update', 'SiswaProfilController::update', ['filter' => 'role:siswa']);

    $routes->get('kelas', 'SiswaController::kelasSaya', ['filter' => 'role:siswa']);
    $routes->get('kelas/detail/(:num)', 'SiswaController::kelasSayaDetail/$1', ['filter' => 'role:siswa']);
    $routes->get('gabung-kelas', 'SiswaController::gabungKelas', ['filter' => 'role:siswa']);
    $routes->get('kelas/search', 'SiswaController::kelasSearch', ['filter' => 'role:siswa']);
    $routes->get('kelas/gabung/(:num)/(:num)', 'SiswaController::kelasGabung/$1/$2', ['filter' => 'role:siswa']);
    $routes->post('kelas/keluar/(:num)/(:num)', 'SiswaController::kelasKeluar/$1/$2', ['filter' => 'role:siswa']);

    $routes->get('project-dan-nilai', 'SiswaController::projectNilai', ['filter' => 'role:siswa']);

    $routes->get('sertifikat', 'SiswaController::sertifikat', ['filter' => 'role:siswa']);

    $routes->get('prestasi', 'SiswaController::prestasi', ['filter' => 'role:siswa']);

    // Pengumuman
    $routes->get('pengumuman/sekolah', 'SiswaController::pengumumanSekolah', ['filter' => 'role:siswa']);
    $routes->get('pengumuman/event', 'SiswaController::pengumumanEvent', ['filter' => 'role:siswa']);

    // Galeri
    $routes->get('galeri', 'SiswaController::galeriKegiatan', ['filter' => 'role:siswa']);
    $routes->get('galeri/detail/(:segment)', 'SiswaController::galeriDetail/$1', ['filter' => 'role:siswa']);
    $routes->get('galeri/detail/(:segment)/(:segment)', 'SiswaController::galeriDetail/$1/$2', ['filter' => 'role:siswa']);


    $routes->get('hubungi', 'SiswaController::hubungi', ['filter' => 'role:siswa']);
});

$routes->group('guru', ['filter' => 'auth'], function ($routes) {

    $routes->get('dashboard', 'GuruController::dashboard', ['filter' => 'role:guru']);

    // Routes untuk profil
    $routes->get('profil', 'GuruController::indexProfil', ['filter' => 'role:guru']);
    $routes->get('profil/edit', 'GuruController::editProfil', ['filter' => 'role:guru']);
    $routes->post('profil/update', 'GuruController::updateProfil', ['filter' => 'role:guru']);

    // Routes untuk manage kelas
    // Manage kelas (daftar kelas & tambah kelas)
    $routes->get('manage_kelas', 'GuruController::indexManageKelas', ['filter' => 'role:guru']);
    $routes->get('manage_kelas/tambah', 'GuruController::tambahManageKelas', ['filter' => 'role:guru']);
    $routes->post('manage_kelas/simpan', 'GuruController::simpanManageKelas', ['filter' => 'role:guru']);
    $routes->get('manage_kelas/edit/(:num)', 'GuruController::editManageKelas/$1', ['filter' => 'role:guru']);
    $routes->post('manage_kelas/update/(:num)', 'GuruController::updateManageKelas/$1', ['filter' => 'role:guru']);
    $routes->post('manage_kelas/delete/(:num)', 'GuruController::deleteManageKelas/$1', ['filter' => 'role:guru']);

    //  Manage kelas (kelola anggota)
    $routes->get('manage_kelas/kelola_anggota', 'GuruController::kelola_anggotaManageKelas', ['filter' => 'role:guru']);
    $routes->get('manage_kelas/kelola_anggota/detail/(:num)', 'GuruController::detailManageKelas/$1', ['filter' => 'role:guru']);
    $routes->get('manage_kelas/kelola_anggota/tambah/(:num)', 'GuruController::tambah_anggotaManageKelas/$1', ['filter' => 'role:guru']);
    $routes->post('manage_kelas/kelola_anggota/simpan', 'GuruController::simpan_anggotaManageKelas', ['filter' => 'role:guru']);
    $routes->post('manage_kelas/kelola_anggota/tambah_anggota', 'GuruController::addMemberToClassManageKelas', ['filter' => 'role:guru']);
    $routes->post('manage_kelas/kelola_anggota/hapus/(:num)', 'GuruController::hapus_anggotaManageKelas/$1', ['filter' => 'role:guru']);
    $routes->post('manage_kelas/kelola_anggota/hapus_anggota/(:num)/(:num)', 'GuruController::hapus_anggota_kelasManageKelas/$1/$2', ['filter' => 'role:guru']);

    // Routes untuk Prestasi & Sertifikat
    // Routes untuk Prestasi
    $routes->get('prestasi', 'GuruController::indexPrestasi', ['filter' => 'role:guru']);
    //Prestasi Perorangan
    $routes->get('prestasi/prestasi_detail/(:num)', 'GuruController::prestasiDetailPrestasi/$1', ['filter' => 'role:guru']);
    $routes->get('prestasi/tambah_prestasi/(:num)', 'GuruController::prestasiDetailTambahPrestasi/$1', ['filter' => 'role:guru']);
    $routes->post('prestasi/tambah_prestasi/simpan', 'GuruController::prestasiDetailSimpanPrestasi', ['filter' => 'role:guru']);
    $routes->get('prestasi/prestasi_detail/info/(:num)/(:num)', 'GuruController::prestasiDetailInfoPrestasi/$1/$2', ['filter' => 'role:guru']);
    $routes->get('prestasi/prestasi_detail/edit/(:num)/(:num)', 'GuruController::prestasiDetailEditPrestasi/$1/$2', ['filter' => 'role:guru']);
    $routes->post('prestasi/prestasi_detail/update/(:num)/(:num)', 'GuruController::prestasiDetailUpdatePrestasi/$1/$2', ['filter' => 'role:guru']);
    $routes->post('prestasi/prestasi_detail/delete/(:num)', 'GuruController::prestasiDetailDeletePrestasi/$1', ['filter' => 'role:guru']);

    //Prestasi Umum
    $routes->get('prestasi/detail/(:num)', 'GuruController::prestasiInfoPrestasi/$1', ['filter' => 'role:guru']);
    $routes->get('prestasi/tambah', 'GuruController::prestasiTambahPrestasi', ['filter' => 'role:guru']);
    $routes->post('prestasi/simpan', 'GuruController::prestasiSimpanPrestasi', ['filter' => 'role:guru']);
    $routes->get('prestasi/edit/(:num)', 'GuruController::prestasiEditPrestasi/$1', ['filter' => 'role:guru']);
    $routes->post('prestasi/update/(:num)', 'GuruController::prestasiUpdatePrestasi/$1', ['filter' => 'role:guru']);
    $routes->post('prestasi/delete/(:num)', 'GuruController::prestasiDeletePrestasi/$1', ['filter' => 'role:guru']);

    // Routes untuk Grade/Kelas
    $routes->get('grade_level', 'GuruController::gradeIndexPrestasi', ['filter' => 'role:guru']);
    $routes->get('grade_level/detail/(:num)', 'GuruController::gradeDetailPrestasi/$1', ['filter' => 'role:guru']);
    $routes->get('grade_level/level/(:num)', 'GuruController::gradeLevelPrestasi/$1', ['filter' => 'role:guru']);
    $routes->post('grade_level/update_level/(:num)', 'GuruController::gradeLevelUpdatePrestasi/$1', ['filter' => 'role:guru']);
    $routes->get('grade_level/proyek/(:num)', 'GuruController::gradeProyekPrestasi/$1', ['filter' => 'role:guru']);
    $routes->get('grade_level/proyek/tambah/(:num)', 'GuruController::gradeProyekTambahPrestasi/$1', ['filter' => 'role:guru']);
    $routes->post('grade_level/proyek/simpan/(:num)', 'GuruController::gradeProyekSimpanPrestasi/$1', ['filter' => 'role:guru']);
    $routes->get('grade_level/proyek/edit/(:num)/(:num)', 'GuruController::gradeProyekEditPrestasi/$1/$2', ['filter' => 'role:guru']);
    $routes->post('grade_level/proyek/update/(:num)/(:num)', 'GuruController::gradeProyekUpdatePrestasi/$1/$2', ['filter' => 'role:guru']);
    $routes->get('grade_level/proyek/delete/(:num)/(:num)', 'GuruController::gradeProyekDeletePrestasi/$1/$2', ['filter' => 'role:guru']);

    // Routes untuk Sertifikat
    $routes->get('sertifikat', 'GuruController::sertifikatIndexSertifikat', ['filter' => 'role:guru']);
    // Routes untuk Sertifikat umum
    $routes->get('sertifikat/detail/(:num)', 'GuruController::sertifikatDetailSertifikat/$1', ['filter' => 'role:guru']);
    $routes->get('sertifikat/edit/(:num)', 'GuruController::sertifikatEditSertifikat/$1', ['filter' => 'role:guru']);
    $routes->post('sertifikat/update/(:num)', 'GuruController::sertifikatUpdateSertifikat/$1', ['filter' => 'role:guru']);
    $routes->post('sertifikat/delete/(:num)', 'GuruController::sertifikatDeleteSertifikat/$1', ['filter' => 'role:guru']);
    // Routes untuk Sertifikat berdasarkan prestasi
    $routes->get('sertifikat/prestasi/(:num)', 'GuruController::sertifikatPrestasiDetailSertifikat/$1', ['filter' => 'role:guru']);
    $routes->get('sertifikat/prestasi/tambah/(:num)', 'GuruController::sertifikatPrestasiTambahSertifikat/$1', ['filter' => 'role:guru']);
    $routes->post('sertifikat/prestasi/simpan/(:num)', 'GuruController::sertifikatPrestasiSimpanSertifikat/$1/$2', ['filter' => 'role:guru']);
    $routes->get('sertifikat/prestasi/edit/(:num)/(:num)', 'GuruController::sertifikatPrestasiEditSertifikat/$1/$2', ['filter' => 'role:guru']);
    $routes->post('sertifikat/prestasi/update/(:num)/(:num)', 'GuruController::sertifikatPrestasiUpdateSertifikat/$1/$2', ['filter' => 'role:guru']);
    $routes->post('sertifikat/prestasi/delete/(:num)/(:num)', 'GuruController::sertifikatPrestasiDeleteSertifikat/$1/$2', ['filter' => 'role:guru']);
    // Routes untuk Sertifikat berdasarkan akun
    $routes->get('sertifikat/akun/(:num)', 'GuruController::sertifikatAkunDetailSertifikat/$1', ['filter' => 'role:guru']);
    $routes->get('sertifikat/akun/tambah/(:num)', 'GuruController::sertifikatAkunTambahSertifikat/$1', ['filter' => 'role:guru']);
    $routes->post('sertifikat/akun/simpan/(:num)', 'GuruController::sertifikatAkunSimpanSertifikat/$1/$2', ['filter' => 'role:guru']);
    $routes->get('sertifikat/akun/edit/(:num)/(:num)', 'GuruController::sertifikatAkunEditSertifikat/$1/$2', ['filter' => 'role:guru']);
    $routes->post('sertifikat/akun/update/(:num)/(:num)', 'GuruController::sertifikatAkunUpdateSertifikat/$1/$2', ['filter' => 'role:guru']);
    $routes->post('sertifikat/akun/delete/(:num)/(:num)', 'GuruController::sertifikatAkunDeleteSertifikat/$1/$2', ['filter' => 'role:guru']);
    // Routes untuk Sertifikat berdasarkan kelas
    $routes->get('sertifikat/kelas/(:num)', 'GuruController::sertifikatKelasDetailSertifikat/$1', ['filter' => 'role:guru']);
    $routes->get('sertifikat/kelas/tambah/(:num)', 'GuruController::sertifikatKelasTambahSertifikat/$1', ['filter' => 'role:guru']);
    $routes->post('sertifikat/kelas/simpan/(:num)', 'GuruController::sertifikatKelasSimpanSertifikat/$1/$2', ['filter' => 'role:guru']);
    $routes->get('sertifikat/kelas/edit/(:num)/(:num)', 'GuruController::sertifikatKelasEditSertifikat/$1/$2', ['filter' => 'role:guru']);
    $routes->post('sertifikat/kelas/update/(:num)/(:num)', 'GuruController::sertifikatKelasUpdateSertifikat/$1/$2', ['filter' => 'role:guru']);
    $routes->post('sertifikat/kelas/delete/(:num)/(:num)', 'GuruController::sertifikatKelasDeleteSertifikat/$1/$2', ['filter' => 'role:guru']);

    //Routes untuk Galeri Siswa
    $routes->get('galeri', 'GuruGaleriSiswaController::indexGaleri', ['filter' => 'role:guru']);
    $routes->get('galeri/detail/(:num)', 'GuruGaleriSiswaController::detailGaleri/$1', ['filter' => 'role:guru']);
    $routes->get('galeri/tambah/(:num)', 'GuruGaleriSiswaController::tambahGaleri/$1', ['filter' => 'role:guru']);
    $routes->post('galeri/simpan/(:num)', 'GuruGaleriSiswaController::simpanGaleri/$1', ['filter' => 'role:guru']);
    $routes->get('galeri/edit/(:num)/(:num)', 'GuruGaleriSiswaController::editGaleri/$1/$2', ['filter' => 'role:guru']);
    $routes->post('galeri/update/(:num)/(:num)', 'GuruGaleriSiswaController::updateGaleri/$1/$2', ['filter' => 'role:guru']);
    $routes->post('galeri/delete/(:num)/(:num)', 'GuruGaleriSiswaController::deleteGaleri/$1/$2', ['filter' => 'role:guru']);

});
