<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function index()
    {
        return view('content.index');
    }
    
    public function create()
{
    return view('content.create');
}

public function store(Request $request)
{
    // Validate and save logic here
    // e.g., Content::create($request->all());

    return redirect()->route('content.index')->with('success', 'Content created successfully.');
}

}

