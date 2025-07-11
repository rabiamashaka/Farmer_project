<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Region;
use App\Models\Weather;
use App\Events\WeatherChanged;
use Carbon\Carbon;

class FetchWeather extends Command
{
    protected $signature = 'weather:fetch';
    protected $description = 'Fetch current weather data for each region and store it in the database';

    public function handle(): int
    {
        $url   = config('services.openweather.url');
        $key   = config('services.openweather.key');
        $units = config('services.openweather.units', 'metric');

        if (blank($key)) {
            $this->error('OPENWEATHER_KEY haijawekwa kwenye .env');
            return self::FAILURE;
        }

        Region::cursor()->each(function (Region $region) use ($url, $key, $units) {
            $response = Http::retry(3, 2000)->get($url, [
                'lat'   => $region->lat,
                'lon'   => $region->lon,
                'appid' => $key,
                'units' => $units,
            ]);

            if ($response->failed()) {
                $this->warn("❌  {$region->name}: HTTP ".$response->status());
                Log::warning('OpenWeather request failed', [
                    'region' => $region->name,
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
                return;
            }

            $w = $response->json();

            $rain = data_get($w, 'rain.1h') ?? data_get($w, 'rain.3h') ?? 0.0;
            $condition = data_get($w, 'weather.0.description');
            $measuredAt = isset($w['dt']) ? Carbon::createFromTimestamp($w['dt']) : now();

            $new = Weather::create([
                'region_id'   => $region->id,
                'temperature' => data_get($w, 'main.temp'),
                'humidity'    => data_get($w, 'main.humidity'),
                'wind'        => data_get($w, 'wind.speed'),
                'rain'        => $rain,
                'condition'   => $condition,
                'source'      => 'OpenWeather',
                'measured_at' => $measuredAt,
            ]);

            $this->info("✅  Weather saved for {$region->name}");

            // Toa tofauti na rekodi ya awali (excluding this one)
            $prev = Weather::where('region_id', $region->id)
                           ->where('id', '!=', $new->id)
                           ->latest('measured_at')
                           ->first();

            if ($prev) {
                $changes = $this->diff($prev, $new);
                if (!empty($changes)) {
                    Log::info("📢 Changes detected in {$region->name}", $changes);
                    WeatherChanged::dispatch($region, $changes, $new);
                }
            }
        });

        return self::SUCCESS;
    }

    /** Linganisha field za rekodi mbili na toa tofauti */
    protected function diff(Weather $old, Weather $new): array
    {
        $fields = ['temperature', 'humidity', 'wind', 'rain', 'condition'];
        $out    = [];

        foreach ($fields as $field) {
            if (is_null($old->$field) || is_null($new->$field)) {
                continue;
            }

            if ($field === 'condition') {
                if ($old->condition !== $new->condition) {
                    $out[$field] = "{$old->condition} → {$new->condition}";
                }
                continue;
            }

            $delta = round($new->$field - $old->$field, 1);
            if ($delta != 0.0) {
                $sign = $delta > 0 ? '+' : '';
                $out[$field] = "{$sign}{$delta} ({$old->$field} → {$new->$field})";
            }
        }

        return $out;
    }
}
