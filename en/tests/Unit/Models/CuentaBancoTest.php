<?php

namespace Tests\Unit\Models;


use App\Models\Banco;
use App\Models\CuentaBanco;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CuentaBancoTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
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

}
