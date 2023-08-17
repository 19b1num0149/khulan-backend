<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group_member>
 */
class Group_memberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $group = Group::inRandomOrder()->first();
        $user = User::inRandomOrder()->first();
        return [
            'group_id' => $group -> id,
            'member_id'  =>$user->id ,
            'role_id' =>$user->role_id,
            'joined_at' => now(),
            'left_at' => now()
        ];
    }
}
