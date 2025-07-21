<?php

namespace App\Http\Controllers;

use App\Models\Crop;
use App\Models\CropInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CropInformationController extends Controller
{
    public function index()
    {
        $infos = CropInformation::with('crop')->latest()->paginate(20);
        return view('admin.crop_information.index', compact('infos'));
    }

    public function create()
    {
        $crops = Crop::all();
        return view('admin.crop_information.create', compact('crops'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'crop_id' => 'required|exists:crops,id',
            'type' => 'required|string',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('crop_info', 'public');
        }
        CropInformation::create($data);
        return redirect()->route('admin.cropinfo.index')->with('success', 'Crop information added!');
    }

    public function edit(CropInformation $cropinfo)
    {
        $crops = Crop::all();
        return view('admin.crop_information.edit', compact('cropinfo', 'crops'));
    }

    public function update(Request $request, CropInformation $cropinfo)
    {
        $data = $request->validate([
            'crop_id' => 'required|exists:crops,id',
            'type' => 'required|string',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('image')) {
            if ($cropinfo->image_path) {
                Storage::disk('public')->delete($cropinfo->image_path);
            }
            $data['image_path'] = $request->file('image')->store('crop_info', 'public');
        }
        $cropinfo->update($data);
        return redirect()->route('admin.cropinfo.index')->with('success', 'Crop information updated!');
    }

    public function destroy(CropInformation $cropinfo)
    {
        if ($cropinfo->image_path) {
            Storage::disk('public')->delete($cropinfo->image_path);
        }
        $cropinfo->delete();
        return redirect()->route('admin.cropinfo.index')->with('success', 'Crop information deleted!');
    }
} 