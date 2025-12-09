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
// Ruta para cerrar sesión
$routes->get('logout', 'Registro::logout');
// Rutas para videos YouTube
$routes->get('video/(:any)', 'Videos::show/$1');

// Páginas estáticas: escarapela y juegos
$routes->get('escarapela', 'Pages::escarapela');
$routes->get('juegos', 'Pages::juegos');

// Ruta de ejemplo para API
$routes->get('api/test', 'Api\Test::index');