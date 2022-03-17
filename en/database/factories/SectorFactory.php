<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SectorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    use RefreshDatabase;

    public function definition()
    {
        return [
            'nombre' => $this->faker->company(),
            'status' => rand(0,1),
        ];
    }
}
