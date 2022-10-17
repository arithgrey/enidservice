<?php

namespace Database\Factories;

use App\Models\Countrie;
use Illuminate\Database\Eloquent\Factories\Factory;

class EstadoRepublicaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'estado' => $this->faker->name(),
            'id_pais' => Countrie::factory()
        ];
    }
}
