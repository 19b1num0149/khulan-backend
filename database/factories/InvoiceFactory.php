<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'=>rand(1,10),
            'group_id'=>rand(1,5),
            'activity_id'=>rand(1,3),
            'amount'=>rand(100,200),
            'generated_at'=>now(),
            'due_at'=>now(),
            'canceled_at'=>now(),
            'paid_at'=>now(),
            'point'=>rand(50,60),
        ];
    }
}
