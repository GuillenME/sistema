<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoAudienciaTable extends Migration
{
    public function up()
    {
        Schema::create('tipo_audiencia', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo', 45)->unique();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tipo_audiencia');
    }
}
