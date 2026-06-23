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

// --------------------------------------------------------------------
// RUTAS DE CONFIGURACIÓN DE PERFIL
// --------------------------------------------------------------------
$routes->get('/perfil', 'Profile::index', ['filter' => 'auth']);
$routes->post('/perfil/actualizar', 'Profile::actualizar', ['filter' => 'auth']);

// --------------------------------------------------------------------
// Rutas del registro de comidas
// --------------------------------------------------------------------
$routes->get('/comidas', 'MealLogs::index', ['filter' => 'auth']);
$routes->post('/comidas/guardar', 'MealLogs::guardar', ['filter' => 'auth']);

//--------------------------------------------------------------------
// Rutas del Buscador de Recetas
//--------------------------------------------------------------------
$routes->match(['get', 'post'], '/recetas', 'RecipeSearch::index', ['filter' => 'auth']);
// Rutas del Newspaper 
// CORREGIDO: Usamos un arreglo para pasar múltiples filtros
$routes->get('/newspaper', 'Newspaper::index', ['filter' => ['auth', 'premiumAccess']]);
// Rutas de Moderación (Solo accesibles para profesionales, luego el controlador verifica si es Admin)
$routes->get('/newspaper/pendientes', 'Newspaper::pendientes', ['filter' => ['auth', 'authorAccess']]);
$routes->get('/newspaper/aprobar/(:num)', 'Newspaper::aprobar/$1', ['filter' => ['auth', 'authorAccess']]);
$routes->get('/newspaper/rechazar/(:num)', 'Newspaper::rechazar/$1', ['filter' => ['auth', 'authorAccess']]);

// Rutas protegidas para profesionales
$routes->get('/newspaper/crear', 'Newspaper::crear', ['filter' => ['auth', 'authorAccess']]);
$routes->post('/newspaper/guardar', 'Newspaper::guardar', ['filter' => ['auth', 'authorAccess']]);
