<?php

namespace App\Providers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \App\User::observe(\App\Observers\UserObserver::class);

        $this->registerMacros();
    }

    private function registerMacros()
    {
        /**
         * Response Macros
         */
        Response::macro('hello', function () {
            return 'hello';
        });
        Response::macro('helloWorld', function ($name) {
            return $name . ' said: hello world!';
        });
        Response::macro('pdf', function () {
            return 'do something then generate the pdf';
        });
        Response::macro('payslip', function ($user_id) {
            return 'Generate Payslip for User ' . $user_id;
        });

        /**
         * Routes Macro
         */
        if (!Route::hasMacro('setting')) {
            Route::macro('setting', function ($module) {
                $url        = str_replace('.', '', Str::plural($module));
                $name       = 'settings.' . Str::singular($module);
                $controller = Str::studly(str_replace('.', ' ', $module)) . 'SettingController';
                Route::group([
                    'prefix'     => 'settings',
                    'namespace'  => 'Settings',
                    'middleware' => ['auth'],
                ], function () use ($url, $name, $controller) {
                    Route::get($url . '/show', $controller . '@show')->name($name . '.show');
                    Route::get($url . '/edit', $controller . '@edit')->name($name . '.edit');
                    Route::put($url . '/update', $controller . '@update')->name($name . '.update');
                    Route::delete($url . '/delete', $controller . '@destroy')->name($name . '.destroy');
                });
            });
        }

        /** Blueprint */
        Blueprint::macro('name', function () {
            return $this->string('name');
        });
        Blueprint::macro('uniqueEmail', function () {
            return $this->string('email')->unique();
        });
        Blueprint::macro('password', function () {
            return $this->string('password');
        });
        Blueprint::macro('emailVerifiedAt', function () {
            return $this->timestamp('email_verified_at')->nullable();
        });
        Blueprint::macro('employeeId', function () {
            return $this->string('employee_id')->unique();
        });
    }
}
