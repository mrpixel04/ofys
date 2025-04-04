<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Convert both the user's role and the required role to uppercase for case-insensitive comparison
        $userRole = strtoupper(Auth::user()->role);
        $requiredRole = strtoupper($role);

        // Check if user has the required role (case-insensitive comparison)
        if ($userRole !== $requiredRole) {
            // Redirect based on user's actual role
            switch ($userRole) {
                case 'ADMIN':
                    return redirect()->route('admin.dashboard');
                case 'PROVIDER':
                    return redirect()->route('provider.dashboard');
                default:
                    return redirect('/');
            }
        }

        return $next($request);
    }
}
