<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group_Event_Itinenary>
 */
class Group_Event_ItinenaryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_id' => rand(1, 5),
            'description' => fake()->sentence(),
            'title' => fake()->sentence(),
        ];
    }
}
