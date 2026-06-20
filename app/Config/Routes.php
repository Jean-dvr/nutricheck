<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --------------------------------------------------------------------
// 1. RUTAS PÚBLICAS Y PRINCIPALES
// --------------------------------------------------------------------
$routes->get('/', 'Home::index');

// --------------------------------------------------------------------
// 2. VISTAS DE AUTENTICACIÓN (Rutas GET - Solo muestran pantallas)
// --------------------------------------------------------------------
$routes->get('/login', 'Authen::index');
$routes->get('/authen', 'Authen::index'); // Alias o fallback de seguridad para el login
$routes->get('/register', 'Authen::register');

// --------------------------------------------------------------------
// 3. PROCESAMIENTO DE AUTENTICACIÓN (Rutas POST - Manejan datos sensibles)
// --------------------------------------------------------------------
$routes->post('/login/ingresar', 'Authen::ingresar');
$routes->post('/register/guardar', 'Authen::guardar');

// --------------------------------------------------------------------
// 4. ÁREA PRIVADA / PROTEGIDA (Requieren sesión iniciada)
// --------------------------------------------------------------------
$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']);

// Nuevas rutas de la calculadora IMC
$routes->get('/imc', 'Imc::index', ['filter' => 'auth']);
$routes->post('/imc/calcular', 'Imc::calcular', ['filter' => 'auth']);
// --------------------------------------------------------------------
// 5. RUTAS DE CIERRE DE SESIÓN
// --------------------------------------------------------------------
$routes->get('/logout', 'Authen::logout');