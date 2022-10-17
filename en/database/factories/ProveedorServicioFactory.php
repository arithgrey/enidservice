<?php

namespace Database\Factories;

use App\Models\Servicio;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProveedorServicioFactory extends Factory
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
            'id_servicio' => Servicio::factory(),
            'costo' => $this->faker->randomFloat(0, 300, 500),
            'telefono' => $this->faker->phoneNumber(),
            'nombre' => $this->faker->name(),
            'pagina_web' =>  $this->faker->url(),
            'ubicacion' => $this->faker->address(),
            'es_fabricante' => $this->faker->boolean(),

        ];
    }
}
