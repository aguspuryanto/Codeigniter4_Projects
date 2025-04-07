<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->get('/', 'Auth::index');
$routes->get('/auth', 'Auth::index'); // Maps GET requests to the 'index' method of the 'Auth' controller
$routes->post('/auth/login', 'Auth::login'); // Maps POST requests for login to the 'login' method
$routes->get('/auth/logout', 'Auth::logout'); // Maps GET requests for logout to the 'logout' method

$routes->group('', ['filter' => 'auth'], function ($routes) {
    // Dashboard
    $routes->get('/dashboard', 'Dashboard::index');
    // Penjualan
    $routes->get('/penjualan', 'Penjualan::index');
    // Pengeluaran
    $routes->get('/pengeluaran', 'Pengeluaran::index');
    // Produk
    $routes->get('/produk', 'Produk::index');
    // Hutang & Piutang
    $routes->get('/hutang', 'HutangPiutang::index');
    // $routes->get('/piutang', 'HutangPiutang::index');
    // Laporan
    $routes->get('/laporan', 'Laporan::index');
    $routes->get('/laporan/print', 'Laporan::print');
    // Profile
    $routes->get('profile', 'Profile::index');
    $routes->post('profile/update', 'Profile::update');
    $routes->get('profile/logout', 'Profile::logout');
});

$routes->group('penjualan', ['filter' => 'auth'], function ($routes) {
    // Penjualan
    $routes->add('create', 'Penjualan::tambah');
    $routes->get('edit/(:segment)', 'Penjualan::edit/$1');
    $routes->add('delete/(:segment)', 'Penjualan::delete/$1');
});

$routes->group('pengeluaran', ['filter' => 'auth'], function ($routes) {
    // Pengeluaran
    $routes->add('create', 'Pengeluaran::tambah');
    $routes->get('edit/(:segment)', 'Pengeluaran::edit/$1');
    $routes->add('delete/(:segment)', 'Pengeluaran::delete/$1');
});

$routes->group('produk', ['filter' => 'auth'], function ($routes) {
    // Produk
    $routes->add('create', 'Produk::tambah');
    $routes->get('edit/(:segment)', 'Produk::edit/$1');
    $routes->add('delete/(:segment)', 'Produk::delete/$1');
});

$routes->group('hutang', ['filter' => 'auth'], function ($routes) {
    // Hutang
    $routes->add('create', 'HutangPiutang::create');
    $routes->get('edit/(:segment)', 'HutangPiutang::edit/$1');
    $routes->add('delete/(:segment)', 'HutangPiutang::delete/$1');
});
