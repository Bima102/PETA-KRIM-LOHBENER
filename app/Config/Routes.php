<?php

namespace Config;

$routes = Services::routes();

if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('halaman_utama');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

$routes->get('/', 'Home::halaman_utama');
$routes->get('/halaman_utama', 'Home::halaman_utama');
$routes->cli('/server', 'Server::index');
$routes->get('statistik', 'Wilayah::statistik');

// Register dan Login
$routes->get('/register', 'Users::register');
$routes->post('/register', 'Users::register');
$routes->get('/login', 'Users::index');
$routes->post('/login', 'Users::index'); // Ubah dari /index ke /login
$routes->get('/logout', 'Users::logout');
$routes->get('/wilayah/aduan', 'Wilayah::aduan');
$routes->post('/wilayah/aduanSave', 'Wilayah::aduanSave');

// Halaman Admin
$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']);
$routes->get('/wilayah', 'Wilayah::wilayah_data_read', ['filter' => 'auth']);
$routes->get('/maps', 'Maps::index', ['filter' => 'auth']);
$routes->get('/maps_user', 'Maps::index');
$routes->post('/wilayah_data_save', 'Wilayah::wilayah_data_save', ['filter' => 'auth']);
$routes->post('/wilayah/wilayahUpdate/(:segment)', 'Wilayah::wilayahUpdate/$1', ['filter' => 'auth']);
$routes->get('/editWilayah/(:any)', 'Wilayah::wilayah_edit/$1', ['filter' => 'auth']);
$routes->get('/wilayahDelete/(:any)', 'Wilayah::wilayahDelete/$1', ['filter' => 'auth']);
$routes->get('/wilayah/aduanTerima/(:num)', 'Wilayah::aduanTerima/$1');
$routes->get('/wilayah/aduanTolak/(:num)', 'Wilayah::aduanTolak/$1');

if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}