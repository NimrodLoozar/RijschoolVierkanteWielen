<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Package>
 */
class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'type' => $this->faker->randomElement(['package1', 'package2', 'package3']),
            'lesson_count' => $this->faker->numberBetween(5, 20),
            'price_per_lesson' => $this->faker->randomFloat(2, 20, 100),
            'is_active' => true,
            'note' => $this->faker->optional()->sentence(),
        ];
    }
}
