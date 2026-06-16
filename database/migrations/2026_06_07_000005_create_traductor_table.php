<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTraductorTable extends Migration
{
    public function up()
    {
        Schema::create('traductor', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombres', 75);
            $table->string('lengua', 45)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('traductor');
    }
}
