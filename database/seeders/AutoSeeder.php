<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Auto;

class AutoSeeder extends Seeder
{
    /**
     * Genereer een willekeurig Nederlands kenteken.
     */
    private function randomDutchLicensePlate()
    {
        $formats = [
            'LL-NN-NN', // XX-99-99
            'NN-LL-NN', // 99-XX-99
            'NN-NN-LL', // 99-99-XX
        ];
        $format = $formats[array_rand($formats)];
        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers = '0123456789';

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
        return $plate;
    }

    public function run()
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

        $usedLicensePlates = [];
        $brands = array_keys($brandsWithModelsAndFuel);

        for ($i = 1; $i <= 10; $i++) {
            do {
                $licensePlate = $this->randomDutchLicensePlate();
            } while (in_array($licensePlate, $usedLicensePlates));

            $usedLicensePlates[] = $licensePlate;

            $brand = $brands[array_rand($brands)];
            $modelData = $brandsWithModelsAndFuel[$brand][array_rand($brandsWithModelsAndFuel[$brand])];
            $model = $modelData['model'];
            $fuel = $modelData['fuel'][array_rand($modelData['fuel'])];

            Auto::create([
                'brand' => $brand,
                'model' => $model,
                'license_plate' => $licensePlate,
                'fuel' => $fuel,
                'is_active' => (bool)rand(0, 1),
                'photo' => 'photos/auto' . $i . '.jpg',
            ]);
        }

        Auto::create([
            'brand' => 'Mercedes',
            'model' => 'E-Class',
            'license_plate' => 'XX-123-YY',
            'fuel' => 'gasoline',
            'is_active' => true,
            'photo' => 'img/mercedes.jpg',
        ]);
    }
}
