<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Switch the application language.
     *
     * @param string $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switch($locale)
    {
        // Validate locale
        if (!in_array($locale, ['en', 'ms'])) {
            $locale = 'en';
        }

        // Store in session
        Session::put('locale', $locale);

        // Set application locale immediately
        App::setLocale($locale);

        // Redirect back with no-cache headers
        return redirect()->back()->withCookie(cookie('locale', $locale, 60 * 24 * 365));
    }
}
