<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use App\Models\Instructor;
use App\Models\Registration;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\PackageSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a test user (student)
        $testUser = User::factory()->create([
            'first_name' => 'Test',
            'middle_name' => null,
            'last_name' => 'User',
            'username' => 'Testuser',
            'birth_date' => '1990-01-01',
            'password' => bcrypt('Test1234'),
        ]);

        DB::table('contacts')->insert([
            'email' => 'test@example.com',
            'user_id' => $testUser->id,
            'street' => 'Example Street',
            'house_number' => '123',
            'addition' => null,
            'postal_code' => '1234AB',
            'city' => 'Example City',
            'mobile' => '0612345678',
            'is_active' => true,
            'note' => 'Test user contact details',
        ]);

        DB::table('roles')->insert([
            'user_id' => $testUser->id,
            'name' => 'Leerling',
            'is_active' => true,
            'note' => 'Test user role details',
        ]);

        DB::table('students')->insert([
            'user_id' => $testUser->id,
            'relation_number' => 'RN123456',
            'is_active' => true,
            'note' => 'Test student details',
        ]);

        // Create an admin user
        $adminUser = User::factory()->create([
            'first_name' => 'Admin',
            'middle_name' => null,
            'last_name' => 'User',
            'username' => 'Adminuser',
            'birth_date' => '1985-01-01',
            'password' => bcrypt('Admin1234'),
        ]);

        DB::table('contacts')->insert([
            'email' => 'admin@example.com',
            'user_id' => $adminUser->id,
            'street' => 'Admin Street',
            'house_number' => '456',
            'addition' => null,
            'postal_code' => '5678CD',
            'city' => 'Admin City',
            'mobile' => '0698765432',
            'is_active' => true,
            'note' => 'Admin user contact details',
        ]);

        DB::table('roles')->insert([
            'user_id' => $adminUser->id,
            'name' => 'Admin',
            'is_active' => true,
            'note' => 'Admin user role details',
        ]);

        // Create users
        User::factory(20)->create();

        // Create students first
        $students = Student::factory(10)->create();

        // Ensure packages exist for registrations
        $this->ensurePackagesExist();

        // Create registrations for existing students
        $registrations = [];
        foreach ($students as $student) {
            // Create 1-3 registrations for each student
            $count = rand(1, 3);
            for ($i = 0; $i < $count; $i++) {
                $registrations[] = Registration::factory()->create([
                    'student_id' => $student->id,
                ]);
            }
        }

        // Create invoices for some registrations
        $invoices = [];
        foreach ($registrations as $registration) {
            // 80% chance of creating an invoice for this registration
            if (rand(1, 100) <= 80) {
                $invoices[] = Invoice::factory()->create([
                    'registration_id' => $registration->id,
                ]);
            }
        }

        // Create additional invoices if we have less than 20
        while (count($invoices) < 20) {
            $invoices[] = Invoice::factory()->create();
        }

        // Create instructors
        Instructor::factory(5)->create();
    }

    /**
     * Ensure packages exist in the database.
     */
    private function ensurePackagesExist(): void
    {
        /*
        // Check if packages already exist
        if (DB::table('packages')->count() === 0) {
            // Create default packages with the columns that exist in the packages table
            DB::table('packages')->insert([
                [
                    'type' => 'package1',
                    'lesson_count' => 20,
                    'price_per_lesson' => 59.75, // 1195 ÷ 20 = 59.75
                    'is_active' => true,
                    'note' => 'Standaardpakket (20 rijlessen + CBR examen)',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'type' => 'package2',
                    'lesson_count' => 30,
                    'price_per_lesson' => 59.83, // 1795 ÷ 30 = 59.83
                    'is_active' => true,
                    'note' => 'Premiumpakket (30 rijlessen + CBR examen + 1 herexamen)',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'type' => 'package3',
                    'lesson_count' => 15,
                    'price_per_lesson' => 93.00, // 1395 ÷ 15 = 93.00
                    'is_active' => true,
                    'note' => 'Spoedpakket (15 rijlessen intensief + CBR examen)',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'type' => 'package1',
                    'lesson_count' => 1,
                    'price_per_lesson' => 55.00,
                    'is_active' => true,
                    'note' => 'Losse rijles (60 minuten)',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'type' => 'package1',
                    'lesson_count' => 5,
                    'price_per_lesson' => 99.00, // 495 ÷ 5 = 99.00
                    'is_active' => true,
                    'note' => 'Examentraining (5 rijlessen + CBR examen)',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
        */

        $this->call(AutoSeeder::class);
        $this->call(PackageSeeder::class);
    }
}
