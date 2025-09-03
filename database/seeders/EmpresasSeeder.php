<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EmpresasSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 50; $i++) {
            DB::table('empresas')->insert([
                'razon_social' => 'Empresa '.$i,
                'municipio' => 'Ciudad '.rand(1,10),
                'departamento' => 'Depto '.rand(1,5),
                'fecha_matricula' => now(),
                'direccion' => 'Dirección '.$i,
                'rep_legal' => 'Representante '.$i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
