<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class SetLocaleFromSessionOrCookie
{
    /**
     * Handle an incoming request and set application locale from session or cookie (decrypted).
     */
    public function handle(Request $request, Closure $next)
    {
        // Prefer session value if present
        $locale = session('locale');

        if (empty($locale)) {
            // Cookie facade will return decrypted cookie value when EncryptCookies middleware ran
            $locale = Cookie::get('locale');
        }

        $allowed = ['en', 'pl'];
        if ($locale && in_array($locale, $allowed)) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
