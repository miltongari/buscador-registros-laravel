<?php
// funcionalidad: crear la tabla empresas con sus respectivos campos e índices

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('razon_social');
            $table->string('municipio');
            $table->string('departamento');
            $table->date('fecha_matricula');
            $table->string('direccion');
            $table->string('rep_legal');
            $table->timestamps();
        });

        \DB::statement('CREATE EXTENSION IF NOT EXISTS pg_trgm;');
        \DB::statement("CREATE INDEX IF NOT EXISTS idx_empresas_mpio_trgm ON empresas USING GIN (municipio gin_trgm_ops);");
        \DB::statement("CREATE INDEX IF NOT EXISTS idx_empresas_dep ON empresas(departamento);");
    }

    public function down()
    {
        Schema::dropIfExists('empresas');
    }
};
