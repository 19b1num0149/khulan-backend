<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group_Member_Coupon>
 */
class Group_Member_CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'member_id'=>rand(1,10),
            'group_id'=>rand(1,5),
            'description'=>fake()->sentence(),
        ];
    }
}
