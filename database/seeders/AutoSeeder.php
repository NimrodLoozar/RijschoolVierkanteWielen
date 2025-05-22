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
        $brandsWithModels = [
            'Toyota' => ['Corolla', 'Yaris', 'Aygo', 'Prius', 'RAV4'],
            'Ford' => ['Fiesta', 'Focus', 'Mondeo', 'Puma', 'Kuga'],
            'BMW' => ['320i', 'X5', '2015 M5', 'i3', 'X1'],
            'Mercedes' => ['A-Class', 'C-Class', 'E-Class', 'GLA', 'S-Class'],
            'Volkswagen' => ['Golf', 'Polo', 'Passat', 'Tiguan', 'Up!'],
        ];
        $fuels = ['electric', 'gasoline'];
        $usedLicensePlates = [];

        $brands = array_keys($brandsWithModels);

        for ($i = 1; $i <= 10; $i++) {
            do {
                $licensePlate = $this->randomDutchLicensePlate();
            } while (in_array($licensePlate, $usedLicensePlates));

            $usedLicensePlates[] = $licensePlate;

            $brand = $brands[array_rand($brands)];
            $model = $brandsWithModels[$brand][array_rand($brandsWithModels[$brand])];

            Auto::create([
                'brand' => $brand,
                'model' => $model,
                'license_plate' => $licensePlate,
                'fuel' => $fuels[array_rand($fuels)],
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
