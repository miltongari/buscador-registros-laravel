<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmpresasSeeder extends Seeder
{
    public function run()
    {
        DB::table('empresas')->insert([
            [
                'razon_social' => 'Tech Solutions S.A.',
                'municipio' => 'Monterrey',
                'departamento' => 'Nuevo León',
                'fecha_matricula' => '2022-05-10',
                'direccion' => 'Av. Revolución 123',
                'rep_legal' => 'Carlos Pérez',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'razon_social' => 'Agroindustria del Norte',
                'municipio' => 'Guadalajara',
                'departamento' => 'Jalisco',
                'fecha_matricula' => '2021-11-20',
                'direccion' => 'Calle Hidalgo 45',
                'rep_legal' => 'María López',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'razon_social' => 'Servicios Financieros del Bajío',
                'municipio' => 'León',
                'departamento' => 'Guanajuato',
                'fecha_matricula' => '2023-03-15',
                'direccion' => 'Blvd. Campestre 78',
                'rep_legal' => 'Juan Hernández',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
