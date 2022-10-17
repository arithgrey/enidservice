<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MotivoListaNegraFactory extends Factory
{

    public function definition()
    {
        return [
            'motivo' => $this->faker->sentence(),
            'tipo' => rand(0, 1),
        ];
    }
}
