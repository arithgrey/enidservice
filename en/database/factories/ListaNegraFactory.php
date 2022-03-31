<?php

namespace Database\Factories;

use App\Models\MotivoListaNegra;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ListaNegraFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_usuario' => User::factory(),
            'id_motivo' => MotivoListaNegra::factory()
        ];
    }
}
