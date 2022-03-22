<?php

namespace Tests\Unit\Models;

use App\Models\Colonia;
use App\Models\Delegacion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ColoniaTest extends TestCase
{
    use RefreshDatabase;
    public function test_pertenece_a_una_delegacion()
    {
        $colonia = Colonia::factory()->create();
        $this->assertInstanceOf(Delegacion::class, $colonia->delegacion);

    }

}
