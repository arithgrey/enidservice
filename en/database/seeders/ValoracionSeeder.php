<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ValoracionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Valoracion::factory(10)->create();  
    }
}
