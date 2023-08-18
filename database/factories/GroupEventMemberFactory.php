<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GroupEventMember>
 */
class GroupEventMemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'group_id' => rand(1, 5),
            'event_id' => rand(1, 3),
            'member_id' => rand(1, 10),
            'joined_at' => now(),
        ];
    }
}
