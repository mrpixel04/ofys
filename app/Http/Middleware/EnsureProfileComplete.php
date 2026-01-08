<?php

namespace App\Http\Middleware;

use App\Support\ProfileCompletion;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return $next($request);
        }

        if (!ProfileCompletion::isIncomplete($user)) {
            return $next($request);
        }

        if ($this->routeIsGloballyExempt($request) ||
            in_array($request->route()?->getName(), ProfileCompletion::allowedRoutes($user), true)) {
            return $next($request);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Please complete your profile before accessing this page.',
            ], 409);
        }

        return redirect()->route(ProfileCompletion::routeFor($user))
            ->with('warning', 'Sila lengkapkan profil anda sebelum meneruskan.');
    }

    /**
     * Routes that should remain accessible regardless of profile status.
     */
    protected function routeIsGloballyExempt(Request $request): bool
    {
        $routeName = $request->route()?->getName();

        if (!$routeName) {
            return false;
        }

        $exemptRoutes = [
            'logout',
            'verification.notice',
            'verification.send',
            'verification.verify',
            'password.request',
            'password.email',
            'password.reset',
            'password.update',
            'auth.google.redirect',
            'auth.google.callback',
            'language.switch',
        ];

        return in_array($routeName, $exemptRoutes, true);
    }
}
