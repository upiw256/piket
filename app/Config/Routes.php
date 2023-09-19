<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->get('/', 'ControllerTerlambat::index');
$routes->get('/sync', 'ControllerTerlambat::syncData');
$routes->post('/update-terlambat', 'ControllerTerlambat::updateTerlambat');
$routes->get('/terlambat', 'ControllerTerlambat::terlambat');
