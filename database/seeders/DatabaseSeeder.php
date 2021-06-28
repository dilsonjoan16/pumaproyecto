<?php

namespace Database\Seeders;

use App\Models\Administrador;
use App\Models\Contacto;
use App\Models\Customize;
use App\Models\Reporte;
use App\Models\User;
use App\Models\Ventas;
use App\Models\Solicitudes;
use App\Models\Premios;
use App\Models\Promotor;
use App\Models\Sorteos;
use Database\Factories\ContactoFactory;
use Database\Factories\CustomizeFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //$promotorId = Promotor::all()->value('id');

        User::factory(100)->create();
        Customize::factory(20)->create();
        Contacto::factory(10)->create();
        Administrador::factory(20)->create();
        Reporte::factory(20)->create();
        Ventas::factory(20)->create();
        Solicitudes::factory(30)->create();
        Sorteos::factory(30)->create();
        Premios::factory(30)->create();
        //Seeder de Role
        $this->call(RoleSeeder::class);
    

        
    }
}
