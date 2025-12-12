<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class SecurityHeaders
{
    /**
     * Add security-focused headers to every response.
     */
    public function handle(Request $request, Closure $next)
    {
        // Per-request nonce for CSP; inline scripts can opt-in by adding nonce="{{ $cspNonce }}"
        $nonce = base64_encode(random_bytes(16));
        $request->attributes->set('csp_nonce', $nonce);
        View::share('cspNonce', $nonce);

        $response = $next($request);

        // Core protections
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
        $response->headers->set('X-Permitted-Cross-Domain-Policies', 'none');

        // HSTS only when request is secure (avoid breaking local HTTP)
        if ($request->isSecure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=63072000; includeSubDomains; preload');
        }

        // Content Security Policy (kept permissive enough for existing CDN use)
        $csp = [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' 'nonce-{$nonce}' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://unpkg.com https://code.jquery.com https://cdn.tailwindcss.com https://cdn.sheetjs.com",
            "style-src 'self' 'unsafe-inline' 'nonce-{$nonce}' https://cdnjs.cloudflare.com https://fonts.googleapis.com https://fonts.bunny.net https://cdn.jsdelivr.net https://unpkg.com",
            "img-src 'self' data: https:",
            "font-src 'self' https://fonts.gstatic.com https://fonts.bunny.net https://cdnjs.cloudflare.com https://cdn.jsdelivr.net",
            "connect-src 'self'",
            "frame-ancestors 'none'",
            "form-action 'self' https://www.billplz.com https://www.billplz-sandbox.com",
            "base-uri 'self'",
            "upgrade-insecure-requests",
        ];

        $response->headers->set('Content-Security-Policy', implode('; ', $csp));

        return $response;
    }
}
