<?php

namespace Tests\Unit\Models;

use App\Models\OrdenCompra;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrdenCompraTest extends TestCase
{

    use RefreshDatabase;
    public function test_tienen_muchos_comentarios_orden_compra()
    {
        $orden_compra = new OrdenCompra();
        $this->assertInstanceOf(Collection::class, $orden_compra->orden_comentarios);
    }
}
