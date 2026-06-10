<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResumenTable extends Migration
{
    public function up()
    {
        Schema::create('resumen', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hora_final', 45)->nullable();
            $table->string('defensa', 45)->nullable();
            $table->string('fiscalia', 45)->nullable();
            $table->string('auxiliar', 45)->nullable();
            $table->string('victima', 45)->nullable();
            $table->string('plazo', 45)->nullable();
            $table->string('medida', 45)->nullable();
            $table->unsignedInteger('audiencias_id');

            $table->foreign('audiencias_id')->references('id')->on('audiencias')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('resumen');
    }
}
