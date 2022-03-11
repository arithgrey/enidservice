<?php

namespace Database\Seeders;

use App\Models\TipoComisionista;
use Illuminate\Database\Seeder;

class TipoComisionistaSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoComisionista::create([
            'nombre' => 'Inovador',
        ]);
        TipoComisionista::create([
            'nombre' => 'Competitivo',
        ]);

    }
}
