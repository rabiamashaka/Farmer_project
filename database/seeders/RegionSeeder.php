<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Region;

class RegionSeeder extends Seeder
{
    public function run()
    {
        $regions = [
            ['name' => 'Arusha',           'lat' => -3.3869,  'lon' => 36.6822],
            ['name' => 'Dar es Salaam',    'lat' => -6.7924,  'lon' => 39.2083],
            ['name' => 'Dodoma',           'lat' => -6.1700,  'lon' => 35.7410],
            ['name' => 'Geita',            'lat' => -2.8736,  'lon' => 32.1594],
            ['name' => 'Iringa',           'lat' => -7.7720,  'lon' => 35.6904],
            ['name' => 'Kagera',           'lat' => -1.0476,  'lon' => 31.7956],
            ['name' => 'Katavi',           'lat' => -6.8000,  'lon' => 31.7667],
            ['name' => 'Kigoma',           'lat' => -4.8766,  'lon' => 29.6260],
            ['name' => 'Kinondoni',        'lat' => -6.7500,  'lon' => 39.2333],
            ['name' => 'Kilimanjaro',      'lat' => -3.3333,  'lon' => 37.3500],
            ['name' => 'Lindi',            'lat' => -10.0000, 'lon' => 39.7000],
            ['name' => 'Manyara',          'lat' => -4.5000,  'lon' => 35.7500],
            ['name' => 'Mara',             'lat' => -1.0000,  'lon' => 34.9000],
            ['name' => 'Mbeya',            'lat' => -8.9100,  'lon' => 33.4500],
            ['name' => 'Morogoro',         'lat' => -6.8200,  'lon' => 37.6600],
            ['name' => 'Mtwara',           'lat' => -10.2700, 'lon' => 40.1800],
            ['name' => 'Mwanza',           'lat' => -2.5167,  'lon' => 32.9000],
            ['name' => 'Njombe',           'lat' => -9.3333,  'lon' => 34.8000],
            ['name' => 'Pemba North',      'lat' => -5.2167,  'lon' => 39.7500],
            ['name' => 'Pemba South',      'lat' => -5.3000,  'lon' => 39.7000],
            ['name' => 'Pwani',            'lat' => -7.0000,  'lon' => 38.8000],
            ['name' => 'Rukwa',            'lat' => -7.8000,  'lon' => 31.8000],
            ['name' => 'Ruvuma',           'lat' => -10.6000, 'lon' => 35.7333],
            ['name' => 'Shinyanga',        'lat' => -3.6667,  'lon' => 33.4333],
            ['name' => 'Simiyu',           'lat' => -2.5000,  'lon' => 33.9167],
            ['name' => 'Singida',          'lat' => -4.8167,  'lon' => 34.7500],
            ['name' => 'Tabora',           'lat' => -5.0167,  'lon' => 32.8000],
            ['name' => 'Tanga',            'lat' => -5.0667,  'lon' => 39.1000],
            ['name' => 'Zanzibar North',   'lat' => -5.7500,  'lon' => 39.3000],
            ['name' => 'Zanzibar South',   'lat' => -6.2500,  'lon' => 39.2833],
            ['name' => 'Zanzibar Urban',   'lat' => -6.1600,  'lon' => 39.2000],
        ];

        Region::insert($regions);
    }
}
