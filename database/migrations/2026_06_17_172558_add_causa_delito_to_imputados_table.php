<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCausaDelitoToImputadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('imputados', function (Blueprint $table) {
            $table->string('causa', 45)->nullable()->after('fecha_registro');

            $table->unsignedInteger('delitos_id')->nullable()->after('causa');

            $table->foreign('delitos_id')
                ->references('id')
                ->on('delitos');
        });
    }

    public function down()
    {
        Schema::table('imputados', function (Blueprint $table) {
            $table->dropForeign(['delitos_id']);
            $table->dropColumn(['causa', 'delitos_id']);
        });
    }
}
