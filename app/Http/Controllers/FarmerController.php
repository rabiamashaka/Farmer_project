<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Farmer;

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
    'name' => 'required|string|min:4|max:255',
    'phone' => 'required|digits_between:9,15',
    'location' => 'required|string|max:255',
    'farming_type' => 'required|in:Crops,Livestock,Mixed',
    'crops' => 'nullable|array',
    'crops.*' => 'string|in:Maize,Rice,Beans,Cassava,Sorghum,Tomatoes,Onions',
]);



    // Convert array of crops into comma-separated string
    $validated['crops'] = isset($validated['crops']) ? implode(',', $validated['crops']) : null;

    Farmer::create($validated);

    return redirect()->route('farmer.index')->with('success', 'Farmer registered successfully.');
}

}

