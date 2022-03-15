<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CountrieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'countryName' => $this->faker->country(),
            'moneda' => $this->faker->languageCode(),
            'prefijo' => $this->faker->countryCode(),
        ];
    }
}
