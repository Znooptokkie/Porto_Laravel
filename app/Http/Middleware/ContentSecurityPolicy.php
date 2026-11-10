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
        $isViteDevServer = Vite::isRunningHot();

        $response->headers->set(
            'Content-Security-Policy',
            "default-src 'self'; ".
            "script-src 'self' 'nonce-{$nonce}'{$this->devServerSource($isViteDevServer, 'http:')}; ".
            "style-src 'self' 'nonce-{$nonce}'{$this->devServerSource($isViteDevServer, 'http:')}; ".
            "style-src-attr 'unsafe-inline'; ".
            "font-src 'self'{$this->devServerSource($isViteDevServer, 'http:')}; ".
            "img-src 'self' data:; ".
            "connect-src 'self'{$this->devServerSource($isViteDevServer, 'http: ws:')}; ".
            "object-src 'none'; ".
            "base-uri 'self'; ".
            "frame-ancestors 'none'; ".
            "form-action 'self'; ".
            'upgrade-insecure-requests'
        );

        return $response;
    }

    /**
     * Alleen tijdens `npm run dev` (Vite hot file aanwezig): de dev-server draait op een IPv6-adres
     * (`[::1]`), dat niet als CSP-host-source uitgedrukt kan worden, dus wordt het scheme toegestaan.
     */
    private function devServerSource(bool $isViteDevServer, string $sources): string
    {
        return $isViteDevServer ? ' '.$sources : '';
    }
}
