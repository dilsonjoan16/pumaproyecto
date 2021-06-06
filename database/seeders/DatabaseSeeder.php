<?php

namespace Database\Seeders;

use App\Models\Contacto;
use App\Models\Customize;
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
         \App\Models\User::factory(100)->create();
        Customize::factory(20)->create();
        Contacto::factory(10)->create();

        //Seeder de Role
        $this->call(RoleSeeder::class);

        
    }
}
