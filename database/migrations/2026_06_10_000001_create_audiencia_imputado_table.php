<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAudienciaImputadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audiencia_imputado', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('audiencia_id');
            $table->unsignedInteger('imputado_id');
            $table->unique(['audiencia_id', 'imputado_id']);

            $table->foreign('audiencia_id')->references('id')->on('audiencias')->cascadeOnDelete();
            $table->foreign('imputado_id')->references('id')->on('imputados')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audiencia_imputado');
    }
}
