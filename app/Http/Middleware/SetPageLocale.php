<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class SetPageLocale
{
    private const string ENGLISH_ROUTE_PREFIX = 'en.';

    private const int LOCALE_COOKIE_MINUTES = 525600;

    /**
     * Sets the locale from the matched route. Pages that share one URL across languages fall back to the locale cookie.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $routeLocale = $request->route()?->defaults['locale'] ?? null;

        if (is_string($routeLocale)) {
            Cookie::queue('locale', $routeLocale, self::LOCALE_COOKIE_MINUTES, '/', null, null, false);
        }

        app()->setLocale($routeLocale ?? ($request->cookie('locale') === 'en' ? 'en' : 'nl'));

        return $next($request);
    }

    /**
     * URL of a page in the current locale, e.g. 'projects' resolves to /projects in English and /projecten in Dutch.
     *
     * @param  array<string, mixed>  $parameters
     */
    public static function url(string $name, array $parameters = []): string
    {
        return route(self::routeName($name), $parameters);
    }

    /**
     * Route name of a page in the current locale. Pages without an English variant keep their name.
     */
    public static function routeName(string $name): string
    {
        $englishName = self::ENGLISH_ROUTE_PREFIX.self::withoutEnglishPrefix($name);

        return app()->getLocale() === 'en' && Route::has($englishName) ? $englishName : self::withoutEnglishPrefix($name);
    }

    /**
     * URL of the current page in the given locale. Pages that share one URL across languages keep the current URL.
     */
    public static function alternateUrl(string $locale): string
    {
        $route = request()->route();

        if ($route === null || $route->getName() === null) {
            return request()->fullUrl();
        }

        $targetName = ($locale === 'en' ? self::ENGLISH_ROUTE_PREFIX : '').self::withoutEnglishPrefix($route->getName());

        if ($targetName === $route->getName() || ! Route::has($targetName)) {
            return request()->fullUrl();
        }

        return route($targetName, Arr::only($route->parameters(), $route->parameterNames()));
    }

    private static function withoutEnglishPrefix(string $name): string
    {
        return str_starts_with($name, self::ENGLISH_ROUTE_PREFIX) ? substr($name, strlen(self::ENGLISH_ROUTE_PREFIX)) : $name;
    }
}
