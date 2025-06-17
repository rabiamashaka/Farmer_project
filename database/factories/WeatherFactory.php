<?php


namespace Database\Factories;

use App\Models\Weather;
use Illuminate\Database\Eloquent\Factories\Factory;

class WeatherFactory extends Factory
{
    protected $model = Weather::class;

    public function definition(): array
    {
        return [
            'location' => $this->faker->city,
            'temperature' => $this->faker->numberBetween(20, 38),
            'humidity' => $this->faker->numberBetween(30, 90),
            'rainfall' => $this->faker->randomFloat(1, 0, 10),
            'condition' => $this->faker->randomElement(['Sunny', 'Rainy', 'Cloudy', 'Windy']),
            'date' => $this->faker->date(),
            'source' => $this->faker->randomElement(['TMA', 'NOAA', 'AccuWeather']),
        ];
    }
}

