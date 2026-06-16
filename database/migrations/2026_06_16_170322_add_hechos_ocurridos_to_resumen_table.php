<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHechosOcurridosToResumenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resumen', function (Blueprint $table) {
            $table->text('hechos_ocurridos')->nullable()->after('medida');
        });
    }

    public function down()
    {
        Schema::table('resumen', function (Blueprint $table) {
            $table->dropColumn('hechos_ocurridos');
        });
    }
}
