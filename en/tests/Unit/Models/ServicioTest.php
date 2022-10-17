<?php

namespace Tests\Unit\Models;

use App\Models\CicloFacturacion;
use App\Models\Clasificacion;
use App\Models\Servicio;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServicioTest extends TestCase
{
    use RefreshDatabase;

    public function test_pertenece_a_una_clasificacion()
    {
        $servicio = Servicio::factory()->create();
        $this->assertInstanceOf(Clasificacion::class, $servicio->clasificacion);

    }
    public function test_pertenece_a_un_usuario()
    {
        $servicio = Servicio::factory()->create();
        $this->assertInstanceOf(User::class, $servicio->user);

    }

    public function test_pertenece_a_un_ciclo_facturacion()
    {
        $servicio = Servicio::factory()->create();

        $this->assertInstanceOf(CicloFacturacion::class, $servicio->ciclo_facturacion);

    }


}
