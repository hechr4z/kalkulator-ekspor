<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');

$routes->get('/', 'KalkulatorEksporController::index');

$routes->post('/ganti-satuan/(:num)', 'KalkulatorEksporController::ganti_satuan/$1');

// $routes->post('/hitung-exwork', 'KalkulatorEksporController::hitung_exwork');

$routes->post('/komponen-exwork/add', 'KalkulatorEksporController::add_exwork');
$routes->get('/komponen-exwork/delete/(:num)', 'KalkulatorEksporController::delete_exwork/$1');

$routes->post('/komponen-fob/add', 'KalkulatorEksporController::add_fob');
$routes->get('/komponen-fob/delete/(:num)', 'KalkulatorEksporController::delete_fob/$1');

$routes->post('/komponen-cfr/add', 'KalkulatorEksporController::add_cfr');
$routes->get('/komponen-cfr/delete/(:num)', 'KalkulatorEksporController::delete_cfr/$1');

$routes->post('/komponen-cif/add', 'KalkulatorEksporController::add_cif');
$routes->get('/komponen-cif/delete/(:num)', 'KalkulatorEksporController::delete_cif/$1');