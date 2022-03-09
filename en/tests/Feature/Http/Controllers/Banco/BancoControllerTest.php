<?php

namespace Tests\Feature\Http\Controllers\Banco;

use App\Models\Banco;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BancoControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;


    public function test_index_sin_datos()
    {
        Banco::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get("banco")
            ->assertStatus(200);
    }

    public function test_sin_acceso_invitado()
    {
        $this->get('banco')->assertRedirect('login');
        $this->get('banco/1')->assertRedirect('login');
        $this->get('banco/1/edit')->assertRedirect('login');
        $this->put('banco/1')->assertRedirect('login');
        $this->post('banco', [])->assertRedirect('login');
    }
    public function test_registrar()
    {

        $data = [
            'nombre' => $this->faker->name(),
            'imagen' => $this->faker->imageUrl(1280, 720),
        ];

        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->post('banco', $data);


        $this->assertDatabaseHas('bancos', $data);
        //$response->dumpSession();

    }
    public function test_validacion_datos_requeridos_al_crear()
    {

        $user = User::factory()->create();

        $this->actingAs($user)->post('banco', [])
            ->assertStatus(302)
            ->assertSessionHasErrors(['nombre']);
    }
}
