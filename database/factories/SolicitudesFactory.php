<?php

namespace Database\Factories;

use App\Models\Solicitudes;
use Illuminate\Database\Eloquent\Factories\Factory;

class SolicitudesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Solicitudes::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            
            "Nombre" => $this->faker->name,
            "CantidadSolicitada" => $this->faker->numberBetween($min = 1000, $max = 9000),
            "Cuotas" => $this->faker->randomDigit,
            "MobiliarioSolicitado" => $this->faker->randomElement($array = array('Vitrinas', 'Mostradores', 'Telefonos', 'Verificadores', 'Computadores', 'Impresoras')),
            "Ubicacion" => $this->faker->streetAddress,
            "Solicitud" => $this->faker->randomElement($array = array('Urgente', 'No Urgente'))

        ];
    }
}
