<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Valoracion;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        User::factory()->count(10)->create();
        Valoracion::factory()->count(50)->create();

        User::create([
            'name' => 'Jonathan',
            'email' => 'arithgrey@gmail.com',
            'password' => bcrypt('123456789'),
        ]);

    }
}
