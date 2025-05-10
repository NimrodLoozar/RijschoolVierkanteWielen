<?php

namespace Database\Factories;

use App\Models\Contact;
use App\Models\Role;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $user = User::factory()->create();

        $student = [
            'user_id' => $user->id,
            'relation_number' => $this->faker->unique()->numerify('RN######'),
            'is_active' => $this->faker->boolean(),
            'note' => $this->faker->optional()->text(200),
        ];

        Role::create([
            'user_id' => $user->id,
            'name' => 'Leerling',
            'is_active' => $this->faker->boolean(),
            'note' => $this->faker->optional()->text(200),
        ]);

        Contact::create([
            'user_id' => $user->id,
            'street' => $this->faker->streetName(),
            'house_number' => $this->faker->numberBetween(1, 100),
            'postal_code' => $this->faker->postcode(),
            'city' => $this->faker->city(),
            'mobile' => $this->faker->optional()->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'is_active' => $this->faker->boolean(),
            'note' => $this->faker->optional()->text(200),
        ]);

        return $student;
    }
}
