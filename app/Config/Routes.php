<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('instalar', 'Instalar::index');

// Rutas de Autenticación
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::procesarLogin');
$routes->get('registro', 'Auth::registro');
$routes->post('registro', 'Auth::procesarRegistro');
$routes->get('logout', 'Auth::logout');

// ... existing code ...
$routes->get('/', 'Home::index');
$routes->get('instalar', 'Instalar::index');

// Ruta específica para el botón de Catálogo del menú
$routes->get('catalogo', 'Home::index');

// Rutas de Autenticación
$routes->get('login', 'Auth::login');
// ... existing code ...

// =======================================================
// RUTAS DEL ADMINISTRADOR (Protegidas por el Filtro)
// =======================================================
$routes->group('admin', ['filter' => 'adminauth'], static function ($routes) {
    $routes->get('dashboard', 'AdminController::index');
});

// =======================================================
// RUTAS DEL CLIENTE (Protegidas por el Filtro)
// =======================================================
$routes->group('reserva', ['filter' => 'clienteauth'], static function ($routes) {
    $routes->get('nuevo/(:num)', 'Reserva::nuevo/$1');
    $routes->post('guardar', 'Reserva::guardar');
});