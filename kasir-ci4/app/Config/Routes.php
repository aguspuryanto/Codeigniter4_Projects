<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->get('/', 'DashboardController::index');
$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::attemptLogin');
$routes->get('/logout', 'AuthController::logout');

$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/dashboard', 'DashboardController::index');
    
    // Produk
    $routes->get('/products', 'ProductsController::index');
    $routes->get('/products/create', 'ProductsController::create');
    $routes->post('/products/store', 'ProductsController::store');
    $routes->get('/products/edit/(:num)', 'ProductsController::edit/$1');
    $routes->post('/products/update/(:num)', 'ProductsController::update/$1');
    $routes->post('/products/delete/(:num)', 'ProductsController::delete/$1');
    
    // Kasir
    $routes->get('/cashier', 'CashierController::index');
    $routes->post('/cashier/add-item', 'CashierController::addItem');
    $routes->post('/cashier/remove-item', 'CashierController::removeItem');
    $routes->post('/cashier/process-payment', 'CashierController::processPayment');
    
    // Laporan
    $routes->get('/reports', 'ReportsController::index');
    $routes->get('/reports/transaction', 'ReportsController::transaction');
    $routes->get('/reports/sales', 'ReportsController::sales');
    
    // Karyawan
    $routes->get('/employees', 'EmployeesController::index');
    $routes->get('/employees/create', 'EmployeesController::create');
    $routes->post('/employees/store', 'EmployeesController::store');
    $routes->get('/employees/edit/(:num)', 'EmployeesController::edit/$1');
    $routes->post('/employees/update/(:num)', 'EmployeesController::update/$1');
    $routes->post('/employees/delete/(:num)', 'EmployeesController::delete/$1');
    
    // Setting
    $routes->get('/settings', 'SettingsController::index');
    $routes->post('/settings/update', 'SettingsController::update');
});
