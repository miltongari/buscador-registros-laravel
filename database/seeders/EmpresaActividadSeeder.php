<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmpresaActividadSeeder extends Seeder
{
    public function run()
    {
        $empresas = DB::table('empresas')->pluck('id');
        $actividades = DB::table('actividades')->pluck('id');

        foreach ($empresas as $empresa_id) {
            // Cada empresa tendrá entre 1 y 3 actividades
            $asignadas = $actividades->random(rand(1,3))->unique();

            foreach ($asignadas as $actividad_id) {
                DB::table('empresa_actividad')->updateOrInsert([
                    'empresa_id' => $empresa_id,
                    'actividad_id' => $actividad_id
                ], []);
            }
        }
    }
}
