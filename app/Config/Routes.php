<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Videos::index');

// Rutas para registro de inscritos
$routes->get('registro', 'Registro::create');
$routes->post('registro/store', 'Registro::store');
$routes->get('login', 'Registro::login');
$routes->post('login/checkEmail', 'Registro::checkEmail');
// Ruta de ejemplo para API
$routes->get('api/test', 'Api\Test::index');

// Rutas para videos YouTube
$routes->get('video/(:any)', 'Videos::show/$1');