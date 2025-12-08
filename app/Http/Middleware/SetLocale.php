<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
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
    public function handle(Request $request, Closure $next): Response
    {
        // Priority: Session > Cookie > Default
        $locale = Session::get('locale');

        if (!$locale) {
            $locale = $request->cookie('locale');
        }

        if (!$locale || !in_array($locale, ['en', 'ms'])) {
            $locale = config('app.locale', 'en');
        }

        // Set the application locale
        App::setLocale($locale);

        // Also store in session if it came from cookie
        if (!Session::has('locale') && $request->cookie('locale')) {
            Session::put('locale', $locale);
        }

        return $next($request);
    }
}
