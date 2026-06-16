<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ['id' => 1, 'tipo' => 'admin'],
            ['id' => 2, 'tipo' => 'oficinista'],
            ['id' => 3, 'tipo' => 'secretario'],
            ['id' => 4, 'tipo' => 'capturista_imputados'],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['id' => $role['id']],
                ['tipo' => $role['tipo']]
            );
        }
    }
}
