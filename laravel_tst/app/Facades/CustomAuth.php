<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class CustomAuth extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'custom.auth';
    }
}