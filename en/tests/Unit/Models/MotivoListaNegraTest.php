<?php

namespace Tests\Unit\Models;

use App\Models\MotivoListaNegra;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MotivoListaNegraTest extends TestCase
{

    use RefreshDatabase;

    public function test_tiene_muchas_listas_negras()
    {
        $motivo_lista_negra = new MotivoListaNegra();
        $this->assertInstanceOf(Collection::class, $motivo_lista_negra->listas_negras);
    }
}
