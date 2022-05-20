<?php

namespace Tests\Unit\Models;

use App\Models\Ubicacion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;


class UbicacionTest extends TestCase
{

    use RefreshDatabase;

    public function test_pertenece_a_un_usuario()
    {
        $ubicacion = Ubicacion::factory()->create();
        $this->assertInstanceOf(User::class, $ubicacion->user);
    }
    public function test_pertenece_a_un_ppfp()
    {
        $ubicacion = Ubicacion::factory()->create();
        $this->assertInstanceOf(User::class, $ubicacion->ppfp);
    }
}
