<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;

class LocalizationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'localization:test {locale=en}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test localization system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $locale = $this->argument('locale');
        $allowedLocales = config('app.available_locales', ['en', 'sw']);
        
        if (!in_array($locale, $allowedLocales)) {
            $this->error("Locale '$locale' is not allowed. Available locales: " . implode(', ', $allowedLocales));
            return 1;
        }

        // Set locale
        App::setLocale($locale);
        
        $this->info("Testing localization for locale: $locale");
        $this->newLine();

        // Test translations
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
        ];

        $this->table(
            ['Key', 'Translation'],
            collect($testKeys)->map(function ($key) {
                return [$key, __($key)];
            })->toArray()
        );

        $this->newLine();
        $this->info("Current locale: " . App::getLocale());
        $this->info("Available locales: " . implode(', ', $allowedLocales));
        $this->info("Fallback locale: " . config('app.fallback_locale'));

        return 0;
    }
} 