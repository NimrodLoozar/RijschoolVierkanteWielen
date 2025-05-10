<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'name' => $this->faker->randomElement(['Leerling', 'Instructeur', 'Administor', 'Gastgebruiker']),
            'is_active' => $this->faker->boolean(),
            'note' => $this->faker->optional()->text(200),
        ];
    }
}
