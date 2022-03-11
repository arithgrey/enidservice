<?php

namespace Tests\Unit\Models;

use App\Models\Clasificacion;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class ClasificacionTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_tiene_muchos_servicios()
    {

        $clasificacion = new Clasificacion();
        $this->assertInstanceOf(Collection::class, $clasificacion->servicios);

    }
}
