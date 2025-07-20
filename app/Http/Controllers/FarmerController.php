<?php

namespace App\Http\Controllers;

use App\Models\Crop;
use App\Models\Region;
use Illuminate\Http\Request;
use App\Models\Farmer;

class FarmerController extends Controller
{
   public function index()
{
     app()->setLocale(session('locale', config('app.locale')));
 $farmers = Farmer::with(['crops', 'region'])->paginate(10); 
    return view('farmer.index', compact('farmers'));
}

    public function create()
    {
        $regions = Region::orderBy('name')->pluck('name', 'id');
        $crops   = Crop::orderBy('name')->pluck('name', 'id');

        return view('farmer.create', compact('regions', 'crops'));
    }

    /**
     * Display the specified farmer.
     */
    public function show(Farmer $farmer)
    {
        return view('farmer.show', compact('farmer'));
    }

    /*------------------------------------------------------------------
    | STORE NEW FARMER
    *-----------------------------------------------------------------*/
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|min:4|max:255',
            'phone'        => 'required|digits_between:9,15',
            'region_id'    => 'required|exists:regions,id',  // ✅ Add this
            'farming_type' => 'required|in:Crops,Livestock,Mixed',
            'crops'        => 'array|nullable',
            'crops.*'      => 'integer|exists:crops,id',
        ]);

        $cropIds = $validated['crops'] ?? [];
        unset($validated['crops']);

        $farmer = Farmer::create($validated);

        $farmer->crops()->sync($cropIds);

        return redirect()
            ->route('farmer.index')
            ->with('success', 'Farmer registered successfully.');
    }

    /**
     * Show the form for editing the specified farmer.
     */
    public function edit(Farmer $farmer)
    {
        $regions = Region::orderBy('name')->pluck('name', 'id');
        $crops = Crop::orderBy('name')->pluck('name', 'id');
        
        return view('farmer.edit', compact('farmer', 'regions', 'crops'));
    }

    /**
     * Update the specified farmer in storage.
     */
    public function update(Request $request, Farmer $farmer)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:4|max:255',
            'phone' => 'required|digits_between:9,15',
            'region_id' => 'required|exists:regions,id',
            'farming_type' => 'required|in:Crops,Livestock,Mixed',
            'crops' => 'array|nullable',
            'crops.*' => 'integer|exists:crops,id',
        ]);

        $cropIds = $validated['crops'] ?? [];
        unset($validated['crops']);

        $farmer->update($validated);
        $farmer->crops()->sync($cropIds);

        return redirect()
            ->route('farmer.index')
            ->with('success', 'Farmer updated successfully.');
    }

    /**
     * Remove the specified farmer from storage.
     */
    public function destroy(Farmer $farmer)
    {
        try {
            // Detach crops before deleting farmer
            $farmer->crops()->detach();
            
            $farmer->delete();

            return redirect()
                ->route('farmer.index')
                ->with('success', 'Farmer deleted successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->route('farmer.index')
                ->with('error', 'Failed to delete farmer. Please try again.');
        }
    }
}
