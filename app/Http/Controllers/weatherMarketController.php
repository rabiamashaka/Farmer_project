<?php

namespace App\Http\Controllers;
use App\Models\Weather;
use App\Models\MarketPrice;
use Illuminate\Http\Request;

class weatherMarketController extends Controller
{  
    public function show()
{
    $weatherData = Weather::latest()->take(5)->get();
    $marketData = MarketPrice::latest()->take(5)->get();

    return view('weather-market', compact('weatherData', 'marketData'));
}

    

}
