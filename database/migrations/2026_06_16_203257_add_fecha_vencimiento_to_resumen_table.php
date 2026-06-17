<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFechaVencimientoToResumenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::table('resumen', function (Blueprint $table) {

            $table->integer('plazo')->nullable()->change();

            $table->date('fecha_vencimiento')
                  ->nullable()
                  ->after('plazo');
        });
    }

    public function down()
    {
        Schema::table('resumen', function (Blueprint $table) {

            $table->string('plazo',45)->nullable()->change();

            $table->dropColumn('fecha_vencimiento');
        });
    }
}
