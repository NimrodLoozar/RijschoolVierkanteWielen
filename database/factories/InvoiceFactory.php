<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Registration;

class InvoiceFactory extends Factory
{
    public function definition(): array
    {
        $amount = $this->faker->randomFloat(2, 50, 300);
        $vat = $amount * 0.21;

        return [
            'registration_id' => Registration::inRandomOrder()->first()->id ?? Registration::factory(),
            'invoice_number' => 'INV-' . $this->faker->unique()->numberBetween(2025000, 2025999),
            'invoice_date' => $this->faker->date(),
            'amount_excl_vat' => $amount,
            'vat' => $vat,
            'amount_incl_vat' => $amount + $vat,
            'status' => $this->faker->randomElement(['betaald', 'openstaand']),
            'is_active' => true,
            'note' => $this->faker->optional()->sentence(),
        ];
    }
}
