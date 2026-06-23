<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'DhtController::index');
$routes->get('listar', 'DhtController::listar');
$routes->post('insertar', 'DhtController::insertar');