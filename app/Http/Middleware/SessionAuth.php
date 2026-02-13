<?php

namespace App\Http\Middleware;

use Closure;

class SessionAuth
{
    public function handle($request, Closure $next)
    {
        if (!$request->session()->has('user')) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        return $next($request);
    }
}
