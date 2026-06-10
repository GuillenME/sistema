<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAudienciasTable extends Migration
{
    public function up()
    {
        Schema::create('audiencias', function (Blueprint $table) {
            $table->increments('id');
            $table->string('causa', 45);
            $table->date('fecha');
            $table->time('hora');
            $table->string('modalidad', 50)->nullable();
            $table->unsignedInteger('delitos_id');
            $table->unsignedInteger('tipo_audiencia_id');
            $table->unsignedInteger('juez_id');
            $table->unsignedInteger('traductor_id')->nullable();
            $table->unsignedInteger('psicologo_id')->nullable();
            $table->unsignedInteger('salas_id');

            $table->foreign('delitos_id')->references('id')->on('delitos');
            $table->foreign('tipo_audiencia_id')->references('id')->on('tipo_audiencia');
            $table->foreign('juez_id')->references('id')->on('juez');
            $table->foreign('traductor_id')->references('id')->on('traductor');
            $table->foreign('psicologo_id')->references('id')->on('psicologo');
            $table->foreign('salas_id')->references('id')->on('salas');
        });
    }

    public function down()
    {
        Schema::dropIfExists('audiencias');
    }
}
