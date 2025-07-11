<?php

namespace App\Http\Controllers;


use App\Models\Crop;
  use App\Models\Region;

use Illuminate\Http\Request;
use App\Models\Farmer;

class FarmerController extends Controller
{
    /*------------------------------------------------------------------
    | LIST FARMERS
    *-----------------------------------------------------------------*/
    public function index()
    {
        $farmers = Farmer::with('crops')      // eager‑load crops
                         ->latest()
                         ->paginate(20);

        return view('farmer.index', compact('farmers'));
    }

    /*------------------------------------------------------------------
    | SHOW CREATE FORM
    *-----------------------------------------------------------------*/


public function create()
{
    $regions = Region::orderBy('name')->pluck('name', 'id');
    $crops   = Crop::orderBy('name')->pluck('name', 'id');

    return view('farmer.create', compact('regions', 'crops'));
}

    /*------------------------------------------------------------------
    | STORE NEW FARMER
    *-----------------------------------------------------------------*/
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|min:4|max:255',
            'phone'        => 'required|digits_between:9,15',
            'location'     => 'required|string|max:255',
            'farming_type' => 'required|in:Crops,Livestock,Mixed',
            'crops'        => 'array|nullable',
            'crops.*'      => 'integer|exists:crops,id',
        ]);

        // 1️⃣ Ondoa crops kwenye array, tutazitumia baadaye
        $cropIds = $validated['crops'] ?? [];
        unset($validated['crops']);

        // 2️⃣ Tengeneza farmer
        $farmer = Farmer::create($validated);

        // 3️⃣ Unganisha mazao (pivot)
        $farmer->crops()->sync($cropIds);

        return redirect()
            ->route('farmer.index')
            ->with('success', 'Farmer registered successfully.');
    }
}
