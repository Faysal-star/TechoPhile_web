<?php

namespace App\Http\Middleware;

use Closure;
use App\Facades\CustomAuth;
use Illuminate\Support\Facades\View;

class ShareAuthUser
{
    public function handle($request, Closure $next)
    {
        // dd(CustomAuth::user());
        View::share('authUser', CustomAuth::user());
        
        return $next($request);
    }
}
