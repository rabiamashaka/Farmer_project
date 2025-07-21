<?php

namespace App\Http\Controllers;

use App\Models\SmsCampaign;
use App\Models\ContentTemplate;
use App\Models\Farmer;
use Illuminate\Http\Request;
use App\Services\NotifyAfricanService;
use App\Jobs\SendSmsJob;
use App\Jobs\SendBulkSmsJob;
use App\Models\Crop;
 use Stichoza\GoogleTranslate\GoogleTranslate;

use App\Models\Region;
class SmsCampaignsController extends Controller
{
    public function index()
    {
         app()->setLocale(session('locale', config('app.locale')));
        $campaigns = SmsCampaign::latest()->get();

        // Pre‑filled templates, regions & crops kwa modal
        $templates = ContentTemplate::where('status', 'published')->get();
        
        // Get regions - ensure it's always an array
        try {
            $regions = Region::whereIn('id', Farmer::distinct()->pluck('region_id'))->pluck('name')->toArray();
        } catch (\Exception $e) {
            $regions = [];
        }
        
        // Get crops - ensure it's always an array
        try {
            $crops = Crop::pluck('name')->toArray();
        } catch (\Exception $e) {
            $crops = [];
        }

        // Ensure we always have arrays, even if empty
        if (!is_array($regions)) $regions = [];
        if (!is_array($crops)) $crops = [];

        return view('sms_campaigns.index', compact(
            'campaigns', 'templates', 'regions', 'crops'
        ));
    }

    public function create()
    {
        app()->setLocale(session('locale', config('app.locale')));
        
        // Get regions and crops for the form
        try {
            $regions = Region::whereIn('id', Farmer::distinct()->pluck('region_id'))->pluck('name')->toArray();
        } catch (\Exception $e) {
            $regions = [];
        }
        
        try {
            $crops = Crop::pluck('name')->toArray();
        } catch (\Exception $e) {
            $crops = [];
        }

        // Fetch published content templates
        $templates = ContentTemplate::where('status', 'published')->get();

        // Ensure we always have arrays, even if empty
        if (!is_array($regions)) $regions = [];
        if (!is_array($crops)) $crops = [];

        return view('sms_campaigns.create', compact('regions', 'crops', 'templates'));
    }

 

public function store(Request $request)
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
    $regionNames = Region::whereIn('id', $data['locations'])->pluck('name')->toArray();
    $farmerQuery->whereIn('region_id', $data['locations']);
} else {
    $regionNames = null;
}

    if (!empty($data['crops'])) {
        $farmerQuery->whereHas('crops', function ($q) use ($data) {
            $q->whereIn('name', $data['crops']);
        });
    }

    
   $sentCount = 0;
   $phones = [];
   
   // Collect all phone numbers
   $farmerQuery->chunkById(200, function ($farmers) use (&$phones, $campaign) {
       foreach ($farmers as $farmer) {
           $phones[] = $farmer->phone;
       }
   });
   
   // Send bulk SMS using Modifier Africa
   if (!empty($phones)) {
       // Split into batches of 100 for better performance
       $batches = array_chunk($phones, 100);
       
       foreach ($batches as $batch) {
           SendBulkSmsJob::dispatch($batch, $campaign->message, $campaign->id);
           $sentCount += count($batch);
       }
   }


    
    $campaign->update([
        'status'   => 'sent',
        'sent_to'  => $sentCount,
    ]);

    return back()->with('success', "Campaign created and queued for {$sentCount} farmers!");
}


  
    public function sendQuickSms(Request $request, NotifyAfricanService $sms)
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

    /**
     * Get account balance
     */
    public function getBalance(NotifyAfricanService $sms)
    {
        try {
            $balance = $sms->getBalance();
            return response()->json($balance);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to get balance'], 500);
        }
    }

    /**
     * Get SMS delivery status
     */
    public function getDeliveryStatus(Request $request, NotifyAfricanService $sms)
    {
        $request->validate([
            'message_id' => 'required|string'
        ]);

        try {
            $status = $sms->getDeliveryStatus($request->message_id);
            return response()->json($status);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to get status'], 500);
        }
    }

}
