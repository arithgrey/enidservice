<?php

namespace Tests\Feature\Http\Controllers\Valoracion;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Valoracion as ValoracionModel;

class ValoracionControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_store()
    {
        $faker = \Faker\Factory::create();
        $email = $faker->unique()->safeEmail;

        $response = $this->post(
            'valoracion',
            [
                'comentario' => $faker->text(200),
                'calificacion' => rand(1, 5),
                'recomendaria' => rand(0, 1),
                'titulo' => $faker->text(20),
                'email' => $email,
                'nombre' => $faker->name,
                'id_servicio' => rand(10, 1000),
                'id_tipo_valoracion' => rand(1, 3),

            ]
        );

        $this->assertDatabaseHas('valoracions', ['email' => $email]);
        //$response->dumpSession();
    }

    public function test_destroy()
    {
        $valoracion = ValoracionModel::factory()->create();
        $id =  $valoracion->id;
        $this->delete("valoracion/$id");
        $this->assertDatabaseMissing("valoracions", ['id' => $id]);
    }

    public function test_validate()
    {
        $faker = \Faker\Factory::create();

        $response = $this->post(
            'valoracion',
            [
                'comentario' => '',
                'recomendaria' => rand(0, 1),
                'nombre' => $faker->name,
                'id_servicio' => rand(100, 1000),
                'status' => rand(1, 5),
            ]
        )->assertSessionHasErrors(['email', 'titulo', 'calificacion', 'comentario', 'id_tipo_valoracion']);
    }
}
