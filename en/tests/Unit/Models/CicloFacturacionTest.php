<?php

namespace Tests\Unit\Models;

use App\Models\CicloFacturacion;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;

class CicloFacturacionTest extends TestCase
{

    public function test_tiene_muchos_servicios()
    {

        $ciclo_facturacion = new CicloFacturacion();
        $this->assertInstanceOf(Collection::class, $ciclo_facturacion->servicios);
    }
}
