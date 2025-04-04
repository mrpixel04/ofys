<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
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
        // Set locale based on session, defaulting to English if not set
        $locale = session('locale', 'en');

        // Ensure locale is one of the supported languages
        if (!in_array($locale, ['en', 'ms'])) {
            $locale = 'en';
        }

        // Set the application locale
        App::setLocale($locale);

        return $next($request);
    }
}
