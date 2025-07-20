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
        // Get locale from session, fallback to config
        $locale = session('locale', config('app.locale'));

        // Validate locale is allowed
        $allowed = config('app.available_locales', ['en', 'sw']);
        if (!in_array($locale, $allowed)) {
            $locale = config('app.locale');
        }

        // Set the application locale
        App::setLocale($locale);

        // Optional: Debug log (you can comment these in production)
        \Log::info("SetLocale middleware: Session locale = " . session('locale'));
        \Log::info("SetLocale middleware: App locale set to = " . App::getLocale());

        return $next($request);
    }
}
