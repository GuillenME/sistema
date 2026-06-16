<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddCapturistaImputadosRole extends Migration
{
    public function up()
    {
        DB::table('roles')->updateOrInsert(
            ['id' => 4],
            ['tipo' => 'capturista_imputados']
        );
    }

    public function down()
    {
        $roleId = DB::table('roles')
            ->where('tipo', 'capturista_imputados')
            ->value('id');

        if ($roleId && DB::table('usuarios')->where('roles_id', $roleId)->doesntExist()) {
            DB::table('roles')->where('id', $roleId)->delete();
        }
    }
}
