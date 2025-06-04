<?php

namespace App\Http\Controllers;

use App\Models\Auto;
use Illuminate\Http\Request;

class AutoController extends Controller
{
    public function index()
    {
        $autos = Auto::all(); // Fetch all autos
        return view('autos.index', compact('autos')); // Pass autos to the view
    }

    public function create()
    {
        return view('autos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'license_plate' => 'required|string|max:255|unique:autos,license_plate',
            'fuel' => 'required|in:electric,gasoline',
            'is_active' => 'nullable|boolean',
        ]);

        Auto::create([
            'brand' => $validated['brand'],
            'model' => $validated['model'],
            'license_plate' => $validated['license_plate'],
            'fuel' => $validated['fuel'],
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('autos.index')->with('success', 'Auto succesvol toegevoegd.');
    }
}
