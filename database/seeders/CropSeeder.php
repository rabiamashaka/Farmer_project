<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Crop;
use Illuminate\Support\Str;

class CropSeeder extends Seeder
{
    public function run(): void
    {
        $crops = [
            'mahindi',
            'mchele',
            'mtama',
            'uwele',
            'ulezi',
            'mihogo',
            'viazi vitamu',
            'viazi mviringo',
            'maharage',
            'kunde',
            'mbaazi',
            'soya',

            'kahawa',
            'chai',
            'pamba',
            'tumbaku',
            'korosho',
            'mkonge',
            'miwa',
            'alizeti',
            'ufuta',

            'nyanya',
            'kitunguu',
            'kabichi',
            'karoti',
            'spinachi',
            'bamia',
            'pilipili',
            'matango',
            'tikiti maji',

            'ndizi',
            'ndizi za kupika',
            'embe',
            'nanasi',
            'machungwa',
            'parachichi',
            'papai',
            'passion',
            'fenesi',
            'pera',

            'karanga',
            'nazi',
            'karafuu',
            'iliki',
        ];

        foreach ($crops as $name) {
            Crop::firstOrCreate([
                'name' => Str::lower(trim($name)),
            ]);
        }
    }
}
