<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Rutas para registro de inscritos
$routes->get('registro', 'Registro::create');
$routes->post('registro/store', 'Registro::store');
$routes->get('registro/thankyou', 'Registro::thankyou');