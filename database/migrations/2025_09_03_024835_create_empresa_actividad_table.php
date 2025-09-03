<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresaActividadTable extends Migration
{
    public function up()
    {
        Schema::create('empresa_actividad', function (Blueprint $table) {
            $table->integer('empresa_id');
            $table->integer('actividad_id');
            $table->primary(['empresa_id', 'actividad_id']);
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');
            $table->foreign('actividad_id')->references('id')->on('actividades')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('empresa_actividad');
    }
}
