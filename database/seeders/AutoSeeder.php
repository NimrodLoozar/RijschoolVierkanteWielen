<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Auto;

class AutoSeeder extends Seeder
{
    public function run()
    {
        $brands = ['Toyota', 'Ford', 'BMW', 'Mercedes', 'Volkswagen'];
        $models = ['Model A', 'Model B', 'Model C', 'Model D', 'Model E'];
        $fuels = ['electric', 'gasoline'];

        for ($i = 1; $i <= 10; $i++) {
            Auto::create([
                'brand' => $brands[array_rand($brands)],
                'model' => $models[array_rand($models)],
                'license_plate' => 'XX-' . rand(100, 999) . '-YY',
                'fuel' => $fuels[array_rand($fuels)],
                'is_active' => (bool)rand(0, 1),
                'photo' => 'photos/auto' . $i . '.jpg', // Example photo path
            ]);
        }

        Auto::create([
            'brand' => 'Mercedes',
            'model' => 'E-Class',
            'license_plate' => 'XX-123-YY',
            'fuel' => 'gasoline',
            'is_active' => true,
            'photo' => 'img/mercedes.jpg', // Path to the photo in the public/img folder
        ]);
    }
}
