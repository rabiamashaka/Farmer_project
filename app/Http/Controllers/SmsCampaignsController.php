<?php

namespace App\Http\Controllers;

use App\Models\SmsCampaign;
use App\Models\ContentTemplate;
use App\Models\Farmer;
use Illuminate\Http\Request;
use App\Services\NotifyAfricanService;
use App\Models\Crop;
use App\Models\Region;
use Stichoza\GoogleTranslate\GoogleTranslate;

class SmsCampaignsController extends Controller
{
    public function index()
    {
        app()->setLocale(session('locale', config('app.locale')));
        $campaigns = SmsCampaign::latest()->get();
        $templates = ContentTemplate::all();

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

        return view('sms_campaigns.index', compact('campaigns', 'templates', 'regions', 'crops'));
    }

    public function create()
    {
        app()->setLocale(session('locale', config('app.locale')));
        $regions = Region::whereIn('id', Farmer::distinct()->pluck('region_id'))->get();
        $crops = Crop::all();
        $templates = ContentTemplate::all();

        return view('sms_campaigns.create', compact('regions', 'crops', 'templates'));
    }

    public function store(Request $request, NotifyAfricanService $sms)
    {
        \Log::info('SmsCampaignsController@store called');
        $data = $request->validate([
            'title'     => 'required|string|max:255',
            'message'   => 'required|string|max:160',
            'locations' => 'array|nullable',
            'locations.*'=> 'string',
            'crops'     => 'array|nullable',
            'crops.*'   => 'string',
            'language'  => 'required|string|in:sw,en',
        ]);

        if (empty($data['locations']) && empty($data['crops'])) {
            return back()->with('error', 'Please select at least one region or crop.');
        }

        $translatedMessage = $data['message'];

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
            $farmerQuery->whereIn('region_id', $data['locations']);
        }
        if (!empty($data['crops'])) {
            $farmerQuery->whereHas('crops', function ($q) use ($data) {
                $q->whereIn('name', $data['crops']);
            });
        }

        $phones = [];
        $farmerQuery->chunkById(200, function ($farmers) use (&$phones) {
            foreach ($farmers as $farmer) {
                if ($farmer->phone && preg_match('/^\+?\d{10,15}$/', $farmer->phone)) {
                    $phones[] = $farmer->phone;
                }
            }
        });

        \Log::info('Collected phones', ['phones' => $phones]);

        $phones = array_unique($phones);
        if (empty($phones)) {
            $campaign->update(['status' => 'failed']);
            return back()->with('error', 'No valid farmers found for the selected criteria.');
        }

        // ✅ Send immediately without using a Job
        $batches = array_chunk($phones, 100);
        $sentCount = 0;
        foreach ($batches as $batch) {
            \Log::info('Sending via NotifyAfricanService directly', ['phones' => $batch]);
            $sms->sendBulkSms($batch, $campaign->message); // <- Direct call
            $sentCount += count($batch);
        }

        $campaign->update([
            'status'   => 'sent',
            'sent_to'  => $sentCount,
        ]);

        return back()->with('success', "Campaign created and SMS sent to {$sentCount} farmers!");
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

    public function getBalance(NotifyAfricanService $sms)
    {
        try {
            $balance = $sms->getBalance();
            return response()->json($balance);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to get balance'], 500);
        }
    }

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

    public function destroy($id)
    {
        $campaign = \App\Models\SmsCampaign::findOrFail($id);
        $campaign->delete();
        return redirect()->route('sms_campaigns.index')->with('success', 'Campaign deleted successfully.');
    }
}
