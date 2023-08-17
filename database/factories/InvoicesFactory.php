<?php

namespace Database\Factories;

use App\Models\Activities;
use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoices>
 */
class InvoicesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::inRandomOrder()->first();
        $group = Group::inRandomOrder()->first();
        $activity = Activities::inRandomOrder()->first();

        return [
            'user_id' => $user->id,
            'group_id' => $group->id,
            'activity_id' => $activity->id,
            'amount' => fake()->numberBetween(1 - 999999),
            'generated_at' => fake()->date(),
            'due_at' => fake()->date(),
            'canceled_at' => fake()->date(),
            'paid_at' => fake()->date(),
            'point' => fake()->numberBetween(50 - 300),
        ];
    }
}
