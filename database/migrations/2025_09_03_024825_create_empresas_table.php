<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasTable extends Migration
{
    public function up()
    {

         Schema::create('empresas', function (Blueprint $table) {
        $table->id();
        $table->string('razon_social');
        $table->string('municipio');
        $table->string('departamento');
        $table->date('fecha_matricula');
        $table->string('direccion'); // <-- Debe estar esta línea
        $table->string('rep_legal');
        $table->timestamps();
        // Schema::create('empresas', function (Blueprint $table) {
        //     $table->integer('id')->primary(); // usas el id del excel
        //     $table->text('org_juridica')->nullable();
        //     $table->text('categoria')->nullable();
        //     $table->date('fecha_matricula')->nullable();
        //     $table->text('razon_social')->nullable();
        //     $table->text('tipo_identificacion')->nullable();
        //     $table->text('numero_identificacion')->nullable();
        //     $table->text('desc_tamano_empresa')->nullable();
        //     $table->text('departamento')->nullable();
        //     $table->text('municipio')->nullable();
        //     $table->text('direccion_comercial')->nullable();
        //     $table->text('NumeroCelular')->nullable();
        //     $table->text('correo_comercial')->nullable();
        //     $table->text('rep_legal')->nullable();
            // no agregamos timestamps si tu data no los tiene
        });

        // Crea extensión y índices específicos de PostgreSQL
        \DB::statement('CREATE EXTENSION IF NOT EXISTS pg_trgm;');
        \DB::statement("CREATE INDEX IF NOT EXISTS idx_empresas_mpio_trgm ON empresas USING GIN (municipio gin_trgm_ops);");
        \DB::statement("CREATE INDEX IF NOT EXISTS idx_empresas_dep ON empresas(departamento);");
    }

    public function down()
    {
        Schema::dropIfExists('empresas');
    }
}
