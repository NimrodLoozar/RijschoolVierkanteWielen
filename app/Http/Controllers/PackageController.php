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
        $request->validate([
            'type' => [
                'required',
                'string',
                'max:32',
                'regex:/^[\pL\s]+$/u',
                function ($attribute, $value, $fail) {
                    if (\App\Models\Package::where('type', $value)->exists()) {
                        $fail('Er bestaat al een lesrijpakket met dit type.');
                    }
                }
            ],
            'lesson_count' => ['required', 'integer', 'min:0', 'max:100'],
            'price_per_lesson' => ['required', 'numeric', 'min:0'],
            'is_active' => 'nullable|boolean',
            'note' => [
                'nullable',
                'string',
                'max:1000',
                'regex:/^[\pL\s]*$/u'
            ],
        ], [
            'type.regex' => 'Het type mag alleen letters en spaties bevatten (geen cijfers of andere tekens).',
            'note.regex' => 'De opmerking mag alleen letters en spaties bevatten (geen cijfers of andere tekens).',
        ]);

        \App\Models\Package::create([
            'type' => $request->type,
            'lesson_count' => $request->lesson_count,
            'price_per_lesson' => $request->price_per_lesson,
            'is_active' => $request->has('is_active'),
            'note' => $request->note,
        ]);

        return redirect()->route('packages.index')->with('success', 'Pakket succesvol toegevoegd.');
    }
}
