<?php

namespace Database\Factories;

use App\Models\OrdenCompra;
use App\Models\ProyectoPersonaFormaPago;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoOrdenCompraFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_proyecto_persona_forma_pago' => ProyectoPersonaFormaPago::factory(),
            'id_orden_compra' => OrdenCompra::factory(),
        ];
    }
}
