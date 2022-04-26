<?php

namespace Database\Seeders;

use App\Models\Empresa;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(FormaPagoSeeder::class);
        $this->call(EmpresaSeeder::class);
        $this->call(TipoValoracionSeeder::class);
        $this->call(ValoracionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(SolicitudRetiroSeeder::class);
    }
}
