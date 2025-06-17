<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FarmerController extends Controller
{
    public function index()
    {
        return view('farmer.index');
    }

    public function create()
{
    return view('farmer.create');
}
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'location' => 'required|string|max:255',
        'farming_type' => 'required|string',
        'crops' => 'nullable|array',
    ]);

    // Convert array of crops into comma-separated string
    $validated['crops'] = isset($validated['crops']) ? implode(',', $validated['crops']) : null;

    Farmer::create($validated);

    return redirect()->route('farmer.index')->with('success', 'Farmer registered successfully.');
}

}

