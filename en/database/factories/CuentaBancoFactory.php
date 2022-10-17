<?php

namespace Database\Factories;

use App\Models\Banco;
use App\Models\CuentaBanco;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CuentaBancoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = CuentaBanco::class;
    public function definition()
    {
        return [

            'tarjeta' => $this->faker->creditCardNumber,
            'propietario' => $this->faker->name(),
            'user_id' => User::factory(),
            'id_banco' => Banco::factory(),

        ];
    }
}
