<?php

namespace Tests\Unit\Models;

use App\Models\FormaPago;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FormaPagoTest extends TestCase
{

    use RefreshDatabase;

    public function test_tiene_muchos_ppfp()
    {
        $forma_pago = new FormaPago();

        $this->assertInstanceOf(Collection::class, $forma_pago->ppfps);
    }
}
