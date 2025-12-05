<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Rutas para registro de inscritos
$routes->get('registro', 'Registro::create');
$routes->post('registro/store', 'Registro::store');
$routes->get('login', 'Registro::login');
$routes->post('login/checkEmail', 'Registro::checkEmail');