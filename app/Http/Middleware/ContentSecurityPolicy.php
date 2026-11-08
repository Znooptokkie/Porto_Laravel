<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Vite;
use Symfony\Component\HttpFoundation\Response;

class ContentSecurityPolicy
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $nonce = Vite::cspNonce();

        $response->headers->set(
            'Content-Security-Policy',
            "default-src 'self'; ".
            "script-src 'self' 'nonce-{$nonce}'; ".
            "style-src 'self' 'nonce-{$nonce}'; ".
	    "style-src-attr 'unsafe-inline'; ".
            "font-src 'self'; ".
            "img-src 'self' data:; ".
            "connect-src 'self'; ".
            "object-src 'none'; ".
            "base-uri 'self'; ".
            "frame-ancestors 'none'; ".
            "form-action 'self'; ".
            "upgrade-insecure-requests"
        );

        return $response;
    }
}
