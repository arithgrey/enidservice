<?php

namespace Database\Seeders;

use App\Models\SolicitudRetiro;
use Illuminate\Database\Seeder;

class SolicitudRetiroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SolicitudRetiro::factory()->count(100)->create();
    }
}
