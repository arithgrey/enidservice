<?php

namespace Tests\Unit\Models;

use App\Models\EstadoRepublica;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EstadoRepublicaTest extends TestCase
{
    use RefreshDatabase;

    public function test_tiene_muchas_delegaciones()
    {
        $estado_republica = new EstadoRepublica();

        $this->assertInstanceOf(Collection::class, $estado_republica->delegaciones);
    }

}
