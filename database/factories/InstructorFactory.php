<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Role;
use App\Models\Contact;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Instructor>
 */
class InstructorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $user = User::factory()->create();

        $instructor = [
            'user_id' => $user->id,
            'number' => $this->faker->unique()->numerify('IN######'),
            'is_active' => $this->faker->boolean(),
            'note' => $this->faker->optional()->text(200),
        ];

        Role::create([
            'user_id' => $user->id,
            'name' => 'Instructeur',
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
        return $instructor;
    }
}
