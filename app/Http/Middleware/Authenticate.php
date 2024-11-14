<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Check if the user is authenticated using the default guard
        if (Auth::check()) {
            return $next($request); // Proceed to the next request if authenticated
        }

        // Redirect to the login page if not authenticated
        return redirect()->route('login');
    }
}
