<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJuezTable extends Migration
{
    public function up()
    {
        Schema::create('juez', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 45);
            $table->string('apellidos', 45)->nullable();
            $table->string('lugar', 45)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('juez');
    }
}
