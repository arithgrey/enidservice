<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Valoracion;

class ValoracionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Valoracion::class; 

    public function definition()
    {
        return [
            'user_id' => rand(1,10),        
            'slug' => $this->faker->slug,
            'comentario' => $this->faker->text(200),
            'calificacion' => rand(1,5),
            'recomendaria' => rand(0,1),
            'titulo' => $this->faker->sentence,
            'email' => $this->faker->unique()->safeEmail,
            'nombre' => $this->faker->name,
            'id_servicio' => rand(100, 1000),
            'status' => rand(0,1),
            'imagen' => $this->faker->imageUrl(1280, 720),


        ];
    }

}
