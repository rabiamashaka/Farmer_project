<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocalizationMiddleware
{
    /**
     * Handle an incoming request and set the application locale
     * based on the value stored in the session.
     */
    public function handle(Request $request, Closure $next)
    {
        // Get locale from session, fallback to config
        $locale = Session::get('locale', config('app.locale'));
        
        // Validate locale is allowed
        $allowedLocales = config('app.available_locales', ['en', 'sw']);
        if (!in_array($locale, $allowedLocales)) {
            $locale = config('app.locale');
        }

        // Set the application locale
        App::setLocale($locale);
        
        // Also set the Carbon locale for date formatting
        if (class_exists('Carbon\Carbon')) {
            \Carbon\Carbon::setLocale($locale);
        }

        return $next($request);
    }
} 