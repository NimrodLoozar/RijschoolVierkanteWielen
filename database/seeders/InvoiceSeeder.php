<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Invoice;
use App\Models\Registration;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        // Create at least 2 registrations to attach invoices to
        $registrations = Registration::factory()->count(2)->create();

        // Manually create two specific invoices
        Invoice::create([
            'registration_id' => $registrations[0]->id,
            'invoice_number' => 'INV-2025001',
            'invoice_date' => '2025-01-10',
            'amount_excl_vat' => 100.00,
            'vat' => 21.00,
            'amount_incl_vat' => 121.00,
            'status' => 'openstaand',
            'is_active' => true,
            'note' => 'Factuur voor januari',
        ]);

        Invoice::create([
            'registration_id' => $registrations[1]->id,
            'invoice_number' => 'INV-2025002',
            'invoice_date' => '2025-02-10',
            'amount_excl_vat' => 200.00,
            'vat' => 42.00,
            'amount_incl_vat' => 242.00,
            'status' => 'betaald',
            'is_active' => true,
            'note' => 'Factuur voor februari',
        ]);

        // Create additional random invoices using the factory
        Invoice::factory()->count(8)->create();
    }
}
