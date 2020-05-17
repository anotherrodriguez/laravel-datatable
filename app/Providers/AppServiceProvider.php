<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

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
        //
        Validator::extend('phone_number', function($attribute, $value, $parameters)
        {
            $preg_quote = preg_quote('\D?(\d{3})\D?\D?(\d{3})\D?(\d{4})', '/');
            return preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $value);
        });
    }
}
