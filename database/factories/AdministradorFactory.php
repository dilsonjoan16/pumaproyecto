<?php

namespace Database\Factories;

use App\Models\Administrador;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdministradorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Administrador::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            
            
            'Numero' => $this->faker->numberBetween($min = 0, $max = 1000),
            'Referencia' => $this->faker->randomNumber(),
            'Valorapostado' => $this->faker->numberBetween($min = 200, $max = 10000),
            'Loteria' => $this->faker->randomElement($array = array('TripleGordo', 'Kino', 'Motilones')), //Triplegordo Kino etc
            'Usuario' => $this->faker->name(),
            'Transaccion' => $this->faker->randomElement($array = array('Exitosa', 'Esperando', 'Rechazada')), //Exitosa o Esperando
        ];
    }
}
