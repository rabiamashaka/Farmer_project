<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Models\Weather;              // ← ongeza
use App\Observers\WeatherObserver;   // ← ongeza

class EventServiceProvider extends ServiceProvider
{
    /**
     * Mappings za event-listener (unaweza kuziacha tupu kama huna).
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        // Example:
        // Registered::class => [SendEmailVerificationNotification::class],
    ];

    /**
     * Model observers za application.
     *
     * @var array<class-string, class-string>
     */
    protected $observers = [
        Weather::class => WeatherObserver::class,
    ];
}

