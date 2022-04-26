<?php

namespace Database\Seeders;

use App\Models\FormaPago;
use Illuminate\Database\Seeder;

class FormaPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FormaPago::create([
            'id' => 1,
            'forma_pago' => 'Trasferencia bancaria',
        ]);

        FormaPago::create([
            'id' => 2,
            'forma_pago' => 'Trasferencia Paypal',
        ]);

        FormaPago::create([
            'id' => 3,
            'forma_pago' => 'Pago en efectivo',
        ]);

        FormaPago::create([
            'id' => 4,
            'forma_pago' => 'Depósito a cuenta BBVA Bancomer',
        ]);

        FormaPago::create([
            'id' => 5,
            'forma_pago' => 'No aplica',
        ]);

        FormaPago::create([
            'id' => 6,
            'forma_pago' => 'Aún sin pagar',
        ]);

        FormaPago::create([
            'id' => 7,
            'forma_pago' => 'Pago contra entrega efectivo',
        ]);

        FormaPago::create([
            'id' => 8,
            'forma_pago' => 'Pago contra entrega Transferencia',
        ]);

        FormaPago::create([
            'id' => 9,
            'forma_pago' => 'Mercado Pago',
        ]);

    }
}
