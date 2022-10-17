<?php

namespace Database\Factories;

use App\Models\ProyectoPersonaFormaPago;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UbicacionFactory extends Factory
{

    public function definition()
    {
        return [

            'ubicacion' => $this->faker->text(),
            'id_recibo' => ProyectoPersonaFormaPago::factory(),
            'id_usuario' => User::factory(),
            'id_alcaldia' => $this->faker->randomDigit(),
            'cp' => $this->faker->randomDigit(1,100),
            'delegacion' => 'Iztacalco',
        ];
    }
}
