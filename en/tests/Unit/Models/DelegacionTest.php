<?php

namespace Tests\Unit\Models;

use App\Models\Delegacion;
use App\Models\EstadoRepublica;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DelegacionTest extends TestCase
{

    use RefreshDatabase;
    public function test_pertenece_a_un_estado()
    {
        $delegacion = Delegacion::factory()->create();
        $this->assertInstanceOf(EstadoRepublica::class, $delegacion->estado);
    }
    public function test_tiene_muchas_colonias()
    {
        $delegacion = new Delegacion();

        $this->assertInstanceOf(Collection::class, $delegacion->colonias);
    }

}
