<?php

namespace App\Listeners;

use App\Events\WeatherChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class StoreWeatherNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(WeatherChanged $event): void
    {
        // Get current notifications from session or start a new array
        $notifications = session()->get('weather_notifications', []);

        // Append new notification data
        $notifications[] = [
            'region' => $event->region->name,
            'changes' => $event->changes,
            'measured_at' => $event->reading->measured_at->toDateTimeString(),
        ];

        // Save back to session
        session()->put('weather_notifications', $notifications);
    }
}
