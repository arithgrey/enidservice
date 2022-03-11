<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CicloFacturacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            "ciclo" => $this->faker->sentence(),
            "flag_meses" => rand(0, 1),
            "num_meses" => rand(1, 6),
            "status" => rand(0, 1)

        ];
    }
}
