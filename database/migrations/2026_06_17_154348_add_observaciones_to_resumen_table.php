<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddObservacionesToResumenTable extends Migration
{
    public function up()
    {
        Schema::table('resumen', function (Blueprint $table) {
            $table->text('observaciones')->nullable()->after('hechos_ocurridos');
        });
    }

    public function down()
    {
        Schema::table('resumen', function (Blueprint $table) {
            $table->dropColumn('observaciones');
        });
    }
}