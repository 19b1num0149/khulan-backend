<?php

namespace Database\Factories;

use App\Models\Group_member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group_member_coupon>
 */
class Group_member_couponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = Group_member::inRandomOrder()->first();
        return [
            'member_id'=> $user -> member_id,
            'group_id' => $user -> group_id,
            'description' => fake() -> text(20)
        ];
    }
}
