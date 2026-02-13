<?php

namespace App\Http\Middleware;

use Closure;
// PASTIKAN BARIS INI ADA
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
public function handle(Request $request, Closure $next)
{
    if (session()->has('locale')) {
        app()->setLocale(session('locale'));
    } else {
        app()->setLocale('en');
    }

    return $next($request);
}
}
