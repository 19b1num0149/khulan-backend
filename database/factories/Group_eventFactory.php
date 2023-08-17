<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group_event>
 */
class Group_eventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::inRandomOrder()->first();
        return [
            'name'=> fake()-> name(),
            "desc"=>fake() -> text(20),
            'date'=>fake()-> date(),
            'creator_id'=> $user->id,
            'location'=> fake()->address()
        ];
    }
}
