<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Dht11 extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'temperatura' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',

            ],
            'humedad' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',

            ],
            'indice' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',

            ],
            'fecha' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('fecha');
        $this->forge->createTable('dht11');
    }

    public function down()
    {
        $this->forge->dropTable('dht11');
    }
}