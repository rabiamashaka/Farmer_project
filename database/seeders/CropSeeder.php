<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Crop;

class CropSeeder extends Seeder
{
    public function run(): void
    {
        $crops = [
            // Mazao ya chakula
            'maize', 'rice', 'sorghum', 'millet', 'cassava',
            'sweet potato', 'irish potato', 'beans', 'cowpea',
            'pigeon pea', 'soya bean',

            // Mazao ya biashara/mwili
            'coffee', 'tea', 'cotton', 'tobacco', 'cashew nut',
            'sisal', 'sugarcane', 'sunflower', 'sesame',

            // Mazao ya mboga
            'tomato', 'onion', 'cabbage', 'carrot', 'spinach',
            'okra', 'pepper', 'cucumber', 'watermelon',

            // Mazao ya matunda
            'banana', 'plantain', 'mango', 'pineapple',
            'citrus', 'avocado', 'papaya', 'passion fruit',
            'jackfruit', 'guava',

            // Mafuta na viungo
            'groundnut', 'coconut', 'clove', 'cardamom',
        ];

        foreach ($crops as $crop) {
            Crop::firstOrCreate(['name' => $crop]);
        }
    }
}
