<?php

namespace Tests\Unit\Models;

use App\Models\ProveedorServicio;
use App\Models\Servicio;
use App\Models\User;
use PHPUnit\Framework\TestCase;

class proveedorServicioTest extends TestCase
{

    function test_pertenece_a_un_servicio()
    {

        $proveedor_servicio  = ProveedorServicio::factory()->create();
        $this->assertInstanceOf(Servicio::class, $proveedor_servicio->servicio);
    }
    function test_pertenece_a_un_usario()
    {

        $proveedor_servicio  = ProveedorServicio::factory()->create();
        $this->assertInstanceOf(User::class, $proveedor_servicio->usuario);
    }
}
