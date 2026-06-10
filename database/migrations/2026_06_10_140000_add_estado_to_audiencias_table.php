<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEstadoToAudienciasTable extends Migration
{
    public function up()
    {
        Schema::table('audiencias', function (Blueprint $table) {
            $table->string('estado', 30)->default('Programada')->after('modalidad');
        });
    }

    public function down()
    {
        Schema::table('audiencias', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
    }
}
