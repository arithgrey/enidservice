<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        User::factory()->count(10)->create();
        User::create([
            'name' => 'Jonathan',
            'email' => 'arithgrey@gmail.com',
            'password' => bcrypt('123456789'),
        ]);

    }
}
