<?php

namespace App\Http\Controllers;
use App\Models\SmsCampaign;
use Illuminate\Http\Request;
use App\Services\AfricasTalkingService;
use App\Models\Farmer;
use App\Jobs\SendSmsJob;

class SmsCampaignsController extends Controller
{
  
    public function index()
    {
        $campaigns = SmsCampaign::latest()->get();
        return view('sms_campaigns.index', compact('campaigns'));
    }
public function store(Request $request, AfricasTalkingService $sms)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'message' => 'required|string|max:160',
        'locations' => 'required|array',
        'crops' => 'required|array',
        'language' => 'required|string',
    ]);

    // Create the campaign
    $campaign = SmsCampaign::create([
        'title' => $request->title,
        'message' => $request->message,
        'locations' => json_encode($request->locations),
        'crops' => json_encode($request->crops),
        'language' => $request->language,
        'status' => 'sent'
    ]);

    // Get farmers matching the campaign filters
    $farmers = Farmer::whereIn('location', $request->locations)
        ->whereIn('crop', $request->crops)
        ->where('language', $request->language)
        ->get();

    // Send SMS to each farmer
   foreach ($farmers as $farmer) {
    SendSmsJob::dispatch($farmer->phone, $campaign->message);
}

    return back()->with('success', 'Campaign created and SMS sent to ' . $farmers->count() . ' farmers!');
}

   public function sendQuickSms(Request $request, AfricasTalkingService $sms)
{
    $request->validate([
        'phone' => 'required|string',
        'message' => 'required|string|max:160',
    ]);

    $result = $sms->sendSms($request->phone, $request->message);

    if ($result === false) {
        return back()->with('error', 'Failed to send SMS. Check logs.');
    }

    return back()->with('success', 'Quick SMS sent successfully!');
}

}
