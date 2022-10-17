<?php

namespace Database\Factories;

use App\Models\EstadoRepublica;
use Illuminate\Database\Eloquent\Factories\Factory;

class DelegacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'delegacion' =>  $this->faker->name(),
            'id_estado' => EstadoRepublica::factory()

        ];
    }
}
