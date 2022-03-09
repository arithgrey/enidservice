<?php

namespace Database\Factories;

use App\Models\Banco;
use Illuminate\Database\Eloquent\Factories\Factory;

class BancoFactory extends Factory
{

    protected $model = Banco::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->name,
            'imagen' => $this->faker->imageUrl(1280, 720),
        ];
    }
}
