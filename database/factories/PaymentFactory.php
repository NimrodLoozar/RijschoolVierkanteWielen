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
    // If 'invoice_id' was provided (like in your seeder), use that, else pick random
    $invoiceId = $this->faker->randomElement(Invoice::pluck('id')->toArray());

    return [
        'invoice_id' => $this->invoice_id ?? $invoiceId,  // allow override
        'date' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
        'status' => $this->faker->randomElement(['betaald', 'openstaand']),
        'is_active' => 1,
    ];
}


}