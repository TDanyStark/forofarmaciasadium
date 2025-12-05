<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Rutas para registro de inscritos
$routes->get('inscritos/create', 'Inscritos::create');
$routes->post('inscritos/store', 'Inscritos::store');
$routes->get('inscritos/thankyou', 'Inscritos::thankyou');
