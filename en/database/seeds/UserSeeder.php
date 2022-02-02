<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        App\Models\User::create([
            'name' => 'Jonathan',
            'email' => 'arithgrey@gmail.com',
            'password' => bcrypt('123456789'),        
        ]);
        
    }
}
