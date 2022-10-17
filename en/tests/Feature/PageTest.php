<?php

namespace Tests\Feature;

use App\Models\Valoracion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Tests\TestCase;

class PageTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_valoraciones()
    {
        $response = $this->get('valoraciones/12');

        $response->assertStatus(200);
    }
    public function test_404_si_no_pasamos_el_servicio()
    {
        $response = $this->get('valoraciones');

        $response->assertStatus(404);
    }

    public function test_listado_valoraciones()
    {
        $response = $this->get('valoracion');

        $response->assertStatus(200);
    }
    public function test_busqueda_valoracion()
    {
        $titulo = $this->valoracion()->titulo;
        $response = $this->get("valoracion?q=$titulo");
        $response->assertStatus(200);
    }
    public function test_informacion_de_valoracion()
    {
        $id = $this->id_valoracion();
        $response = $this->get("valoracion/$id");
        $response->assertStatus(200);
    }
    public function valoracion()
    {
        return Valoracion::factory()->create();
    }
    public function id_valoracion()
    {
        return Valoracion::factory()->create()->id;
    }
}
