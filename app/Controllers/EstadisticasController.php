<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MedicionModel;
use HiFolks\Statistics\Stat;

class EstadisticasController extends BaseController
{
    public function generales()
    {
        $model = new MedicionModel();

        $data = $model->findAll();

        if (empty($data)) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'mensaje' => 'No hay registros disponibles'
            ]);
        }

        $potencias = array_map('floatval', array_column($data, 'potencia'));
        $temperaturas = array_map('floatval', array_column($data, 'temperatura'));
        $mq2 = array_map('floatval', array_column($data, 'mq2'));
        $corrientes = array_map('floatval', array_column($data, 'corriente'));

        return $this->response->setJSON([
            'total_registros' => count($data),

            'potencia' => [
                'promedio' => round(Stat::mean($potencias), 2),
                'minimo' => min($potencias),
                'maximo' => max($potencias),
                'desviacion_estandar' => round(Stat::stdev($potencias), 2),
                'varianza' => round(Stat::variance($potencias), 2)
            ],

            'temperatura' => [
                'promedio' => round(Stat::mean($temperaturas), 2),
                'minimo' => min($temperaturas),
                'maximo' => max($temperaturas),
                'desviacion_estandar' => round(Stat::stdev($temperaturas), 2),
                'varianza' => round(Stat::variance($temperaturas), 2)
            ],

            'mq2' => [
                'promedio' => round(Stat::mean($mq2), 2),
                'minimo' => min($mq2),
                'maximo' => max($mq2),
                'desviacion_estandar' => round(Stat::stdev($mq2), 2),
                'varianza' => round(Stat::variance($mq2), 2)
            ],

            'corriente' => [
                'promedio' => round(Stat::mean($corrientes), 2),
                'minimo' => min($corrientes),
                'maximo' => max($corrientes),
                'desviacion_estandar' => round(Stat::stdev($corrientes), 2),
                'varianza' => round(Stat::variance($corrientes), 2)
            ]
        ]);
    }
}