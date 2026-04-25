<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Crop;
use App\Models\CropInformation;

class CropInformationSeeder extends Seeder
{
    public function run(): void
    {
        // Tafuta mazao husika kwa jina la Kiswahili
        $mahindi = Crop::where('name', 'mahindi')->first();
        $mchele = Crop::where('name', 'mchele')->first();

        if ($mahindi) {
            CropInformation::create([
                'crop_id' => $mahindi->id,
                'type' => 'tip',
                'title' => 'Ushauri wa Kupanda Mahindi',
                'description' => 'Panda mahindi mwanzoni mwa msimu wa mvua kwa matokeo bora.',
            ]);
            CropInformation::create([
                'crop_id' => $mahindi->id,
                'type' => 'pest_control',
                'title' => 'Udhibiti wa Funza wa Jeshi',
                'description' => 'Fuatilia mashamba kwa funza na tumia dawa mapema.',
            ]);
            CropInformation::create([
                'crop_id' => $mahindi->id,
                'type' => 'design',
                'title' => 'Mpangilio wa Kupanda 2025',
                'description' => 'Tumia nafasi mpya ya mistari ili kuongeza mavuno.',
            ]);
        }

        if ($mchele) {
            CropInformation::create([
                'crop_id' => $mchele->id,
                'type' => 'tip',
                'title' => 'Umwagiliaji wa Mchele',
                'description' => 'Hakikisha shamba la mchele lina maji ya kutosha wakati wa ukuaji wa awali.',
            ]);
            CropInformation::create([
                'crop_id' => $mchele->id,
                'type' => 'pest_control',
                'title' => 'Kinga dhidi ya Ukungu wa Mchele',
                'description' => 'Tumia dawa ya kuua kuvu mara tu unapogundua dalili za ukungu.',
            ]);
        }
    }
}
