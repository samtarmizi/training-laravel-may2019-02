<?php

use Illuminate\Database\Seeder;

class DevelopmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if('production' == app()->environment()) {
        	return;
        }
        factory(\App\User::class, 100)->create();
    }
}
