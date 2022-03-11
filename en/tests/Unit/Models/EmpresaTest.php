<?php

namespace Tests\Unit\Models;

use App\Models\Empresa;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;

class EmpresaTest extends TestCase
{

    public function test_tiene_muchos_usuarios()
    {

        $empresa = new Empresa();

        $this->assertInstanceOf(Collection::class, $empresa->users);
    }

}
