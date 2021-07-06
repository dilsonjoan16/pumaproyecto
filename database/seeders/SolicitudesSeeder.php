<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Solicitudes;
class SolicitudesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Solicitudes::factory(30)->create();
    }
}
