<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ventas;
class VentasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ventas::factory(20)->create();
    }
}
