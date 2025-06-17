<?php

namespace Database\Factories;

namespace Database\Factories;

use App\Models\MarketPrice;
use Illuminate\Database\Eloquent\Factories\Factory;

class MarketPriceFactory extends Factory
{
    protected $model = MarketPrice::class;

    public function definition()
    {
        return [
            'crop' => $this->faker->randomElement(['Maize', 'Rice', 'Beans', 'Sorghum', 'Cassava']),
            'location' => $this->faker->city,
            'price_per_kg' => $this->faker->randomFloat(2, 500, 1500),
            'currency' => 'TZS',
            'market_date' => $this->faker->date(),
            'source' => 'Ministry of Agriculture',
        ];
    }
}
