<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'dni' => $this->faker->numberBetween($min = 1000000, $max = 30000000),
            'ganancia' => $this->faker->numberBetween($min = 1000, $max = 9000),
            'porcentaje' => $this->faker->numberBetween($min = 5, $max = 25),
            'foto' => $this->faker->imageUrl($width = 640, $height = 480),
            'direccion' => $this->faker->address,
            'telefono' => $this->faker->randomNumber(),
            'codigo' => $this->faker->swiftBicNumber
            
            
            
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
