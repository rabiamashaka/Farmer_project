<?php

namespace App\Http\Controllers;

use App\Models\Weather;
use App\Models\MarketPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class WeatherMarketController extends Controller
{
    /**
     * Onyesha dashibodi ya “Weather & Market Data”.
     *
     * ‑ Huleta REKODI YA KARIBUNI kwa kila region (weather)
     * ‑ Huleta bei tano (5) za mwisho sokoni (market)
     */
    public function index()   // badala ya “show” ili iendane na REST convent­ion
    {
        // ① Weather – latest per region
        $weatherReadings = Weather::with('region')
            ->latest('measured_at')
            ->get()
            ->groupBy('region_id')
            ->map(fn ($rows) => $rows->first())   // chukua ya karibuni tu
            ->values();

        // ② Market – rekodi 5 za mwisho
        $marketData = MarketPrice::with(['crop', 'region'])
            ->latest('updated_at')
            ->take(5)
            ->get();

        // ③ Peleka kwenda view (badilisha jina la view ukitumia jingine)
        return view('weather-market', compact('weatherReadings', 'marketData'));
    }

    /**
     * Trigger command ya `php artisan weather:fetch`
     * kutoka kwa kitufe cha \"🔄 Pata Hali‑ya‑Hewa Sasa\" kwenye Blade.
     */
    public function refresh(Request $request)
    {
        Artisan::call('weather:fetch');
        return response()->json(['ok' => true]);   // front‑end itajirefresh
    }
}
