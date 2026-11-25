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
// Rutas para la gestión del cuadro clinico (Exclusivo Admin)
$routes->post('/perfil/agregar-condicion', 'Profile::agregarCondicion', ['filter' => 'auth']);
$routes->get('/perfil/eliminar-condicion/(:num)', 'Profile::eliminarCondicion/$1', ['filter' => 'auth']);

// --------------------------------------------------------------------
// Rutas del registro de comidas
// --------------------------------------------------------------------
$routes->get('/comidas', 'MealLogs::index', ['filter' => 'auth']);
$routes->post('/comidas/guardar', 'MealLogs::guardar', ['filter' => 'auth']);
$routes->get('/comidas', 'MealLogs::index', ['filter' => 'auth']);
$routes->post('/comidas/guardar', 'MealLogs::guardar', ['filter' => 'auth']);
$routes->post('/comidas/editar', 'MealLogs::editar', ['filter' => 'auth']);
$routes->post('/comidas/editar/(:num)', 'MealLogs::editar/$1', ['filter' => 'auth']);
$routes->post('/comidas/eliminar', 'MealLogs::eliminar', ['filter' => 'auth']);
$routes->post('/comidas/eliminar/(:num)', 'MealLogs::eliminar/$1', ['filter' => 'auth']);

//--------------------------------------------------------------------
// Rutas del Buscador de Recetas
//--------------------------------------------------------------------
$routes->match(['get', 'post'], '/recetas', 'RecipeSearch::index', ['filter' => 'auth']);
// Rutas del Newspaper 

// Usamos un arreglo para pasar múltiples filtros
$routes->get('/newspaper', 'Newspaper::index', ['filter' => ['auth', 'premiumAccess']]);
// Rutas de Moderación (Solo accesibles para profesionales, luego el controlador verifica si es Admin)

$routes->get('/newspaper/pendientes', 'Newspaper::pendientes', ['filter' => ['auth', 'authorAccess']]);
$routes->get('/newspaper/aprobar/(:num)', 'Newspaper::aprobar/$1', ['filter' => ['auth', 'authorAccess']]);
$routes->get('/newspaper/rechazar/(:num)', 'Newspaper::rechazar/$1', ['filter' => ['auth', 'authorAccess']]);

// Ruta para eliminar posts ya publicados
$routes->get('/newspaper/eliminar/(:num)', 'Newspaper::eliminar/$1', ['filter' => ['auth', 'authorAccess']]);

// Rutas protegidas para profesionales
$routes->get('/newspaper/crear', 'Newspaper::crear', ['filter' => ['auth', 'authorAccess']]);
$routes->post('/newspaper/guardar', 'Newspaper::guardar', ['filter' => ['auth', 'authorAccess']]);

// Rutas del sistema de Banners
$routes->post('/dashboard/actualizarAnuncio', 'Dashboard::actualizarAnuncio', ['filter' => 'auth']);
$routes->get('/dashboard/eliminarAnuncio/(:num)', 'Dashboard::eliminarAnuncio/$1', ['filter' => 'auth']);

// PANEL DE ADMINISTRACIÓN Y NUTRICIONISTAS
$routes->get('admin', 'AdminController::index');
$routes->post('admin/guardarIngrediente', 'AdminController::guardarIngrediente');
$routes->post('admin/guardarEtiqueta', 'AdminController::guardarEtiqueta');
$routes->post('admin/guardarReceta', 'AdminController::guardarReceta');
// NUEVAS RUTAS DE GESTIÓN DE RECETAS (CRUD Y APROBACIÓN)
$routes->get('admin/eliminarReceta/(:num)', 'AdminController::eliminarReceta/$1', ['filter' => 'auth']);
$routes->get('admin/aprobarReceta/(:num)', 'AdminController::aprobarReceta/$1', ['filter' => 'auth']);
$routes->get('admin/editarReceta/(:num)', 'AdminController::editarReceta/$1', ['filter' => 'auth']);
$routes->post('admin/actualizarReceta', 'AdminController::actualizarReceta', ['filter' => 'auth']);
// Módulo de Pagos y Suscripciones
$routes->get('/premium/checkout', 'Payments::checkout', ['filter' => 'auth']);
$routes->post('/premium/reportar', 'Payments::reportar', ['filter' => 'auth']);
// Panel de control de pagos para el Administrador
$routes->get('/dashboard/pagos', 'Payments::lista', ['filter' => 'auth']);
$routes->get('/dashboard/pagos/aprobar/(:num)', 'Payments::aprobar/$1', ['filter' => 'auth']);
$routes->get('/dashboard/pagos/rechazar/(:num)', 'Payments::rechazar/$1', ['filter' => 'auth']);

// Módulo de Notificaciones
$routes->get('/notificaciones/leer/(:num)', 'Notifications::leer/$1', ['filter' => 'auth']);
$routes->get('/notificaciones/leer-todas', 'Notifications::marcarTodas', ['filter' => 'auth']);