<?php

namespace Database\Factories;

use App\Models\CuentaBanco;
use App\Models\SolicitudRetiro;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SolicitudRetiroFactory extends Factory
{

    protected $model = SolicitudRetiro::class;
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'monto' => $this->faker->randomFloat(2, 100, 1000),
            'status' =>  $this->faker->randomFloat(0, 0, 1),
            'id_cuenta_banco' => CuentaBanco::factory()
        ];
    }
}
