<?php

namespace Database\Factories;

use App\Models\CicloFacturacion;
use App\Models\Clasificacion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServicioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $precio = $this->faker->randomFloat(2, 100, 2300);
        $menor = $this->faker->randomFloat(2, 100, 200);


        return [
            'nombre' => $this->faker->name(),
            'id_usuario' => User::factory(),
            'description' => $this->faker->sentence(),
            'id_clasificacion' => Clasificacion::factory(),
            'id_ciclo_facturacion' => CicloFacturacion::factory(),
            'precio' =>  $this->faker->randomFloat(1, 100, 2300),
            'costo' => ($precio - $menor),
            'url_vide_youtube' => $this->faker->url(),
            'url_video_facebook' => $this->faker->url(),
            'link_amazon' => $this->faker->url(),
            'link_ml' =>  $this->faker->url(),


        ];
    }
}
