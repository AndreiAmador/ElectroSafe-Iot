<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AlertasSeeder extends Seeder
{
    public function run()
    {
        $mediciones = $this->db
            ->table('mediciones')
            ->get()
            ->getResultArray();

        foreach ($mediciones as $medicion) {

            // Humo
            if ($medicion['mq2'] >= 700) {

                $this->db->table('alertas')->insert([
                    'medicion_id' => $medicion['id'],
                    'tipo_alerta' => 'Humo detectado',
                    'nivel' => 'CRITICO',
                    'descripcion' =>
                        'El sensor MQ-2 detectó una concentración elevada de humo.',
                    'fecha' => $medicion['fecha']
                ]);
            }

            // Temperatura
            if ($medicion['temperatura'] >= 35) {

                $this->db->table('alertas')->insert([
                    'medicion_id' => $medicion['id'],
                    'tipo_alerta' => 'Temperatura elevada',
                    'nivel' => 'ALTO',
                    'descripcion' =>
                        'La temperatura superó el límite establecido.',
                    'fecha' => $medicion['fecha']
                ]);
            }

            // Potencia
            if ($medicion['potencia'] >= 500) {

                $this->db->table('alertas')->insert([
                    'medicion_id' => $medicion['id'],
                    'tipo_alerta' => 'Sobreconsumo eléctrico',
                    'nivel' => 'ALTO',
                    'descripcion' =>
                        'Se detectó un consumo eléctrico superior al esperado.',
                    'fecha' => $medicion['fecha']
                ]);
            }

            // Riesgo crítico
            if ($medicion['indice_riesgo'] >= 120) {

                $this->db->table('alertas')->insert([
                    'medicion_id' => $medicion['id'],
                    'tipo_alerta' => 'Riesgo eléctrico',
                    'nivel' => 'CRITICO',
                    'descripcion' =>
                        'El índice de riesgo alcanzó un nivel crítico.',
                    'fecha' => $medicion['fecha']
                ]);
            }
        }
    }
}