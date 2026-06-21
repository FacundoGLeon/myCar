<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('instalar', 'Instalar::index');
$routes->get('sobre-nosotros', 'Home::sobreNosotros');

// Rutas de Autenticación
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::procesarLogin');
$routes->get('registro', 'Auth::registro');
$routes->post('registro', 'Auth::procesarRegistro');
$routes->get('logout', 'Auth::logout');


// Ruta específica para el botón de Catálogo del menú
$routes->get('catalogo', 'Home::index');


// =======================================================
// RUTAS DEL ADMINISTRADOR (Protegidas por el Filtro)
// =======================================================

// app/Config/Routes.php (Al final del archivo)
$routes->group('admin', ['filter' => 'adminauth'], static function ($routes) {
    $routes->get('dashboard', 'AdminController::index');
    $routes->get('vehiculos', 'AdminController::vehiculos');
    $routes->get('vehiculos/nuevo', 'AdminController::nuevo');
    $routes->post('vehiculos/guardar', 'AdminController::guardar');
    $routes->get('vehiculos/eliminar/(:num)', 'AdminController::eliminar/$1');
    $routes->get('vehiculos/editar/(:num)', 'AdminController::editar/$1');
    $routes->post('vehiculos/actualizar/(:num)', 'AdminController::actualizar/$1');

    // GESTIÓN DE CATEGORÍAS (Añadir estas líneas al grupo 'admin')
    $routes->get('categorias', 'CategoriasController::index');
    $routes->get('categorias/nuevo', 'CategoriasController::nuevo');
    $routes->post('categorias/guardar', 'CategoriasController::guardar');
    $routes->get('categorias/editar/(:num)', 'CategoriasController::editar/$1');
    $routes->post('categorias/actualizar/(:num)', 'CategoriasController::actualizar/$1');
    $routes->get('categorias/eliminar/(:num)', 'CategoriasController::eliminar/$1');

    // GESTIÓN DE CLIENTES
    $routes->get('clientes', 'ClientesController::index');
    $routes->get('clientes/editar/(:num)', 'ClientesController::editar/$1');
    $routes->post('clientes/actualizar/(:num)', 'ClientesController::actualizar/$1');
    $routes->get('clientes/eliminar/(:num)', 'ClientesController::eliminar/$1');

    // GESTIÓN DE ALQUILERES
    $routes->get('alquileres', 'AlquileresController::index');
    $routes->post('alquileres/accion/(:num)', 'AlquileresController::accion/$1');

    // REPORTES Y ESTADÍSTICAS
    $routes->get('reportes/vehiculo', 'ReportesController::porVehiculo');
    $routes->get('reportes/cliente', 'ReportesController::porCliente');
    $routes->get('reportes/actuales', 'ReportesController::actuales');
});

// RUTAS DE RESERVA (Cliente)
    $routes->get('reserva/nuevo/(:num)', 'ReservaController::nuevo/$1');
    $routes->post('reserva/guardar/(:num)', 'ReservaController::guardar/$1');
    $routes->get('mis-reservas', 'ReservaController::misReservas');

    // Rutas de Perfil del Cliente
    $routes->get('perfil', 'PerfilController::index');
    $routes->post('perfil/actualizar', 'PerfilController::actualizar');



