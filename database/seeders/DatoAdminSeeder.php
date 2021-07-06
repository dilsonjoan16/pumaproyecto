<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Administrador;
class DatoAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Administrador::factory(20)->create();
    }
}
