<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePsicologoTable extends Migration
{
    public function up()
    {
        Schema::create('psicologo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 45);
        });
    }

    public function down()
    {
        Schema::dropIfExists('psicologo');
    }
}
