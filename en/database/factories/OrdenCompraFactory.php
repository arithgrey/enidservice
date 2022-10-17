<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrdenCompraFactory extends Factory
{

    public function definition()
    {
        return [
            'cobro_secundario' => $this->faker->randomFloat(1, 100, 2300),
        ];
    }
}
