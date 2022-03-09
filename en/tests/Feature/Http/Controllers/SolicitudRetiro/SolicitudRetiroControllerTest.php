<?php

namespace Tests\Feature\Http\Controllers\SolicitudRetiro;

use App\Models\SolicitudRetiro;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SolicitudRetiroControllerTests extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function test_index_sin_datos()
    {
        $user = User::factory()->create(); //Usuario 1
        $solicitud_retiro = SolicitudRetiro::factory()->create();

        $this->actingAs($user)
            ->get("solicitud-retiro")
            ->assertStatus(200);
    }
    public function test_index_con_datos()
    {
        $user = User::factory()->create(); //Usuario 1
        $solicitud_retiro = SolicitudRetiro::factory()->create([
            'user_id' => $user->id
        ]);

        $this->actingAs($user)
            ->get("solicitud-retiro")
            ->assertStatus(200)
            ->assertSee($solicitud_retiro->monto)
            ->assertSee($solicitud_retiro->status);
    }

    public function test_invitado()
    {
        $this->get('solicitud-retiro')->assertRedirect('login');
        $this->get('solicitud-retiro/1')->assertRedirect('login');
        $this->get('solicitud-retiro/1/edit')->assertRedirect('login');
        $this->put('solicitud-retiro/1')->assertRedirect('login');
        $this->post('solicitud-retiro', [])->assertRedirect('login');
    }
    public function test_crear()
    {

        $user = User::factory()->create();
        $this->actingAs($user)
            ->get("solicitud-retiro/create")
            ->assertStatus(200);
    }
    public function test_registrar()
    {
        $data = [
            'monto' => $this->faker->randomFloat(2, 100, 1000),
        ];

        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('solicitud-retiro', $data)
            ->assertRedirect('solicitud-retiro');

        $this->assertDatabaseHas('solicitud_retiros', $data);
    }
    public function test_actualizar()
    {

        $user = User::factory()->create();
        $solicitud_retiro = SolicitudRetiro::factory()->create(
            [
                'user_id' => $user
            ]
        );


        $data = [
            'monto' => $this->faker->randomFloat(2, 100, 1000),
            'status' => rand(1, 2)
        ];

        $this->actingAs($user)
            ->put("solicitud-retiro/$solicitud_retiro->id", $data)
            ->assertRedirect('solicitud-retiro');

        $this->assertDatabaseHas('solicitud_retiros', $data);
    }

    public function test_validacion_al_crear()
    {

        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('solicitud-retiro', [])
            ->assertStatus(302)
            ->assertSessionHasErrors(['monto']);
    }
    public function test_validacion_al_actualizar()
    {

        $solicitud_retiro = SolicitudRetiro::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($user)
            ->put("solicitud-retiro/$solicitud_retiro->id", [])
            ->assertStatus(302)
            ->assertSessionHasErrors(['status']);
    }
    public function test_validacion_al_eliminar()
    {
        $user = User::factory()->create();
        $solicitud_retiro = SolicitudRetiro::factory()->create(
            [
                'user_id' => $user
            ]
        );


        $this->actingAs($user)
            ->delete("solicitud-retiro/$solicitud_retiro->id")
            ->assertStatus(302);

        $this->assertDatabaseMissing(
            "solicitud_retiros",
            [
                'id' => $solicitud_retiro->id,
                'status' => $solicitud_retiro->status,
                'monto' => $solicitud_retiro->monto,
            ]
        );
    }
    public function test_actualizar_solo_usuario_propietario()
    {

        $user = User::factory()->create(); //Aquí se crea un primer usuario
        $solicitud_retiro = SolicitudRetiro::factory()->create(); //aquí se crea un usuario desde el factory de solicitud

        $data = [
            'monto' => $this->faker->randomFloat(2, 100, 1000),
            'status' => rand(1, 2)
        ];

        /*Se intenta actualizar datos de la solicitud pero con un usuario distinto*/
        $this->actingAs($user)
            ->put("solicitud-retiro/$solicitud_retiro->id", $data)
            ->assertStatus(403);

        /*403 el servidor detiene dicha acción*/
    }
    public function test_eliminar_solo_usuario_propietario()
    {

        $user = User::factory()->create(); //Aquí se crea un primer usuario
        $solicitud_retiro = SolicitudRetiro::factory()->create(); //aquí se crea un usuario desde el factory de solicitud

        $data = [
            'monto' => $this->faker->randomFloat(2, 100, 1000),
            'status' => rand(1, 2)
        ];

        /*Se intenta actualizar datos de la solicitud pero con un usuario distinto*/
        $this->actingAs($user)
            ->delete("solicitud-retiro/$solicitud_retiro->id")
            ->assertStatus(403);

        /*403 el servidor detiene dicha acción*/
    }
    public function test_ver_registro_individual()
    {

        $user = User::factory()->create();
        $solicitud_retiro = SolicitudRetiro::factory()->create([
            'user_id' => $user->id
        ]);


        $this->actingAs($user)
            ->get("solicitud-retiro/$solicitud_retiro->id")
            ->assertStatus(200);
    }
    public function test_ver_registro_individual_propietario()
    {

        $user = User::factory()->create();
        $solicitud_retiro = SolicitudRetiro::factory()->create();

        $this->actingAs($user)
            ->get("solicitud-retiro/$solicitud_retiro->id")
            ->assertStatus(403);
    }
}
