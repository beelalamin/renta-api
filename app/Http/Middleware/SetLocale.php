<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->header('X-Locale', Config::get('app.locale')); // Default to 'app.locale' if header is not present

        // Check if the locale is in the list of available locales
        if (!in_array($locale, Config::get('app.available_locales'))) {
            $locale = Config::get('app.fallback_locale'); // Use fallback locale if invalid
        }

        App::setLocale($locale);

        return $next($request);
    }
}
