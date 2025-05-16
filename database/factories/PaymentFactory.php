<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Payment;
use App\Models\Invoice;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

public function definition()
{
    $invoice = Invoice::inRandomOrder()->first();

    if (!$invoice) {
        throw new \Exception('No invoices found. Seed invoices before seeding payments.');
    }

    return [
        'invoice_id' => $invoice->id,
        'date' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
        'status' => $this->faker->randomElement(['betaald', 'openstaand']),
        'is_active' => 1
    ];
}

}