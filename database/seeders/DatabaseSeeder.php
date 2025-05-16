<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use App\Models\Instructor;
use App\Models\Registration;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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

        // Seed students and instructors
        $students = Student::factory(10)->create();
        Instructor::factory(10)->create();

        // Seed registrations for students
        $students->each(function ($student) {
            Registration::factory()->create([
                'student_id' => $student->id,
                'start_date' => now(),
                'is_active' => true,
            ]);
        });

        // Now that registrations exist, seed invoices
        $registrations = Registration::all();
        $registrations->each(function ($registration, $index) {
            Invoice::factory()->create([
                'registration_id' => $registration->id,
                'invoice_number' => 'INV-2025' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
            ]);
        });

        // Finally, seed payments for the invoices
        $invoices = Invoice::all();
        $invoices->each(function ($invoice) {
            Payment::factory()->create([
                'invoice_id' => $invoice->id,
            ]);
        });
    }
}
