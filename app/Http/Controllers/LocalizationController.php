<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocalizationController extends Controller
{
    /**
     * Switch application locale
     */
    public function switchLocale($locale)
    {
        $allowedLocales = config('app.available_locales', ['en', 'sw']);
        
        if (in_array($locale, $allowedLocales)) {
            Session::put('locale', $locale);
            App::setLocale($locale);
        }
        
        return redirect()->back();
    }

    /**
     * Get current locale
     */
    public function getCurrentLocale()
    {
        return response()->json([
            'current_locale' => App::getLocale(),
            'session_locale' => Session::get('locale'),
            'available_locales' => config('app.available_locales'),
            'fallback_locale' => config('app.fallback_locale'),
        ]);
    }

    /**
     * Test translations
     */
    public function testTranslations()
    {
        $testKeys = [
            'Dashboard',
            'Welcome',
            'Login',
            'Register',
            'Profile',
            'Settings',
            'Save',
            'Cancel',
            'Edit',
            'Delete',
            'Search',
            'Loading...',
            'Success',
            'Error',
            'Warning',
            'Info',
            'Yes',
            'No',
            'Active',
            'Inactive',
            'Pending',
            'Completed',
            'Failed',
            'Today',
            'Yesterday',
            'This Week',
            'This Month',
            'Last Month',
            'This Year',
            'Last Year',
            'Date',
            'Time',
            'From',
            'To',
            'All',
            'None',
            'Total',
            'Count',
            'Average',
            'Maximum',
            'Minimum',
            'Page',
            'of',
            'Showing',
            'entries',
            'No records found',
            'No data available',
            'No results found',
            'Something went wrong',
            'Please try again',
            'An error occurred',
            'Go back to home',
            'Contact support',
            'Help',
            'Documentation',
            'About',
            'Language',
            'Theme',
            'Light',
            'Dark',
            'System',
            'Notifications',
            'Mark all as read',
            'No notifications',
        ];

        $translations = [];
        foreach ($testKeys as $key) {
            $translations[$key] = __($key);
        }

        return response()->json([
            'locale' => App::getLocale(),
            'session_locale' => Session::get('locale'),
            'translations' => $translations,
            'timestamp' => now()->toISOString(),
        ]);
    }

    /**
     * Show localization test page
     */
    public function showTestPage()
    {
        return view('localization.test');
    }
} 