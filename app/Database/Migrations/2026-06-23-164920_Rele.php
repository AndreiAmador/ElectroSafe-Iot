<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Rele extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'estado' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'origen' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'default' => 'usuario',
            ],
            'fecha' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('rele');
    }

    public function down()
    {
        $this->forge->dropTable('rele');
    }
}