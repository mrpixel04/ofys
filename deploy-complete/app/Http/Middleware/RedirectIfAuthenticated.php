<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Get authenticated user
                $user = Auth::guard($guard)->user();
                $userRole = strtoupper($user->role);

                // Redirect based on user role (using uppercase comparison)
                if ($userRole === 'ADMIN') {
                    return redirect()->route('admin.dashboard');
                } elseif ($userRole === 'PROVIDER') {
                    return redirect()->route('provider.dashboard');
                } else {
                    // Default redirect for customers and other roles
                    return redirect()->route('customer.dashboard');
                }
            }
        }

        return $next($request);
    }
}
