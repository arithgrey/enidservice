<?php

namespace Database\Factories;

use App\Models\OrdenCompra;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrdenComentarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'comentario' => $this->faker->sentence(),
            'id_orden_compra' => OrdenCompra::factory()
        ];
    }
}
