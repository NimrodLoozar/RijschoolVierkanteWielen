<?php

namespace Database\Factories;

use App\Models\Registration;
use App\Models\User;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Registration;

class InvoiceFactory extends Factory
{
    public function definition(): array
    {
        $invoiceDate = $this->faker->dateTimeBetween('-6 months', 'now');
        
        $amountExclVat = $this->faker->randomFloat(2, 50, 1000);
        $vatRate = 0.21; // 21% VAT
        $vat = $amountExclVat * $vatRate;
        $amountInclVat = $amountExclVat + $vat;
        
        $isPaid = $this->faker->boolean(70); // 70% chance the invoice is paid
        
        return [
            'registration_id' => Registration::factory(),
            'invoice_number' => 'INV-' . $this->faker->unique()->numerify('######'),
            'invoice_date' => $invoiceDate,
            'amount_excl_vat' => $amountExclVat,
            'vat' => $vat,
            'amount_incl_vat' => $amountInclVat,
            'status' => $isPaid ? 'betaald' : 'onbetaald',
            'is_active' => true,
            'note' => $this->faker->optional(30)->sentence(),
            'created_at' => $invoiceDate,
            'updated_at' => $invoiceDate,
        ];
    }
    
    /**
     * Indicate that the invoice is paid.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function paid()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'betaald',
            ];
        });
    }
    
    /**
     * Geeft aan dat de factuur onbetaald is.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function onbetaald()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'onbetaald',
            ];
        });
    }
}
