<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
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


$routes->get('/login', 'Login::login');
$routes->get('/register', 'Login::register');
$routes->get('/admin/index', 'Login::admin');