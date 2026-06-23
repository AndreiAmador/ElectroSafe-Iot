<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Dashboard::index');
$routes->post('api/sensores', 'ApiController::store');

$routes->get('api/ultimos', 'ApiController::ultimos');

$routes->get('api/historial', 'ApiController::historial');

$routes->get('api/realtime', 'ApiController::realtime');

$routes->get('api/riesgo', 'ApiController::riesgo');

$routes->get('api/alertas', 'ApiController::alertas');

$routes->get('api/alertas/criticas', 'ApiController::alertasCriticas');

$routes->post('api/rele', 'ApiController::controlRele');

$routes->get('api/rele', 'ApiController::estadoRele');

$routes->get('api/estadisticas/hoy', 'ApiController::estadisticasHoy');

$routes->get('api/costo', 'ApiController::costo');

$routes->get('api/graficas/consumo', 'ApiController::graficaConsumo');

$routes->get('api/graficas/humo', 'ApiController::graficaHumo');

$routes->get('api/diagnostico', 'ApiController::diagnostico');