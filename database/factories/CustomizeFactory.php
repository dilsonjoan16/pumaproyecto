<?php

namespace Database\Factories;

use App\Models\Customize;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomizeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customize::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ruta-imagen'=>$this->faker->imageUrl(),
            'titulo'=>$this->faker->word(),
            'contenido'=>$this->faker->text(),
            'ruta-video'=>$this->faker->imageUrl(),
            'orden'=>$this->faker->numberBetween($min = 1, $max = 100), //manera de ordenar las galerias
            'estado'=>$this->faker->numberBetween($min = 1, $max = 3), //para el borrado logico : 1 aparece 2 oculto 3 borrado-logico
            'tipo'=>$this->faker->numberBetween($min = 1, $max = 4) //1 resultados 2 sorteos 3 testimonios 4 ubicanos 5 contacto
        ];
    }
}
