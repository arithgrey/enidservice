<?php

namespace Tests\Unit\Models;


use App\Models\Banco;
use App\Models\CuentaBanco;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class CuentaBancoTest extends TestCase
{

    use RefreshDatabase;

    public function test_pertenece_a_un_usuario()
    {
        $cuenta_banco = CuentaBanco::factory()->create();
        $this->assertInstanceOf(User::class, $cuenta_banco->user);
    }

    public function test_pertenece_a_un_banco()
    {
        $cuenta_banco = CuentaBanco::factory()->create();
        $this->assertInstanceOf(Banco::class, $cuenta_banco->banco);
    }
    public function test_tiene_muchas_solicitudes_retiro()
    {

        $cuenta_banco = new CuentaBanco();
        $this->assertInstanceOf(Collection::class, $cuenta_banco->solicitudes_retiro);
    }
}
