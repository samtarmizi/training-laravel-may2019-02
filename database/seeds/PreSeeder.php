<?php

use Illuminate\Database\Seeder;

class PreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
        	'name' => 'Superadmin',
        	'email' => 'super@app.com',
        	'password' => bcrypt('password'), 
        	'email_verified_at' => now(), 
        ]);
    }
}
