<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        // Use the language saved in the session, or the default one from APP_LOCALE
        app()->setLocale(session('locale', config('app.locale')));

        return $next($request);
    }
}