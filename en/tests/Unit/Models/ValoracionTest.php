<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Valoracion;

class ValoracionTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_slug()
    {

        $valoracion = Valoracion::factory(
            [
                'titulo' => 'hola esto es slug'
            ]
        )->create();
        $this->assertEquals('hola-esto-es-slug', $valoracion->slug);
    }
}
