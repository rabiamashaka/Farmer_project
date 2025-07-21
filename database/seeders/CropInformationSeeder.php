<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Crop;
use App\Models\CropInformation;

class CropInformationSeeder extends Seeder
{
    public function run(): void
    {
        $maize = Crop::where('name', 'Maize')->first();
        $rice = Crop::where('name', 'Rice')->first();

        if ($maize) {
            CropInformation::create([
                'crop_id' => $maize->id,
                'type' => 'tip',
                'title' => 'Maize Planting Tip',
                'description' => 'Plant maize at the onset of rains for best results.',
            ]);
            CropInformation::create([
                'crop_id' => $maize->id,
                'type' => 'pest_control',
                'title' => 'Armyworm Control',
                'description' => 'Monitor for armyworm and use recommended pesticides early.',
            ]);
            CropInformation::create([
                'crop_id' => $maize->id,
                'type' => 'design',
                'title' => '2025 Planting Pattern',
                'description' => 'Try the new row spacing for higher yields.',
            ]);
        }
        if ($rice) {
            CropInformation::create([
                'crop_id' => $rice->id,
                'type' => 'tip',
                'title' => 'Rice Watering',
                'description' => 'Keep rice fields flooded during early growth.',
            ]);
            CropInformation::create([
                'crop_id' => $rice->id,
                'type' => 'pest_control',
                'title' => 'Rice Blast Prevention',
                'description' => 'Apply fungicide at the first sign of rice blast.',
            ]);
        }
    }
} 