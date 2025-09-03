<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActividadesTable extends Migration
{
    public function up()
    {
        Schema::create('actividades', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->text('nombre')->unique();
        });

        \DB::statement("CREATE INDEX IF NOT EXISTS idx_actividades_trgm ON actividades USING GIN (nombre gin_trgm_ops);");
    }

    public function down()
    {
        Schema::dropIfExists('actividades');
    }
}
