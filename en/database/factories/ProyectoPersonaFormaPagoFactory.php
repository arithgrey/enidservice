<?php

namespace Database\Factories;

use App\Models\CicloFacturacion;
use App\Models\FormaPago;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProyectoPersonaFormaPagoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_forma_pago' => FormaPago::factory(),
            'id_ciclo_facturacion' => CicloFacturacion::factory(),
            'id_usuario_referencia' => 1,
            'id_usuario_venta' => 1,
            'saldo_cubierto' => $this->faker->randomFloat(1, 100, 2300),
            'num_ciclos_contratados' => rand(1,3),
        ];
    }
}
