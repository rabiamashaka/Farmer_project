<?php

namespace App\Http\Controllers;

use App\Models\SmsCampaign;
use App\Models\ContentTemplate;
use App\Models\Farmer;
use Illuminate\Http\Request;
use App\Services\AfricasTalkingService;
use App\Jobs\SendSmsJob;
use App\Models\Crop;
 use Stichoza\GoogleTranslate\GoogleTranslate;


class SmsCampaignsController extends Controller
{
    /*------------------------------------------------------------------
    | LIST CAMPAIGNS + TEMPLATE DATA
    *-----------------------------------------------------------------*/
    public function index()
    {
        $campaigns = SmsCampaign::latest()->get();

        // Pre‑filled templates, regions & crops kwa modal
        $templates = ContentTemplate::where('status', 'published')->get();
        $regions   = Farmer::distinct('location')->pluck('location');
        $crops     = Crop::pluck('name');

        return view('sms_campaigns.index', compact(
            'campaigns', 'templates', 'regions', 'crops'
        ));
    }

 

public function store(Request $request, AfricasTalkingService $sms)
{
    $data = $request->validate([
        'title'     => 'required|string|max:255',
        'message'   => 'required|string|max:160',
        'locations' => 'array|nullable',
        'locations.*'=> 'string',
        'crops'     => 'array|nullable',
        'crops.*'   => 'string',
        'language'  => 'required|string|in:sw,en',
    ]);

    // 1️⃣ Translate message once before sending
    $translatedMessage = $data['language'] === 'sw'
        ? GoogleTranslate::trans($data['message'], 'sw')
        : $data['message'];

    $campaign = SmsCampaign::create([
    'title'     => $data['title'],
    'message'   => $translatedMessage,
    'locations' => $data['locations'] ?? null, 
    'crops'     => $data['crops'] ?? null,     
    'language'  => $data['language'],
    'status'    => 'queued',
]);


    $farmerQuery = Farmer::query();

    if (!empty($data['locations'])) {
        $farmerQuery->whereIn('location', $data['locations']);
    }

    if (!empty($data['crops'])) {
        $farmerQuery->whereHas('crops', function ($q) use ($data) {
            $q->whereIn('name', $data['crops']);
        });
    }

    
   $sentCount = 0;
$farmerQuery->chunkById(200, function ($farmers) use (&$sentCount, $campaign) {
    foreach ($farmers as $farmer) {
        SendSmsJob::dispatch($farmer->phone, $campaign->message, $campaign->id);
        $sentCount++;
    }
});


    
    $campaign->update([
        'status'   => 'sent',
        'sent_to'  => $sentCount,
    ]);

    return back()->with('success', "Campaign created and queued for {$sentCount} farmers!");
}


  
    public function sendQuickSms(Request $request, AfricasTalkingService $sms)
    {
        $request->validate([
            'phone'   => 'required|string',
            'message' => 'required|string|max:160',
        ]);

        $result = $sms->sendSms($request->phone, $request->message);

        return $result
            ? back()->with('success', 'Quick SMS sent successfully!')
            : back()->with('error', 'Failed to send SMS. Check logs.');
    }

    public function translate(Request $request)
{
    $request->validate([
        'text' => 'required|string|max:160',
        'lang' => 'required|in:sw,en',
    ]);

    try {
        $translated = $request->lang === 'sw'
            ? GoogleTranslate::trans($request->text, 'sw')
            : $request->text;

        return response()->json(['translated' => $translated]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Translation failed'], 500);
    }
}

}
