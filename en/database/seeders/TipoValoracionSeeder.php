<?php

namespace Database\Seeders;

use App\Models\TipoValoracion;
use Illuminate\Database\Seeder;

class TipoValoracionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        TipoValoracion::create([
            'id' => 1,
            'nombre' => 'Valoración sobre las caracteristicas del artículo',
            'status' => 1,
        ]);

        TipoValoracion::create([
            'id' => 2,
            'nombre' => 'Valoración sobre el servicio',
            'status' => 1,
        ]);

    }
}
