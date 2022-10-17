<?php

namespace Tests\Unit\Models;

use App\Models\CuentaBanco;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\SolicitudRetiro;
use App\Models\User;
use Tests\TestCase;

class SolicitudRetiroTest extends TestCase
{

    use RefreshDatabase;
    public function test_pertenece_a_un_usuario()
    {
        $solicitud_retiro = SolicitudRetiro::factory()->create();
        $this->assertInstanceOf(User::class, $solicitud_retiro->user);
    }
    public function test_pertenece_a_una_cuenta_banco()
    {
        $solicitud_retiro = SolicitudRetiro::factory()->create();
        $this->assertInstanceOf(CuentaBanco::class, $solicitud_retiro->cuenta_banco);
    }

}
