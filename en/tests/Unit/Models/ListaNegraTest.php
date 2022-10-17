<?php

namespace Tests\Unit\Models;

use App\Models\ListaNegra;
use App\Models\MotivoListaNegra;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;


class ListaNegraTest extends TestCase
{
    use RefreshDatabase;
    function test_pertenece_a_un_motivo()
    {

        $lista_negra  = ListaNegra::factory()->create();
        $this->assertInstanceOf(MotivoListaNegra::class, $lista_negra->motivo);
    }
}
