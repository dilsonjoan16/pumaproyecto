<?php

namespace Database\Seeders;

use App\Models\RolesUser;
use Illuminate\Database\Seeder;

class RolesUsersSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Roles del sistema
        RolesUser::create(['nombre' => 'Administrador']);
        RolesUser::create(['nombre' => 'Promotor']);
        RolesUser::create(['nombre' => 'Vendedor']);
        RolesUser::create(['nombre' => 'PromotorAlfa']);
    }
}
