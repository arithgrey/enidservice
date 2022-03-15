<?php

namespace Database\Factories;

use App\Models\Delegacion;
use Illuminate\Database\Eloquent\Factories\Factory;

class ColoniaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'colonia'  => $this->faker->name(),
            'id_delegacion' => Delegacion::factory(),
            'cp' => $this->faker->postcode()
        ];
    }
}
