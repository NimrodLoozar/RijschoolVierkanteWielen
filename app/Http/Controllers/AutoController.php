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
        $brandsWithModelsAndFuel = [
            'BMW' => [
                ['model' => '1-serie', 'fuel' => ['gasoline']],
                ['model' => '3-serie', 'fuel' => ['gasoline']],
                ['model' => '5-serie', 'fuel' => ['gasoline']],
                ['model' => 'X1', 'fuel' => ['gasoline']],
                ['model' => 'X3', 'fuel' => ['gasoline']],
                ['model' => 'X5', 'fuel' => ['gasoline']],
                ['model' => 'i3', 'fuel' => ['electric']],
                ['model' => 'i8', 'fuel' => ['electric']],
            ],
            'Mercedes' => [
                ['model' => 'A-Klasse', 'fuel' => ['gasoline']],
                ['model' => 'C-Klasse', 'fuel' => ['gasoline']],
                ['model' => 'E-Klasse', 'fuel' => ['gasoline']],
                ['model' => 'S-Klasse', 'fuel' => ['gasoline']],
                ['model' => 'GLA', 'fuel' => ['gasoline']],
                ['model' => 'GLC', 'fuel' => ['gasoline']],
                ['model' => 'GLE', 'fuel' => ['gasoline']],
            ],
            'Toyota' => [
                ['model' => 'Aygo', 'fuel' => ['gasoline']],
                ['model' => 'Yaris', 'fuel' => ['gasoline']],
                ['model' => 'Corolla', 'fuel' => ['gasoline']],
                ['model' => 'Prius', 'fuel' => ['gasoline', 'electric']],
                ['model' => 'RAV4', 'fuel' => ['gasoline']],
            ],
            'Tesla' => [
                ['model' => 'Model S', 'fuel' => ['electric']],
                ['model' => 'Model 3', 'fuel' => ['electric']],
                ['model' => 'Model X', 'fuel' => ['electric']],
                ['model' => 'Model Y', 'fuel' => ['electric']],
            ],
            // ...andere merken en modellen...
        ];
        return view('autos.create', compact('brandsWithModelsAndFuel'));
    }

    public function store(Request $request)
    {
        $brandsWithModelsAndFuel = [
            "Toyota" => [
                ["model" => "Corolla", "fuel" => ["gasoline"]],
                ["model" => "Yaris", "fuel" => ["gasoline"]],
                ["model" => "Aygo", "fuel" => ["gasoline"]],
                ["model" => "Prius", "fuel" => ["gasoline", "electric"]],
                ["model" => "RAV4", "fuel" => ["gasoline"]],
            ],
            "Ford" => [
                ["model" => "Fiesta", "fuel" => ["gasoline"]],
                ["model" => "Focus", "fuel" => ["gasoline"]],
                ["model" => "Mondeo", "fuel" => ["gasoline"]],
                ["model" => "Puma", "fuel" => ["gasoline"]],
                ["model" => "Kuga", "fuel" => ["gasoline"]],
            ],
            "BMW" => [
                ["model" => "320i", "fuel" => ["gasoline"]],
                ["model" => "X5", "fuel" => ["gasoline"]],
                ["model" => "2015 M5", "fuel" => ["gasoline"]],
                ["model" => "i3", "fuel" => ["electric"]],
                ["model" => "X1", "fuel" => ["gasoline"]],
            ],
            "Mercedes" => [
                ["model" => "A-Class", "fuel" => ["gasoline"]],
                ["model" => "C-Class", "fuel" => ["gasoline"]],
                ["model" => "E-Class", "fuel" => ["gasoline"]],
                ["model" => "GLA", "fuel" => ["gasoline"]],
                ["model" => "S-Class", "fuel" => ["gasoline"]],
            ],
            "Volkswagen" => [
                ["model" => "Golf", "fuel" => ["gasoline"]],
                ["model" => "Polo", "fuel" => ["gasoline"]],
                ["model" => "Passat", "fuel" => ["gasoline"]],
                ["model" => "Tiguan", "fuel" => ["gasoline"]],
                ["model" => "Up!", "fuel" => ["gasoline"]],
            ],
            "Tesla" => [
                ["model" => "Model S", "fuel" => ["electric"]],
                ["model" => "Model 3", "fuel" => ["electric"]],
                ["model" => "Model X", "fuel" => ["electric"]],
                ["model" => "Model Y", "fuel" => ["electric"]],
            ],
        ];

        $brands = array_keys($brandsWithModelsAndFuel);
        $modelsPerBrand = [];
        $fuelPerBrandModel = [];
        foreach ($brandsWithModelsAndFuel as $brand => $models) {
            $modelsPerBrand[$brand] = [];
            foreach ($models as $item) {
                $modelsPerBrand[$brand][] = $item['model'];
                $fuelPerBrandModel[$brand][$item['model']] = $item['fuel'];
            }
        }

        $request->validate([
            'brand' => ['required', 'string', 'in:' . implode(',', $brands)],
            'model' => [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($request, $modelsPerBrand) {
                    $brand = $request->input('brand');
                    if (!isset($modelsPerBrand[$brand]) || !in_array($value, $modelsPerBrand[$brand])) {
                        $fail('Het gekozen model hoort niet bij het geselecteerde merk.');
                    }
                }
            ],
            'fuel' => [
                'required',
                'string',
                // Let op: accepteer 'gasoline' en 'electric', niet 'benzine' of 'elektrisch'
                function ($attribute, $value, $fail) use ($request, $fuelPerBrandModel) {
                    $brand = $request->input('brand');
                    $model = $request->input('model');
                    if (!isset($fuelPerBrandModel[$brand][$model]) || !in_array($value, $fuelPerBrandModel[$brand][$model])) {
                        $fail('De gekozen brandstof hoort niet bij het geselecteerde merk/model.');
                    }
                }
            ],
            'is_active' => 'nullable|boolean',
        ]);

        $license_plate = $this->generateDutchLicensePlate();

        \App\Models\Auto::create([
            'brand' => $request->brand,
            'model' => $request->model,
            'license_plate' => $license_plate,
            'fuel' => $request->fuel,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('autos.index')->with('success', 'Auto succesvol toegevoegd.');
    }

    private function generateDutchLicensePlate()
    {
        $formats = [
            'LL-NN-NN', // XX-99-99
            'NN-LL-NN', // 99-XX-99
            'NN-NN-LL', // 99-99-XX
            'LL-NN-LL', // XX-99-XX
            'NN-LL-LL', // 99-XX-XX
            'LL-LL-NN', // XX-XX-99
        ];
        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers = '0123456789';

        do {
            $format = $formats[array_rand($formats)];
            $plate = '';
            foreach (str_split($format) as $char) {
                if ($char === 'L') {
                    $plate .= $letters[random_int(0, 25)];
                } elseif ($char === 'N') {
                    $plate .= $numbers[random_int(0, 9)];
                } else {
                    $plate .= $char;
                }
            }
        } while (\App\Models\Auto::where('license_plate', $plate)->exists());

        return $plate;
    }
}
