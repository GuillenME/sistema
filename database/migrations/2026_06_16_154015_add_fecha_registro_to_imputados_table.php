<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFechaRegistroToImputadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('imputados', function (Blueprint $table) {
            $table->date('fecha_registro')->nullable()->after('apellidos');
        });
    }

    public function down()
    {
        Schema::table('imputados', function (Blueprint $table) {
            $table->dropColumn('fecha_registro');
        });
    }
}
