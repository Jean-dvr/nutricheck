<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('home/iniciar_sesion', 'Home::iniciar_sesion');
$routes->get('home/registro', 'Home::registro');
