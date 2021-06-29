<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customize;

class CustomizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customize::factory(20)->create();
    }
}
