<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::table('users')->insert([
            'name' => "usuariopuma",
            'email' => "usuariopuma@gmail.com",
            'password' => bcrypt('usuariopuma')
        ])->assignRole('Administrador');

        User::factory(9)->create();
    }
}
