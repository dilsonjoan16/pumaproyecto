<?php

namespace Database\Factories;

use App\Models\Reporte;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReporteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Reporte::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'Monto' => $this->faker->numberBetween($min = 1000, $max = 9000),
            'Salida' => $this->faker->randomElement($array = array('Acumulado', 'Caja')), // Esto es Acumulado o Caja
            'Tipo' => $this->faker->randomElement($array = array('Gasto', 'Pago', 'Premio')), //Esto es Gasto, Pago, Premio
            'Descripcion' => $this->faker->text(),
            'Referencia' => $this->faker->randomElement($array = array('Pago de Rifa', 'Pago de Sorteo', 'Pago de Pago')),
            'Transaccion' => $this->faker->randomElement($array = array('Exitosa', 'En espera', 'Infructuosa')),
        ];
    }
}
