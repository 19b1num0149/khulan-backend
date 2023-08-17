<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\Interest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group_interest>
 */
class Group_interestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $group = Group::inRandomOrder()->first();
        $interest = Interest::inRandomOrder()->first();
        return [
            'group_id' => $group -> id,
            'interest_id' => $interest -> id
        ];
    }
}
