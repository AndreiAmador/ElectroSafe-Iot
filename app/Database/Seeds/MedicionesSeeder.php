<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MedicionesSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 100; $i++) {

            $voltaje = rand(1180, 1300) / 10;

            $corriente = rand(5, 80) / 10;

            $potencia = round($voltaje * $corriente, 2);

            $energia = round($potencia / 1000, 3);

            $temperatura = rand(180, 450) / 10;

            $humedad = rand(300, 900) / 10;

            $mq2 = rand(100, 900);

            $indiceBochorno =
                round(
                    $temperatura + ($humedad * 0.05),
                    2
                );

            $indiceRiesgo =
                round(
                    ($potencia * 0.02) +
                    ($temperatura * 1.5) +
                    ($mq2 * 0.05),
                    2
                );

            if ($indiceRiesgo >= 120) {

                $nivel = 'CRITICO';

            } elseif ($indiceRiesgo >= 80) {

                $nivel = 'ALTO';

            } elseif ($indiceRiesgo >= 50) {

                $nivel = 'PRECAUCION';

            } else {

                $nivel = 'NORMAL';
            }

            $this->db->table('mediciones')->insert([

                'voltaje' => $voltaje,

                'corriente' => $corriente,

                'potencia' => $potencia,

                'energia_kwh' => $energia,

                'temperatura' => $temperatura,

                'humedad' => $humedad,

                'indice_bochorno' => $indiceBochorno,

                'mq2' => $mq2,

                'indice_riesgo' => $indiceRiesgo,

                'nivel_riesgo' => $nivel,

                'estado_rele' => rand(0, 1),

                'fecha' => date(
                    'Y-m-d H:i:s',
                    strtotime("-{$i} minutes")
                )
            ]);
        }
    }
}