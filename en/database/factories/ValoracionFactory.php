<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Valoracion;
use Faker\Generator as Faker;

$factory->define(Valoracion::class, function (Faker $faker) {
    return [
            'user_id' => rand(1,10),        
            'slug' => $faker->slug,
            'comentario' => $faker->text(200),
            'calificacion' => rand(1,5),
            'recomendaria' => rand(0,1),
            'titulo' => $faker->sentence,
            'email' => $faker->unique()->safeEmail,
            'nombre' => $faker->name,
            'id_servicio' => rand(100, 1000),
            'status' => rand(0,1) 

    ];
});
