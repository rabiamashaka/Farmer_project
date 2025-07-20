<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Farmer;
use App\Models\ContentTemplate;
use App\Models\SmsLog;
use App\Models\Crop;
use App\Models\Weather;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class analytics extends Controller
{
    public function analytics()
    {
 app()->setLocale(session('locale', config('app.locale')));

        $totalFarmers = Farmer::count();
        $totalContent = ContentTemplate::count();
        $smsSent = SmsLog::count();
        $deliveryRate = SmsLog::where('status', 'Delivered')->count() / max(1, $smsSent) * 100;

       
$farmersByRegion = Farmer::select('region_id', DB::raw('count(*) as total'))
    ->groupBy('region_id')
    ->get();

        $contentDistribution = ContentTemplate::select('category', DB::raw('count(*) as total'))
            ->groupBy('category')->get();

        $popularCrops = Crop::select('name', DB::raw('count(crop_farmer.farmer_id) as total'))
            ->join('crop_farmer', 'crops.id', '=', 'crop_farmer.crop_id')
            ->groupBy('name')
            ->orderByDesc('total')
            ->get()
            ->map(fn ($item) => ['crop' => $item->name, 'total' => $item->total]);

        // 🌤 Monthly Weather Trends
        $weatherTrends = Weather::selectRaw("
                DATE_FORMAT(measured_at, '%Y-%m') as month,
                ROUND(AVG(temperature), 1) as avg_temp,
                ROUND(AVG(humidity), 1) as avg_humidity,
                ROUND(AVG(wind), 1) as avg_wind,
                ROUND(SUM(rain), 1) as total_rain
            ")
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        return view('analytics', compact(
            'totalFarmers',
            'totalContent',
            'smsSent',
            'deliveryRate',
            'farmersByRegion',
            'contentDistribution',
            'popularCrops',
            'weatherTrends'
        ));
    }
}
