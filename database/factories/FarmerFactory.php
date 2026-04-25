<?php

namespace Database\Factories;

use App\Models\Farmer;
use Illuminate\Database\Eloquent\Factories\Factory;

class FarmerFactory extends Factory
{
    protected $model = Farmer::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'name' => $this->faker->name,
            'phone' => '2557' . $this->faker->unique()->numerify('########'),
            'region_id' => 1, // adjust as needed
            'farming_type' => 'Crop',
        ];
    }
} 