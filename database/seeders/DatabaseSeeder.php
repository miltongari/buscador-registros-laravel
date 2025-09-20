<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            EmpresasSeeder::class,
            ActividadesSeeder::class,
            EmpresaActividadSeeder::class,
        ]);
    }
}
