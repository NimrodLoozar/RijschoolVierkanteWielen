<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('packages')->insert([
            // [
            //     'type' => 'Proefles',
            //     'lesson_count' => 1,
            //     'price_per_lesson' => 40.00,
            //     'is_active' => true,
            //     'note' => null,
            // ],
            [
                'type' => 'Losse les',
                'lesson_count' => 1,
                'price_per_lesson' => 67.50,
                'is_active' => true,
                'note' => null,
            ],
            [
                'type' => '10 lessen',
                'lesson_count' => 10,
                'price_per_lesson' => 99.00,
                'is_active' => true,
                'note' => 'Inclusief praktijkexamen.',
            ],
            [
                'type' => '20 lessen',
                'lesson_count' => 20,
                'price_per_lesson' => 81.25,
                'is_active' => true,
                'note' => 'Inclusief praktijkexamen.',
            ],
            [
                'type' => '30 lessen',
                'lesson_count' => 30,
                'price_per_lesson' => 75.00,
                'is_active' => true,
                'note' => 'Inclusief praktijkexamen.',
            ],
            [
                'type' => '40 lessen',
                'lesson_count' => 40,
                'price_per_lesson' => 71.75,
                'is_active' => true,
                'note' => 'Inclusief praktijkexamen.',
            ],
            [
                'type' => 'Praktijkexamen',
                'lesson_count' => 0,
                'price_per_lesson' => 350.00,
                'is_active' => true,
                'note' => null,
            ],
            [
                'type' => 'Faalangstexamen',
                'lesson_count' => 0,
                'price_per_lesson' => 380.00,
                'is_active' => true,
                'note' => null,
            ],
        ]);
    }
}
