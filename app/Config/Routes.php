<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');

$routes->get('/', 'KalkulatorEksporController::index');

$routes->post('/hitung-exwork', 'KalkulatorEksporController::hitung_exwork');

$routes->post('/komponen-exwork/add', 'KalkulatorEksporController::add_exwork');
$routes->get('/komponen-exwork/delete/(:num)', 'KalkulatorEksporController::delete_exwork/$1');