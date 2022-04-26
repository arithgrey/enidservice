<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FormaPagoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'forma_pago' =>  $this->faker->name(),
        ];
    }
}
