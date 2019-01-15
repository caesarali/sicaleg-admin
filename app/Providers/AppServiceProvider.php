<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Blade;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('role', function ($rolename) {
            return Auth::user()->hasRole($rolename);
        });

        Blade::if('not', function ($rolename) {
            return !Auth::user()->hasRole($rolename);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
