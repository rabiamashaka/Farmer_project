<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    /**
     * Handle an incoming request and set the application locale
     * based on the value stored in the session (defaulting to config app.locale).
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = session('locale', config('app.locale'));
        $allowed = config('app.available_locales', [config('app.locale')]);

        if (!in_array($locale, $allowed)) {
            $locale = config('app.locale');
        }

        App::setLocale($locale);

        return $next($request);
    }
}
