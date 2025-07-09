<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Region;

class WeatherService
{
    public function fetchCurrent(Region $region): array
    {
        $response = Http::get(config('services.openweather.url'), [
            'lat'   => $region->lat,
            'lon'   => $region->lon,
            'appid' => config('services.openweather.key'),
            'units' => config('services.openweather.units'),
            'exclude' => 'minutely,hourly,daily,alerts',
        ])->throw();

        $data = $response->json()['current'];

        return [
            'temperature' => $data['temp'],
            'humidity'    => $data['humidity'],
            'wind'        => $data['wind_speed'],
            'rain'        => $data['rain']['1h'] ?? 0,
            'measured_at' => now(),
        ];
    }
}
