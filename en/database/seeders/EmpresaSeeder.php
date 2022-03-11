<?php

namespace Database\Seeders;

use App\Models\Empresa;
use Illuminate\Database\Seeder;

class EmpresaSeeder extends Seeder
{

    public function run()
    {
        Empresa::create([
            'id' => 1,
            'nombre' => 'Enid Service',
        ]);
    }
}
