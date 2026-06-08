<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `usuarios` MODIFY `contrasena` VARCHAR(255) NULL COLLATE latin1_swedish_ci');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE `usuarios` MODIFY `contrasena` VARCHAR(50) NULL COLLATE latin1_swedish_ci');
    }
};
