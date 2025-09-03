<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            ActividadesSeeder::class,
            EmpresasSeeder::class,
            EmpresaActividadSeeder::class,
        ]);
    }
}
