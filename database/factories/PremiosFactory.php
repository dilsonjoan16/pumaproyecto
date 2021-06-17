<?php

namespace Database\Factories;

use App\Models\Premios;
use Illuminate\Database\Eloquent\Factories\Factory;

class PremiosFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Premios::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "Nombre" => $this->faker->randomElement($array = array('Carro 0 Km','Moto 0 Km','Apartamento')),
            "MontoReferencia" => $this->faker->randomNumber,
        ];
    }
}
