<?php

namespace Tests\Unit\Models;

use App\Models\OrdenCompra;
use App\Models\ProductoOrdenCompra;
use App\Models\ProyectoPersonaFormaPago;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class ProductoOrdenCompraTest extends TestCase
{
    use RefreshDatabase;

    function test_pertenece_a_una_orden_compra()
    {

        $producto_orden_compra= ProductoOrdenCompra::factory()->create();
        $this->assertInstanceOf(OrdenCompra::class, $producto_orden_compra->orden_compra);
    }
    function test_pertenece_a_un_ppfp()
    {

        $producto_orden_compra = ProductoOrdenCompra::factory()->create();
        $this->assertInstanceOf(ProyectoPersonaFormaPago::class, $producto_orden_compra->ppfp);
    }


}
