<?php

namespace App\Models;

use CodeIgniter\Model;

class MedicionModel extends Model
{
    protected $table = 'mediciones';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'voltaje',
        'corriente',
        'potencia',
        'energia_kwh',
        'temperatura',
        'humedad',
        'indice_bochorno',
        'mq2',
        'indice_riesgo',
        'nivel_riesgo',
        'estado_rele',
        'fecha'
    ];
}