<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Mediciones extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'voltaje' => [
                'type' => 'FLOAT',
                'null' => false,
            ],
            'corriente' => [
                'type' => 'FLOAT',
                'null' => false,
            ],
            'potencia' => [
                'type' => 'FLOAT',
                'null' => false,
            ],
            'energia_kwh' => [
                'type' => 'FLOAT',
                'default' => 0,
            ],
            'temperatura' => [
                'type' => 'FLOAT',
                'null' => false,
            ],
            'humedad' => [
                'type' => 'FLOAT',
                'null' => false,
            ],
            'indice_bochorno' => [
                'type' => 'FLOAT',
                'default' => 0,
            ],
            'mq2' => [
                'type' => 'FLOAT',
                'null' => false,
            ],
            'indice_riesgo' => [
                'type' => 'FLOAT',
                'default' => 0,
            ],
            'nivel_riesgo' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'default' => 'NORMAL',
            ],
            'estado_rele' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'fecha' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('fecha');
        $this->forge->createTable('mediciones');
    }

    public function down()
    {
        $this->forge->dropTable('mediciones');
    }
}