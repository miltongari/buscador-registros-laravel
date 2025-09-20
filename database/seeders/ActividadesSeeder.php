<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActividadesSeeder extends Seeder
{
    public function run()
    {
        DB::table('actividades')->insert([
            [
                'nombre' => 'Comercio',
                'descripcion' => 'Venta de productos en general',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Tecnología',
                'descripcion' => 'Servicios y productos de software',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Agricultura',
                'descripcion' => 'Producción agrícola y ganadera',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
