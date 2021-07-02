<?php

namespace Database\Factories;

use App\Models\Ventas;
use Illuminate\Database\Eloquent\Factories\Factory;

class VentasFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ventas::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //"Campo" => $this->faker->metodo(),
            "Fecha" => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            "Numero" => $this->faker->randomDigit,
            "Valorapuesta" => $this->faker->numberBetween($min = 20, $max = 10000),
            "Loteria" => $this->faker->randomElement($array = array('TripleGordo', 'Kino', 'TripleZulia', 'Motilones', 'Cortillos')),
            "Tipo" => $this->faker->randomElement($array = array('Directo', 'Combinado')), //Directo o Combinado
            //AGREGADO REFERENCIA->DESCRIPCION
            "Referencia" => $this->faker->randomElement($array = array('Apuesta Alta','Apuesta Baja','Parley','Rifa','Sorteo')),
            //Menu lateral de las vistas
            //"Sumatotalventas" => $this->faker->numberBetween($min =200, $max = 400), //Suma total de las Ventas
            "Puntoventas" => $this->faker->city, //Punto de Ventas
            //"Nombrepromotor" => $this->faker->name(), //Nombre del Promotor
            "Puntoentregaventas" =>$this->faker->streetAddress //Punto de entregas de las ventas
        ];
    }
}
