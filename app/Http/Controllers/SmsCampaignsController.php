<?php

namespace App\Http\Controllers;

use App\Models\SmsCampaign;
use App\Models\ContentTemplate;
use App\Models\Farmer;
use Illuminate\Http\Request;
use App\Services\AfricasTalkingService;
use App\Jobs\SendSmsJob;
use App\Models\Crop;

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

    /*------------------------------------------------------------------
    | STORE / SEND CAMPAIGN
    *-----------------------------------------------------------------*/
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

        // 1️⃣ Hifadhi campaign – tunategemea casts ('array') kwenye model
        $campaign = SmsCampaign::create([
            'title'     => $data['title'],
            'message'   => $data['message'],
            'locations' => $data['locations'] ?? [],
            'crops'     => $data['crops']     ?? [],
            'language'  => $data['language'],
            'status'    => 'queued',
        ]);

        // 2️⃣ Tafuta wakulima wanaolingana (query inajirekebisha kulingana na filters)
        $farmerQuery = Farmer::query();

        if (!empty($data['locations'])) {
            $farmerQuery->whereIn('location', $data['locations']);
        }
        if (!empty($data['crops'])) {
    $farmerQuery->whereHas('crops', function ($q) use ($data) {
       $q->whereIn('name', $data['crops']);
  });

}

        $farmerQuery->where('language', $data['language']);

        // 3️⃣ Tuma SMS kwa chunks kupitia job queue
        $sentCount = 0;
        $farmerQuery->chunkById(200, function ($farmers) use (&$sentCount, $campaign) {
            foreach ($farmers as $farmer) {
                SendSmsJob::dispatch($farmer->phone, $campaign->message, $campaign->id);
                $sentCount++;
            }
        });

        // 4️⃣ Rekebisha status & takwimu
        $campaign->update([
            'status'   => 'sent',
            'sent_to'  => $sentCount,
        ]);

        return back()->with('success', "Campaign created and queued for {$sentCount} farmers!");
    }

    /*------------------------------------------------------------------
    | QUICK SMS (single number)
    *-----------------------------------------------------------------*/
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
}
