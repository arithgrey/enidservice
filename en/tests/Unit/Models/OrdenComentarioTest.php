<?php

namespace Tests\Unit\Models;

use App\Models\OrdenComentario;
use App\Models\OrdenCompra;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrdenComentarioTest extends TestCase
{

    use RefreshDatabase;
    public function test_pertenece_a_una_orden_compra()
    {

        $orden_comentario = OrdenComentario::factory()->create();
        $this->assertInstanceOf(OrdenCompra::class, $orden_comentario->orden_compra);
    }
}
