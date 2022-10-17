<?php

namespace Tests\Unit\Models;

use App\Models\CicloFacturacion;
use App\Models\FormaPago;
use App\Models\ProyectoPersonaFormaPago;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class ProyectoPersonaFormaPagoTest extends TestCase
{

    use RefreshDatabase;

    public function test_pertenece_a_una_forma_pago()
    {

        $ppfp = ProyectoPersonaFormaPago::factory()->create();
        $this->assertInstanceOf(FormaPago::class, $ppfp->forma_pago);
    }

    public function test_pertenece_a_ciclo_facturacion()
    {

        $ppfp = ProyectoPersonaFormaPago::factory()->create();
        $this->assertInstanceOf(CicloFacturacion::class, $ppfp->ciclo_facturacion);
    }


}
