<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 random payments via factory
        Payment::factory()->count(10)->create();

        // Add a few manual payments for specific data
        Payment::create([
            'invoice_id' => 1,
            'date' => '2025-01-15',
            'status' => 'betaald',
            'is_active' => 1,
            'note' => 'Betaling via iDEAL',
        ]);

        Payment::create([
            'invoice_id' => 2,
            'date' => '2025-02-20',
            'status' => 'openstaand',
            'is_active' => 1,
            'note' => 'Openstaande betaling, herinnering gestuurd',
        ]);
    }
}
