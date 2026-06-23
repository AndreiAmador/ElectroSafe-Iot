<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Alertas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'medicion_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'tipo_alerta' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'nivel' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'descripcion' => [
                'type' => 'TEXT',
            ],
            'fecha' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('alertas');
    }

    public function down()
    {
        $this->forge->dropTable('alertas');
    }
}