<?php


namespace Database\Factories;

use App\Models\Student;
use App\Models\Package;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use App\Models\Student;

class RegistrationFactory extends Factory
{
    public function definition(): array
    {
        $registrationDate = $this->faker->dateTimeBetween('-1 year', 'now');
        
        // Get package IDs from the database if available 
        $packageIds = DB::table('packages')->pluck('id')->toArray();
        $packageId = !empty($packageIds) ? $this->faker->randomElement($packageIds) : 1;
        
        // If no packages exist, create default packages first
        if (empty($packageIds)) {
            $this->ensureFallbackPackageExists();
            $packageId = 1;
        }
        
        return [
            'student_id' => Student::factory(),
            'package_id' => $packageId,
            'start_date' => $registrationDate, // Add the start_date field
            'end_date' => $this->faker->optional(70)->dateTimeBetween($registrationDate, '+1 year'), // Optional end_date
            'is_active' => $this->faker->boolean(80),
            'note' => $this->faker->optional(30)->sentence(),
            'created_at' => $registrationDate,
            'updated_at' => $registrationDate,
        ];
    }
    
    /**
     * Create a fallback package if none exist.
     */
    private function ensureFallbackPackageExists(): void
    {
        // Insert a basic package with correct column names
        DB::table('packages')->insert([
            'type' => 'package1',
            'lesson_count' => 20,
            'price_per_lesson' => 59.75,
            'is_active' => true,
            'note' => 'Standaardpakket',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
    
    /**
     * Configure the model factory to use existing students instead of creating new ones.
     *
     * @param int $studentId The ID of an existing student
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function forStudent(int $studentId)
    {
        return $this->state(function (array $attributes) use ($studentId) {
            return [
                'student_id' => $studentId,
            ];
        });
    }
}
