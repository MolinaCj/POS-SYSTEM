<?php

namespace App\Http\Middleware;

use Closure;

class AuthenticateUser
{
    public function handle($request, Closure $next)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('loginForm')->with('error', 'You must log in first.');
        }
        
        return $next($request);
    }
}
