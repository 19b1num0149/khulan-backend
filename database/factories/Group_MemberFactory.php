<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group_Member>
 */
class Group_MemberFactory extends Factory
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
            'member_id' => rand(1, 10),
            'role_id' => rand(1, 3),
            'joined_at' => now(),
            'left_at' => now(),
        ];
    }
}
