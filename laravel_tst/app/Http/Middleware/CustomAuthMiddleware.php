<?php

namespace App\Http\Middleware;

use Closure;
use App\Facades\CustomAuth;
use Illuminate\Support\Facades\Log;

class CustomAuthMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!CustomAuth::check()) {
            // dd(CustomAuth::check());
            return redirect()->route('login');
        }

        // dd(CustomAuth::user());
        return $next($request);
    }
}
