<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'street' => $this->faker->streetName,
            'house_number' => $this->faker->buildingNumber,
            'addition' => $this->faker->optional()->randomLetter,
            'postal_code' => $this->faker->postcode,
            'city' => $this->faker->city,
            'mobile' => $this->faker->optional()->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'is_active' => $this->faker->boolean,
            'note' => $this->faker->optional()->text,
        ];
    }
}
