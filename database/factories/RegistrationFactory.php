<?php


namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Student;

class RegistrationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'student_id' => Student::inRandomOrder()->first()->id ?? Student::factory(),
            'package_id' => \App\Models\Package::factory(),
            'start_date' => $this->faker->date(),
            'is_active' => true,
            'note' => $this->faker->optional()->sentence(),
        ];
    }
}
