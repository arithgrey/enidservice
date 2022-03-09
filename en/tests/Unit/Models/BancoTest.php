<?php

namespace Tests\Unit\Models;

use App\Models\Banco;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;

use Tests\TestCase;



class BancoTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    use RefreshDatabase;


    public function test_tiene_muchas_cuentas_pago()
    {
        $banco = new Banco();
        $this->assertInstanceOf(Collection::class, $banco->cuentas_banco);
    }


}
