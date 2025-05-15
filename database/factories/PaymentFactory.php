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
        return [
            'invoice_id' => Invoice::inRandomOrder()->first()->id ?? 1, // picks random invoice id or fallback to 1
            'date' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'status' => $this->faker->randomElement(['betaald', 'openstaand']),
            'is_active' => 1,
            'note' => $this->faker->optional()->sentence(),
        ];
    }
}