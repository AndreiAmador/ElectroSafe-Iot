<?php

namespace App\Models;

use CodeIgniter\Model;

class ReleModel extends Model
{
    protected $table = 'rele';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'estado',
        'origen',
        'fecha'
    ];
}