<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::all();
        return view('packages.index', compact('packages'));
    }

    public function create()
    {
        return view('packages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:32',
            'lesson_count' => 'required|integer|min:0',
            'price_per_lesson' => 'required|numeric|min:0',
            'is_active' => 'nullable|boolean',
            'note' => 'nullable|string',
        ]);

        Package::create([
            'type' => $validated['type'],
            'lesson_count' => $validated['lesson_count'],
            'price_per_lesson' => $validated['price_per_lesson'],
            'is_active' => $request->has('is_active'),
            'note' => $validated['note'] ?? null,
        ]);

        return redirect()->route('packages.index')->with('success', 'Pakket succesvol toegevoegd.');
    }
}
