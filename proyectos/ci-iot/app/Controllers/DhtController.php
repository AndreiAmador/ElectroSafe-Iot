<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Dht11Model;

class DhtController extends BaseController
{
    public function index()
    {
        return $this->response->setJSON([
            'status' => 'ok',
            'message' => 'Bienvenido a la API DHT11'
        ]);
    }

    public function listar()
    {
        $model = new Dht11Model();

        $data = $model->findAll();

        return $this->response->setJSON($data);
    }

    public function insertar()
    {
        $model = new Dht11Model();

        $data = [
            'temperatura' => 28,
            'humedad' => 65,
            'indice' => 30,
            'fecha' => date('Y-m-d H:i:s')
        ];

        $model->insert($data);

        return $this->response->setJSON([
            'status' => 'ok',
            'message' => 'Datos insertados',
            'data' => $data
        ]);
    }
}