<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\DB;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $testUser = User::factory()->create([
            'first_name' => 'Test',
            'middle_name' => NULL,
            'last_name' => 'User',
            'username' => 'Testuser',
            'birth_date' => '1990-01-01',
            'password' => bcrypt('Test1234'), // password
        ]);

        DB::table('contacts')->insert([
            'email' => 'test@example.com',
            'user_id' => $testUser->id,
            'street' => 'Example Street',
            'house_number' => '123',
            'addition' => NULL,
            'postal_code' => '1234AB',
            'city' => 'Example City',
            'mobile' => '0612345678',
            'is_active' => true,
            'note' => 'Test user contact details',
        ]);

        $adminUser = User::factory()->create([
            'first_name' => 'Admin',
            'middle_name' => NULL,
            'last_name' => 'User',
            'username' => 'Adminuser',
            'birth_date' => '1985-01-01',
            'password' => bcrypt('Admin1234'), // password
        ]);

        DB::table('contacts')->insert([
            'email' => 'admin@example.com',
            'user_id' => $adminUser->id,
            'street' => 'Admin Street',
            'house_number' => '456',
            'addition' => NULL,
            'postal_code' => '5678CD',
            'city' => 'Admin City',
            'mobile' => '0698765432',
            'is_active' => true,
            'note' => 'Admin user contact details',
        ]);
    }
}
