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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('numeric_array', function($attribute, $values, $parameters)
        {
            if(! is_array($values)) {
                return false;
            }

            foreach($values as $v) {
                if(! is_numeric($v)) {
                    return false;
                }
            }

            return true;
        });
    }
}
