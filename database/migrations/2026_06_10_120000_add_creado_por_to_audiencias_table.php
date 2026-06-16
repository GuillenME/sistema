<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreadoPorToAudienciasTable extends Migration
{
    public function up()
    {
        Schema::table('audiencias', function (Blueprint $table) {
            $table->unsignedInteger('creado_por')->nullable()->after('salas_id');

            $table->foreign('creado_por')->references('id')->on('usuarios')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('audiencias', function (Blueprint $table) {
            $table->dropForeign(['creado_por']);
            $table->dropColumn('creado_por');
        });
    }
}
