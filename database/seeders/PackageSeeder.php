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
            [
                'type' => 'package1',
                'lesson_count' => 10,
                'price_per_lesson' => 25.00,
                'is_active' => true,
                'note' => 'Basic package for beginners.',
            ],
            [
                'type' => 'package2',
                'lesson_count' => 20,
                'price_per_lesson' => 22.50,
                'is_active' => true,
                'note' => 'Intermediate package with a discount.',
            ],
            [
                'type' => 'package3',
                'lesson_count' => 30,
                'price_per_lesson' => 20.00,
                'is_active' => true,
                'note' => 'Advanced package for experienced learners.',
            ],
        ]);
    }
}
