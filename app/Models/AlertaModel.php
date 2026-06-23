<?php

namespace App\Models;

use CodeIgniter\Model;

class AlertaModel extends Model
{
    protected $table = 'alertas';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'medicion_id',
        'tipo_alerta',
        'nivel',
        'descripcion',
        'fecha'
    ];
}