<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
    public function it_has_development_seeder()
    {
    	$this->assertTrue(class_exists('DevelopmentSeeder'));
    }

    /** @test */
    public function it_has_seed_dev_command()
    {
    	$this->assertTrue(
    		array_has(\Artisan::all(), 'seed:dev')
    	);
    }

    /** @test */
    public function it_can_seed_dev_data()
    {
    	$this->artisan('seed:dev')
    		->expectsOutput('Database seeding completed successfully.')
    		->assertExitCode(0);

    	$this->assertTrue(\App\User::count() > 0);
    	$this->assertTrue(\App\User::count() == 100);
    }

    /** @test */
    public function it_has_pre_seeder()
    {
    	$this->assertTrue(class_exists('PreSeeder'));
    }

    /** @test */
    public function it_has_seed_pre_command()
    {
    	$this->assertTrue(
    		array_has(\Artisan::all(), 'seed:pre')
    	);
    }

    /** @test */
    public function it_can_seed_pre_data()
    {
    	$this->artisan('seed:pre')
    		->expectsOutput('Database seeding completed successfully.')
    		->assertExitCode(0);

    	$this->assertTrue(\App\User::count() > 0);
    	$this->assertTrue(\App\User::count() == 1);
    	$this->assertDatabaseHas('users', [
	        'name' => 'Superadmin',
        	'email' => 'super@app.com',
	    ]);
    }

    /** @test */
    public function it_has_hello_world_helper()
    {
    	$this->assertTrue(function_exists('helloWorld'));
    }
}
