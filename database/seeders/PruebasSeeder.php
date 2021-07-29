<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Customize;
use App\Models\Administrador;
use App\Models\Reporte;
use App\Models\Ventas;
use App\Models\Solicitudes;
use App\Models\RolesUser;
class PruebasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(100)->create();
        Customize::factory(20)->create();
        Administrador::factory(20)->create();
        Reporte::factory(20)->create();
        Ventas::factory(20)->create();
        Solicitudes::factory(30)->create();
        //Roles del sistema
        RolesUser::create(['nombre' => 'Administrador']);
        RolesUser::create(['nombre' => 'Promotor']);
        RolesUser::create(['nombre' => 'Vendedor']);
        RolesUser::create(['nombre' => 'PromotorAlfa']);
        //Seeder de Role
        $this->call(RoleSeeder::class);
    }
}
