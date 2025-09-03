<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActividadesSeeder extends Seeder
{
    public function run()
    {
        $actividades = [
            'Comercio',
            'Industria',
            'Servicios',
            'Tecnología',
            'Educación',
            'Salud',
            'Turismo',
            'Agricultura',
            'Transporte',
            'Construcción'
        ];

        foreach ($actividades as $actividad) {
            DB::table('actividades')->insert([
                'nombre' => $actividad,
                'descripcion' => 'Descripción de '.$actividad
            ]);
        }
    }
}
