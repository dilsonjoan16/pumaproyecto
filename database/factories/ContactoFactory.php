<?php

namespace Database\Factories;

use App\Models\Contacto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contacto::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre_contacto' => $this->faker->name(),
            'correo_contacto' => $this->faker->safeEmail(),
            'mensaje_contacto' => $this->faker->text(),
        ];
    }
}
