<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->screenshot('001-landing-page')
                    ->assertSee('Hi Laravel')
                    ->visit('/login')
                    ->screenshot('002-login')
                    ->assertSee('Login')
                    ->visit('/register')
                    ->screenshot('003-register')
                    ->assertSee('Register')
                    ->type('name', 'Nasrul Hazim')
                    ->type('email', 'nasrul@app.com')
                    ->type('password', 'password')
                    ->type('password_confirmation', 'password')
                    ->screenshot('003-register-filled')
                    ->press('Register')
                    ->assertPathIs('/home')
                    ->screenshot('004-success-logged-in')
                    ->pause(2000);
        });
    }
}
