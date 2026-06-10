<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 45);
            $table->string('puesto', 45)->nullable();
            $table->string('usuario', 45)->unique();
            $table->string('contrasena', 50)->nullable();
            $table->unsignedInteger('roles_id');

            $table->foreign('roles_id')->references('id')->on('roles');
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
