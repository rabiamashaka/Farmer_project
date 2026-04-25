<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use App\Models\User;
use App\Models\Farmer;
use App\Models\Crop;
use App\Models\Region;
use App\Traits\UssdMenuTrait;
// use App\Traits\SmsTrait;
use App\Services\NotifyAfricanService;

class UssdController extends Controller
{
    use UssdMenuTrait;

    public function handler(Request $request)
    {
        $phone = $this->formatPhone($request->input('phoneNumber'));
        $phoneForDb = ltrim($phone, '+'); // Normalize for DB
        $text = trim($request->input('text', ''));

        $farmerExists = Farmer::where('phone', $phoneForDb)->exists();
        $steps = $text === '' ? [] : explode('*', $text);

        if ($farmerExists) {
            // If first request or just entered, show already registered menu
            if (count($steps) === 0) {
                return $this->cont("Ulishajisajili.\n1. Endelea na huduma\n2. Toka");
            }
            if (count($steps) === 1) {
                if ($steps[0] === '1') {
                    // Continue to main menu
                    return $this->handleReturnUser('', $phoneForDb);
                }
                if ($steps[0] === '2') {
                    return $this->end('Asante kwa kutembelea!');
                }
                // Invalid choice
                return $this->end('Chaguo si sahihi!');
            }
            // Continue with normal flow for registered user
            return $this->handleReturnUser($text, $phoneForDb);
        }

        // Not registered, continue with registration flow
        return $this->handleNewUser($text, $phoneForDb);
    }

    /* ─────────── RETURNING FARMER ─────────── */
    private function handleReturnUser(string $text, string $phone)
    {
        $steps = $text === '' ? [] : explode('*', $text);
        \Log::info('USSD handleReturnUser steps', ['steps' => $steps]);

        if (count($steps) === 0) {
            return $this->servicesMenu();
        }

        if (count($steps) === 1) {
            return $this->processServiceChoice($steps[0], $phone);
        }

        // Allow ["1","2"] (Endelea na huduma → Taarifa)
        if (count($steps) === 2 && $steps[0] === '1') {
            return $this->processServiceChoice($steps[1], $phone);
        }

        // Accept info menu as ["1","2","1"], ["1","2","2"], ["1","2","3"], ["1","2","4"]
        if (count($steps) === 3 && $steps[0] === '1' && $steps[1] === '2') {
            return match ($steps[2]) {
                '1' => $this->sendWeatherSmsForFarmer($phone),
                '2' => $this->sendMarketPriceSmsForFarmer($phone),
                '3' => $this->sendAdviceSmsForFarmer($phone),
                '4' => $this->sendDiseaseSmsForFarmer($phone),
                default => $this->end(__('Chaguo si sahihi kwenye taarifa!')),
            };
        }

        if (count($steps) === 2 && $steps[0] === '3') {
            return $this->end(__('Asante kwa maoni yako!'));
        }

        return $this->end(__('Chaguo si sahihi!'));
    }

    private function processServiceChoice(string $choice, string $phone)
    {
        return match ($choice) {
            '1' => $this->afterSms(
                __('Umejiandikisha kupokea taarifa kutoka SampleUSSD.'),
                $phone,
                __('SMS imetumwa — Asante!')
            ),
            '2' => $this->cont("Chagua taarifa:\n1. Hali ya hewa\n2. Bei ya mazao\n3. Mbinu bora\n4. Magonjwa"),
            '3' => $this->cont(__('Andika maoni yako mfupi:')),
            '4' => $this->end(__('Asante kwa kutembelea!')),
            default => $this->end('Chaguo si sahihi!'),
        };
    }

    private function servicesMenu()
    {
        return $this->cont(__("Karibu SampleUSSD\n1. Sajili\n2. Taarifa\n3. Tuma maoni\n4. Toka"));
    }

    /* ─────────── NEW FARMER FLOW ─────────── */
    private function handleNewUser(string $text, string $phone)
    {
        $steps = $text === '' ? [] : explode('*', $text);
        $step = count($steps);

        switch ($step) {
            case 0:
                return $this->servicesMenu();

            case 1:
                return match ($steps[0] ?? '') {
                    '1' => $this->cont(__('Weka jina kamili:')),
                    '2', '4' => $this->end(__('Asante kwa kutembelea.')),
                    '3' => $this->cont(__('Andika maoni yako mfupi:')),
                    default => $this->end(__('Chaguo si sahihi!')),
                };

            case 2:
                return $this->cont(__('Andika jina la mkoa (mfano: Mbeya):'));

            case 3:
                return $this->cont(__("Chagua aina ya kilimo:\n1. Mazao\n2. Mifugo\n3. Mchanganyiko"));

            case 4:
                return $this->cont(__('Taja mazao yako, tengeneza kwa koma (mfano: Mahindi, Maharage):'));

            case 5:
                return $this->saveFarmer($steps, $phone);

            default:
                return $this->end(__('Chaguo si sahihi!'));
        }
    }

    private function saveFarmer(array $steps, string $phone)
    {
        [$choice, $name, $regionInput, $typeChoice, $cropNamesCsv] = $steps;

        // Region Validation
        $region = Region::whereRaw('LOWER(name) = ?', [strtolower($regionInput)])->first();
        if (!$region) {
            return $this->end(__('Samahani, mkoa uliouandika haupatikani.'));
        }

        // Farming type validation
        $typeMap = ['1' => 'Crop', '2' => 'Livestock', '3' => 'Mixed'];
        $farmingType = $typeMap[$typeChoice] ?? null;
        if (!$farmingType) {
            return $this->end(__('Aina ya kilimo haijatambuliwa.'));
        }

        // Crop validation
        $inputCropNames = array_filter(array_map('trim', explode(',', $cropNamesCsv)));
        if (empty($inputCropNames)) {
            return $this->end(__('Tafadhali taja angalau zao moja.'));
        }

        $cropModels = Crop::whereIn('name', $inputCropNames)->get();
        $foundNames = $cropModels->pluck('name')->map(fn($n) => strtolower($n))->toArray();
        $missing = array_diff(array_map('strtolower', $inputCropNames), $foundNames);

        if ($missing) {
            return $this->end(__('Mazao hayajapatikana: ') . implode(', ', $missing));
        }

        // Create user and farmer
        $email = 'user' . substr(preg_replace('/\D/', '', $phone), -9) . '@example.com';
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make('12345678'),
            'role' => 'user',
        ]);

        $farmer = Farmer::updateOrCreate(
            ['phone' => $phone], // Save as normalized
            [
                'user_id' => $user->id,
                'name' => $name,
                'phone' => $phone, // Save as normalized
                'region_id' => $region->id,
                'location' => $region->name,
                'farming_type' => $farmingType,
            ]
        );

        $farmer->crops()->sync($cropModels->pluck('id'));

        // Send SMS (strip + for some APIs)
        $cleanPhone = ltrim($phone, '+');
        $sms = new NotifyAfricanService();
        $sms->sendSms($cleanPhone, __('Karibu kwenye mfumo wa Agrtech! usajili wako umefanikiwa.'));

        return $this->end(__("Asante $name, umefanikiwa kusajiliwa!"));
    }

    // Normalize phone to +255 format
    private function formatPhone(string $phone): string
    {
        $phone = preg_replace('/\D/', '', $phone); // remove non-digits
        if (str_starts_with($phone, '255')) {
            return '+' . $phone;
        }

        if (str_starts_with($phone, '0')) {
            return '+255' . substr($phone, 1);
        }

        return '+255' . $phone;
    }

    // Helper to strip plus from phone numbers
    private function stripPlus($phone)
    {
        return ltrim($phone, '+');
    }

    /* ─────────── RESPONSE HELPERS ─────────── */
    private function plain(string $txt)
    {
        return Response::make($txt, 200, ['Content-Type' => 'text/plain']);
    }

    private function end(string $txt)
    {
        return $this->plain("END $txt");
    }

    private function cont(string $txt)
    {
        return $this->plain("CON $txt");
    }

    private function afterSms(string $msg, string $phone, string $ussdEnd)
    {
        try {
            $this->sendText($msg, $this->stripPlus($phone));
        } catch (\Throwable $e) {
            \Log::error('USSD afterSms SMS send error', ['error' => $e->getMessage()]);
            return $this->end('Samahani, SMS haikutumwa.');
        }
        return $this->end($ussdEnd);
    }

    // Send SMS using NotifyAfricanService only
    private function sendText($msg, $phone)
    {
        $sms = new \App\Services\NotifyAfricanService();
        $sms->sendSms($phone, $msg);
    }

    // Send dynamic market price SMS for a farmer (for USSD)
    private function sendMarketPriceSmsForFarmer($phone)
    {
        $farmer = \App\Models\Farmer::where('phone', $phone)->with(['region', 'crops.marketPrices'])->first();
        if (!$farmer) {
            return $this->afterSms('Samahani, hatukupata taarifa zako za mkulima.', $phone, 'Taarifa haijapatikana.');
        }

        $region = $farmer->region ? $farmer->region->name : null;
        $crops = $farmer->crops;

        if ($crops->isEmpty() || !$region) {
            return $this->afterSms('Hakuna mazao au mkoa umehifadhiwa kwenye akaunti yako.', $phone, 'Taarifa haijapatikana.');
        }

        $lines = [];
        foreach ($crops as $crop) {
            $latestPrice = $crop->marketPrices
                ->where('region_id', $farmer->region_id)
                ->sortByDesc('market_date')
                ->first();

            if ($latestPrice) {
                $lines[] = "{$crop->name}: {$latestPrice->price_per_kg} {$latestPrice->currency}";
            } else {
                $lines[] = "{$crop->name}: Hakuna bei ya hivi karibuni";
            }
        }

        $msg = "Bei za mazao yako ($region):\n" . implode("\n", $lines);

        return $this->afterSms($msg, $phone, 'Taarifa ya bei imetumwa kwa SMS.');
    }

    // Personalized weather SMS for farmer
    private function sendWeatherSmsForFarmer($phone)
    {
        $farmer = \App\Models\Farmer::where('phone', $phone)->with('region')->first();
        if (!$farmer || !$farmer->region) {
            return $this->afterSms('Samahani, hatukupata taarifa za mkoa wako.', $phone, 'Taarifa haijapatikana.');
        }

        $weather = \App\Models\Weather::where('region_id', $farmer->region_id)->latest('measured_at')->first();
        if ($weather) {
            $msg = "Hali ya hewa ya {$farmer->region->name}: {$weather->condition}, {$weather->temperature}°C, {$weather->rain}mm (" . $weather->measured_at->format('d M Y H:i') . ")";
        } else {
            $msg = "Hakuna taarifa ya hali ya hewa kwa {$farmer->region->name}.";
        }

        return $this->afterSms($msg, $phone, 'Taarifa ya hali ya hewa imetumwa kwa SMS.');
    }

    // Personalized advice SMS for farmer
    private function sendAdviceSmsForFarmer($phone)
    {
        $farmer = \App\Models\Farmer::where('phone', $phone)->with('crops.advices')->first();
        if (!$farmer) {
            return $this->afterSms('Samahani, hatukupata taarifa zako za mkulima.', $phone, 'Taarifa haijapatikana.');
        }

        $crops = $farmer->crops;
        if ($crops->isEmpty()) {
            return $this->afterSms('Hakuna mazao yaliyohifadhiwa kwenye akaunti yako.', $phone, 'Taarifa haijapatikana.');
        }

        $lines = [];
        foreach ($crops as $crop) {
            $advice = $crop->advices->first();
            if ($advice) {
                $lines[] = "{$crop->name}: {$advice->title} - {$advice->description}";
            } else {
                $lines[] = "{$crop->name}: Hakuna ushauri kwa sasa";
            }
        }

        $msg = "Mbinu bora za mazao yako:\n" . implode("\n", $lines);

        return $this->afterSms($msg, $phone, 'Mbinu bora zimetumwa kwa SMS.');
    }

    // Personalized diseases SMS for farmer
    private function sendDiseaseSmsForFarmer($phone)
    {
        \Log::info('USSD sendDiseaseSmsForFarmer called', ['phone' => $phone]);
        $farmer = \App\Models\Farmer::where('phone', $phone)->with('crops.diseases')->first();
        if (!$farmer) {
            \Log::error('No farmer found', ['phone' => $phone]);
            return $this->afterSms('Samahani, hatukupata taarifa zako za mkulima.', $phone, 'Taarifa haijapatikana.');
        }

        $crops = $farmer->crops;
        if ($crops->isEmpty()) {
            \Log::error('No crops found for farmer', ['phone' => $phone]);
            return $this->afterSms('Hakuna mazao yaliyohifadhiwa kwenye akaunti yako.', $phone, 'Taarifa haijapatikana.');
        }

        $lines = [];
        foreach ($crops as $crop) {
            \Log::info('Checking crop diseases', ['crop' => $crop->name, 'diseases' => $crop->diseases]);
            $disease = $crop->diseases->first();
            if ($disease) {
                $lines[] = "{$crop->name}: {$disease->name} - {$disease->description}";
            } else {
                $lines[] = "{$crop->name}: Hakuna taarifa ya magonjwa";
            }
        }

        $msg = "Magonjwa ya mazao yako:\n" . implode("\n", $lines);

        return $this->afterSms($msg, $phone, 'Taarifa ya magonjwa imetumwa kwa SMS.');
    }
}
