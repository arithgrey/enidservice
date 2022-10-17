<?php

namespace Tests\Unit\Models;

use App\Models\Empresa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;


class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_tiene_muchas_solicitudes_retiro()
    {
        $user = new User;

        $this->assertInstanceOf(Collection::class, $user->solicitudes_retiro);
    }
    public function test_pertenece_a_una_empresa()
    {
        $user = User::factory()->create();
        $this->assertInstanceOf(Empresa::class, $user->empresa);

    }
    public function test_tiene_muchas_listas_negras()
    {
        $user = new User;

        $this->assertInstanceOf(Collection::class, $user->listas_negras);
    }

    public function test_tiene_muchos_ppfps()
    {
        $user = new User;

        $this->assertInstanceOf(Collection::class, $user->ppfps);
    }


}
