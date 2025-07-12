<?php

namespace App\Events;

use App\Models\Region;
use App\Models\Weather as WeatherReading;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WeatherChanged implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    /**
     * @param  Region          $region   Mkoa husika
     * @param  array<string,mixed> $changes  Vipimo vilivyobadilika (↑/↓)
     * @param  WeatherReading  $reading  Rekodi mpya kamili ya hali ya hewa
     */
    public function __construct(
        public Region         $region,
        public array          $changes,
        public WeatherReading $reading
    ) {}

  
    public function broadcastOn(): Channel  
    {
       
        return new PrivateChannel('weather.' . $this->region->id);
    }

 
    public function broadcastAs(): string
    {
        return 'weather.changed';
    }


    public function broadcastWith(): array
    {
        return [
            'region'  => $this->region->only(['id', 'name']),
            'changes' => $this->changes,
            'reading' => [
                'temperature' => $this->reading->temperature,
                'humidity'    => $this->reading->humidity,
                'wind'        => $this->reading->wind,       
                'rain'        => $this->reading->rain,
                
                'measured_at' => $this->reading->measured_at->toIso8601String(),
            ],
        ];
    }
}
