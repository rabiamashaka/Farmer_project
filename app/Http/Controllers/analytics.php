<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use App\Models\Farmer;
use App\Models\ContentTemplate;
use App\Models\SmsLog;
use App\Models\Crop; 
use Illuminate\Support\Facades\DB;


class analytics extends Controller
{
   public function analytics()
    { 
        $totalFarmers = Farmer::count();
        $totalContent = ContentTemplate::count();
        $smsSent = SmsLog::count();
        $deliveryRate = SmsLog::where('status', 'Delivered')->count() / max(1, $smsSent) * 100;

      
        $farmersByRegion = Farmer::select('location as region', DB::raw('count(*) as total'))
            ->groupBy('location')
            ->get();

        
        $contentDistribution = ContentTemplate::select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->get();

        
        $popularCrops = Crop::select('name', DB::raw('count(crop_farmer.farmer_id) as total'))
            ->join('crop_farmer', 'crops.id', '=', 'crop_farmer.crop_id')
            ->groupBy('name')
            ->orderByDesc('total')
            ->get()
            ->map(function ($item) {
                return ['crop' => $item->name, 'total' => $item->total];
            });

        return view('analytics', compact(
            'totalFarmers',
            'totalContent',
            'smsSent',
            'deliveryRate',
            'farmersByRegion',
            'contentDistribution',
            'popularCrops'
        ));
    }
}