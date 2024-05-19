<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\CustomAuth;

class CustomAuthServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('custom.auth', function ($app) {
            return new CustomAuth();
        });
    }
}