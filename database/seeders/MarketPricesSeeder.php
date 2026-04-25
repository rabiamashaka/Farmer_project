<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Crop;
use App\Models\Region;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MarketPricesSeeder extends Seeder
{
    public function run()
    {
        $marketDate = Carbon::create(2025, 6, 20);
        $now = now();

        $rawData = [
            ['crop' => 'Mahindi', 'location' => 'Dodoma', 'price_per_kg' => 1100],
            ['crop' => 'Mchele', 'location' => 'Morogoro', 'price_per_kg' => 2400],
            ['crop' => 'Maharage', 'location' => 'Mbeya', 'price_per_kg' => 2800],
            ['crop' => 'Mtama', 'location' => 'Singida', 'price_per_kg' => 1300],
            ['crop' => 'Uwele', 'location' => 'Shinyanga', 'price_per_kg' => 1500],
            ['crop' => 'Ulezi', 'location' => 'Tabora', 'price_per_kg' => 1200],
            ['crop' => 'Viazi Mviringo', 'location' => 'Mbeya', 'price_per_kg' => 700],
            ['crop' => 'Korosho ya Juu', 'location' => 'Mtwara', 'price_per_kg' => 3760],
            ['crop' => 'Korosho ya Chini', 'location' => 'Mtwara', 'price_per_kg' => 3540],
        ];

        $dataToInsert = [];

        foreach ($rawData as $item) {
            $crop = Crop::where('name', $item['crop'])->first();
            $region = Region::where('name', $item['location'])->first();

            if (!$crop || !$region) {
                continue; // skip if either not found
            }

            $dataToInsert[] = [
                'crop_id' => $crop->id,
                'region_id' => $region->id,
                'price_per_kg' => $item['price_per_kg'],
                'currency' => 'TSh',
                'market_date' => $marketDate,
                'source' => 'Kilimo.go.tz PDF June 2025',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('market_prices')->insert($dataToInsert);
    }
}
