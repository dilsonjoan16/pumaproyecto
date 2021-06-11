<?php

namespace Database\Factories;

use App\Models\Sorteos;
use Illuminate\Database\Eloquent\Factories\Factory;

class SorteosFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sorteos::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "NombreSorteo" => $this->faker->randomElement($array = array('HoustonRockets','GoldenWarriors','AngelesClippers','TorontoRaptors')),
            "Tipo" => $this->faker->randomElement($array = array('1','2','3')),
            "FechaCulminacion" => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            "Numeros" => $this->faker->randomDigit,
            "NombreGanador" => $this->faker->name,
            "Vendedor" => $this->faker->name
        ];
    }
}
