<?php

namespace Tests\Feature\Http\Controllers\CuentaBanco;

use App\Models\Banco;
use App\Models\CuentaBanco;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CuentaBancoControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    public function test_registrar_cuenta_banco()
    {

        $user = User::factory()->create();
        $banco = Banco::factory()->create();

        $data = [
            'tarjeta' => $this->faker->creditCardNumber,
            'propietario' => $this->faker->name(),
            'user_id' => $user->id,
            'id_banco' => $banco->id,
        ];

        $response = $this->actingAs($user)
            ->post('cuenta-banco', $data)
            ->assertRedirect('cuenta-banco');

        $this->assertDatabaseHas('cuenta_bancos', $data);
    }
    public function test_valida_registrar_sin_datos()
    {

        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post('cuenta-banco', [])
            ->assertSessionHasErrors(['tarjeta', 'propietario']);


    }
    public function test_actualiza()
    {

        $user = User::factory()->create();
        $cuenta_banco =  CuentaBanco::factory()->create();

        $data = [
            'tarjeta' => $this->faker->creditCardNumber,
            'propietario' => $this->faker->name(),
        ];


        $response = $this
            ->actingAs($user)
            ->put("cuenta-banco/$cuenta_banco->id", $data)
            ->assertRedirect('cuenta-banco');

        $this->assertDatabaseHas('cuenta_bancos', $data);


    }
}
