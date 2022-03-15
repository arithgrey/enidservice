<?php

namespace Tests\Unit\Models;

use App\Models\Preferencia;
use App\Models\Servicio;
use App\Models\User;
use PHPUnit\Framework\TestCase;

class PreferenciaTest extends TestCase
{

    function test_pertece_a_un_usuario()
    {

        $preferencia = Preferencia::factory()->create();
        $this->assertInstanceOf(User::class, $preferencia->user);

    }
    function test_pertece_a_un_servicio()
    {
        $preferencia = Preferencia::factory()->create();
        $this->assertInstanceOf(Servicio::class, $preferencia->user);
    }

}
