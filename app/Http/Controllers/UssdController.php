<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Farmer;
use App\Models\Crop;
use App\Models\Region;
use App\Traits\UssdMenuTrait;
use App\Traits\SmsTrait;

class UssdController extends Controller
{
    use UssdMenuTrait; 
    use SmsTrait;      

    public function handler(Request $request)
    {
        $phone = $request->input('phoneNumber');
        $text  = trim($request->input('text', ''));

        if (Farmer::where('phone', $phone)->exists()) {
            return $this->handleReturnUser($text, $phone);
        }

        // Otherwise start the registration flow
        return $this->handleNewUser($text, $phone);
    }

    /* ─────────── RETURNING FARMER ─────────── */
    private function handleReturnUser(string $text, string $phone)
    {
        $steps = $text === '' ? [] : explode('*', $text);

        // Level‑0
        if (count($steps) === 0) {
            return $this->servicesMenu(); // comes from UssdMenuTrait
        }

        // Level‑1 – service choice
        if (count($steps) === 1) {
            return $this->processServiceChoice($steps[0], $phone);
        }

        return $this->end(__('Invalid choice!'));
    }

    private function processServiceChoice(string $choice, string $phone)
    {
        return match ($choice) {
            '1' => $this->afterSms(
                        __('You have subscribed to SampleUSSD updates.'),
                        $phone,
                        __('SMS sent — Thank you!')
                    ),
            '2' => $this->afterSms(
                        __('This is an information service from SampleUSSD.'),
                        $phone,
                        __('More information will come via SMS.')
                    ),
            '3' => $this->end(__('Welcome back!')),
            default => $this->end(__('Invalid choice!')),
        };
    }

    /* ─────────── NEW FARMER FLOW (steps 0‑5) ─────────── */
    private function handleNewUser(string $text, string $phone)
    {
        $steps = $text === '' ? [] : explode('*', $text);
        $step  = count($steps); // 0–5

        switch ($step) {
            case 0:
                return $this->cont(__("Welcome SampleUSSD\n1. Register\n2. Exit"));

            case 1:
                return match ($steps[0] ?? '') {
                    '1' => $this->cont(__('Enter Full Name:')),
                    '2' => $this->end(__('Thank you! Welcome back.')),
                    default => $this->end(__('Invalid choice!')),
                };

            case 2:
                // Ask user to TYPE region name (free text)
                return $this->cont(__('Enter Location (e.g: Mbeya):'));

            case 3:
                /* Ask for Farming Type */
                return $this->cont(
                    __("Choose Farming Type:\n") .
                    __("1. Crop  2. Livestock  3. Mixed")
                );

            case 4:
                /* Ask for crops – user types names separated by commas */
                return $this->cont(
                    __("List your crops, separate with commas\n") .
                    __("(e.g: Maize,Beans)")
                );

            case 5:
                return $this->saveFarmer($steps, $phone);

            default:
                return $this->end(__('Invalid choice!'));
        }
    }

    private function saveFarmer(array $steps, string $phone)
    {
        // Expected: [ '1', $name, $regionName, $typeChoice, $cropNamesCsv ]
        [$name, $regionName, $typeChoice, $cropNamesCsv] = array_map(
            'trim',
            array_slice($steps, 1)
        );

        /* ─────────── Validate Region ─────────── */
        $region = Region::whereRaw('LOWER(name) = ?', [strtolower($regionName)])->first();
        if (!$region) {
            return $this->end(__('Sorry, that region does not exist.'));
        }
        $location = $region->name; // Keep DB‑canonical spelling

        /* ─────────── Map farming type number → string ─────────── */
        $typeMap = ['1' => 'Crop', '2' => 'Livestock', '3' => 'Mixed'];
        $farmingType = $typeMap[$typeChoice] ?? null;
        if (!$farmingType) {
            return $this->end(__('Invalid farming type choice.'));
        }

        $inputCropNames = array_filter(array_map('trim', explode(',', $cropNamesCsv)));
        if (empty($inputCropNames)) {
            return $this->end(__('Please specify at least one crop.'));
        }

        $cropModels = Crop::whereIn('name', $inputCropNames)->get();
        $foundNames = $cropModels->pluck('name')->map(fn($n) => strtolower($n))->toArray();
        $missing    = array_diff(array_map('strtolower', $inputCropNames), $foundNames);

        if ($missing) {
            return $this->end(__('Crops not found: ') . implode(', ', $missing));
        }

        $cropIds = $cropModels->pluck('id')->toArray();

        /* ─────────── Create / update Farmer ─────────── */
        $farmer = Farmer::updateOrCreate(
            ['phone' => $phone],
            [
                'name'         => $name,
                'location'     => $location,
                'farming_type' => $farmingType,
            ]
        );

        /* Sync crops in pivot table */
        $farmer->crops()->sync($cropIds);

        return $this->end(__("Thank you $name, you are registered!"));
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
        $this->sendText($msg, $phone);
        return $this->end($ussdEnd);
    }
}