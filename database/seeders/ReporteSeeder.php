<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reporte;
class ReporteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Reporte::factory(20)->create();
    }
}
