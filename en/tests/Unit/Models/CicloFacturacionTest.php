<?php

namespace Tests\Unit\Models;

use App\Models\CicloFacturacion;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CicloFacturacionTest extends TestCase
{

    use RefreshDatabase;
    public function test_tiene_muchos_servicios()
    {

        $ciclo_facturacion = new CicloFacturacion();
        $this->assertInstanceOf(Collection::class, $ciclo_facturacion->servicios);
    }
    public function test_tiene_muchos_ppfps()
    {

        $ciclo_facturacion = new CicloFacturacion();
        $this->assertInstanceOf(Collection::class, $ciclo_facturacion->ppfps);
    }

}
