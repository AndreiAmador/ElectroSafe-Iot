<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MedicionModel;
use App\Models\AlertaModel;
use App\Models\ReleModel;

class ApiController extends BaseController
{
    public function store()
    {
        $json = $this->request->getJSON(true);

        if (!$json) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'mensaje' => 'JSON inválido'
            ]);
        }

        $voltaje = (float)($json['voltaje'] ?? 0);
        $corriente = (float)($json['corriente'] ?? 0);
        $temperatura = (float)($json['temperatura'] ?? 0);
        $humedad = (float)($json['humedad'] ?? 0);
        $mq2 = (float)($json['mq2'] ?? 0);
        $estadoRele = (bool)($json['estado_rele'] ?? false);

        if ($voltaje <= 0 || $corriente < 0 || $temperatura == 0 || $humedad == 0) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'mensaje' => 'Faltan datos requeridos'
            ]);
        }

        $potencia = $voltaje * $corriente;
        $energiaKwh = $potencia / 1000;
        $indiceBochorno = $temperatura + ($humedad * 0.05);
        $indiceRiesgo = $this->calcularRiesgo($potencia, $temperatura, $mq2, $corriente);
        $nivelRiesgo = $this->nivelRiesgo($indiceRiesgo);

        $model = new MedicionModel();

        $id = $model->insert([
            'voltaje' => $voltaje,
            'corriente' => $corriente,
            'potencia' => round($potencia, 2),
            'energia_kwh' => round($energiaKwh, 4),
            'temperatura' => $temperatura,
            'humedad' => $humedad,
            'indice_bochorno' => round($indiceBochorno, 2),
            'mq2' => $mq2,
            'indice_riesgo' => round($indiceRiesgo, 2),
            'nivel_riesgo' => $nivelRiesgo,
            'estado_rele' => $estadoRele,
            'fecha' => date('Y-m-d H:i:s')
        ]);

        if ($nivelRiesgo == 'ALTO' || $nivelRiesgo == 'CRITICO') {
            $this->crearAlerta($id, $nivelRiesgo, $temperatura, $mq2, $potencia);
        }

        return $this->response->setStatusCode(201)->setJSON([
            'status' => 'success',
            'mensaje' => 'Datos almacenados correctamente',
            'id' => $id
        ]);
    }

    public function ultimos()
    {
        $model = new MedicionModel();

        return $this->response->setJSON(
            $model->orderBy('id', 'DESC')->limit(10)->findAll()
        );
    }

    public function historial()
    {
        $model = new MedicionModel();

        $inicio = $this->request->getGet('inicio');
        $fin = $this->request->getGet('fin');

        if ($inicio && $fin) {
            $data = $model
                ->where('fecha >=', $inicio . ' 00:00:00')
                ->where('fecha <=', $fin . ' 23:59:59')
                ->orderBy('fecha', 'ASC')
                ->findAll();
        } else {
            $data = $model->orderBy('fecha', 'ASC')->findAll();
        }

        return $this->response->setJSON($data);
    }

    public function realtime()
    {
        $model = new MedicionModel();

        $data = $model->orderBy('id', 'DESC')->first();

        if (!$data) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'mensaje' => 'No hay datos disponibles'
            ]);
        }

        return $this->response->setJSON($data);
    }

    public function riesgo()
    {
        $model = new MedicionModel();

        $data = $model->orderBy('id', 'DESC')->first();

        if (!$data) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'mensaje' => 'No hay datos disponibles'
            ]);
        }

        return $this->response->setJSON([
            'riesgo' => $data['nivel_riesgo'],
            'indice_riesgo' => $data['indice_riesgo'],
            'causa' => $this->causaRiesgo($data)
        ]);
    }

    public function alertas()
    {
        $model = new AlertaModel();

        return $this->response->setJSON(
            $model->orderBy('id', 'DESC')->findAll()
        );
    }

    public function alertasCriticas()
    {
        $model = new AlertaModel();

        return $this->response->setJSON(
            $model->where('nivel', 'CRITICO')->orderBy('id', 'DESC')->findAll()
        );
    }

    public function controlRele()
    {
        $json = $this->request->getJSON(true);

        if (!isset($json['estado'])) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'mensaje' => 'Falta el estado del relé'
            ]);
        }

        $model = new ReleModel();

        $model->insert([
            'estado' => (bool)$json['estado'],
            'origen' => 'usuario',
            'fecha' => date('Y-m-d H:i:s')
        ]);

        return $this->response->setJSON([
            'mensaje' => $json['estado'] ? 'Relé activado correctamente' : 'Relé desactivado correctamente'
        ]);
    }

    public function estadoRele()
    {
        $model = new ReleModel();

        $data = $model->orderBy('id', 'DESC')->first();

        return $this->response->setJSON([
            'estado' => $data ? (bool)$data['estado'] : false
        ]);
    }

    public function estadisticasHoy()
    {
        $model = new MedicionModel();

        $hoy = date('Y-m-d');

        $data = $model
            ->where('fecha >=', $hoy . ' 00:00:00')
            ->where('fecha <=', $hoy . ' 23:59:59')
            ->findAll();

        if (empty($data)) {
            return $this->response->setStatusCode(404)->setJSON([
                'mensaje' => 'No hay datos de hoy'
            ]);
        }

        $potencias = array_column($data, 'potencia');
        $temperaturas = array_column($data, 'temperatura');
        $mq2 = array_column($data, 'mq2');

        return $this->response->setJSON([
            'potencia_promedio' => round(array_sum($potencias) / count($potencias), 2),
            'temperatura_max' => max($temperaturas),
            'mq2_max' => max($mq2)
        ]);
    }

    public function costo()
    {
        $model = new MedicionModel();

        $data = $model->findAll();

        $energia = array_sum(array_column($data, 'energia_kwh'));
        $tarifa = 1.2;
        $costo = $energia * $tarifa;

        return $this->response->setJSON([
            'energia_kwh' => round($energia, 2),
            'tarifa' => $tarifa,
            'costo_estimado' => round($costo, 2)
        ]);
    }

    public function graficaConsumo()
    {
        $model = new MedicionModel();

        $data = $model->select('fecha, potencia')
            ->orderBy('id', 'DESC')
            ->limit(10)
            ->findAll();

        $data = array_reverse($data);

        $response = [];

        foreach ($data as $row) {
            $response[] = [
                'hora' => date('H:i', strtotime($row['fecha'])),
                'potencia' => (float)$row['potencia']
            ];
        }

        return $this->response->setJSON($response);
    }

    public function graficaHumo()
    {
        $model = new MedicionModel();

        $data = $model->select('fecha, mq2')
            ->orderBy('id', 'DESC')
            ->limit(10)
            ->findAll();

        $data = array_reverse($data);

        $response = [];

        foreach ($data as $row) {
            $response[] = [
                'hora' => date('H:i', strtotime($row['fecha'])),
                'mq2' => (float)$row['mq2']
            ];
        }

        return $this->response->setJSON($response);
    }

    private function calcularRiesgo($potencia, $temperatura, $mq2, $corriente)
    {
        return ($potencia * 0.02) + ($temperatura * 1.5) + ($mq2 * 0.05) + ($corriente * 5);
    }

    private function nivelRiesgo($indice)
    {
        if ($indice >= 120) {
            return 'CRITICO';
        } elseif ($indice >= 80) {
            return 'ALTO';
        } elseif ($indice >= 50) {
            return 'PRECAUCION';
        }

        return 'NORMAL';
    }

    private function causaRiesgo($data)
    {
        $causas = [];

        if ($data['temperatura'] >= 35) {
            $causas[] = 'Temperatura elevada';
        }

        if ($data['mq2'] >= 700) {
            $causas[] = 'Humo detectado';
        }

        if ($data['potencia'] >= 500) {
            $causas[] = 'Sobreconsumo eléctrico';
        }

        return empty($causas) ? 'Valores dentro del rango normal' : implode(', ', $causas);
    }

    private function crearAlerta($medicionId, $nivel, $temperatura, $mq2, $potencia)
    {
        $alertaModel = new AlertaModel();

        $descripcion = [];

        if ($temperatura >= 35) {
            $descripcion[] = 'Temperatura elevada';
        }

        if ($mq2 >= 700) {
            $descripcion[] = 'Humo detectado por MQ-2';
        }

        if ($potencia >= 500) {
            $descripcion[] = 'Sobreconsumo eléctrico';
        }

        $alertaModel->insert([
            'medicion_id' => $medicionId,
            'tipo_alerta' => 'Riesgo eléctrico',
            'nivel' => $nivel,
            'descripcion' => implode(', ', $descripcion),
            'fecha' => date('Y-m-d H:i:s')
        ]);
    }
}