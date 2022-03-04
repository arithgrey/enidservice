<?php

namespace Database\Factories;

use App\Models\TipoValoracion;
use Illuminate\Database\Eloquent\Factories\Factory;

class TipoValoracionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = TipoValoracion::class;
    public function definition()
    {
        return [
            'nombre' => $this->faker->name,
            'status' => rand(0, 1),
        ];
    }
}
