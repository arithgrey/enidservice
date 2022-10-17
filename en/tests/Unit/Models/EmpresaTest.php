<?php

namespace Tests\Unit\Models;

use App\Models\Empresa;
use App\Models\Sector;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmpresaTest extends TestCase
{

    use RefreshDatabase;
    public function test_tiene_muchos_usuarios()
    {

        $empresa = new Empresa();

        $this->assertInstanceOf(Collection::class, $empresa->users);
    }
    public function test_pertenece_a_un_sector()
    {

        $empresa =  Empresa::factory()->create();
        $this->assertInstanceOf(Sector::class, $empresa->sector);

    }

}
