<?php

namespace Database\Factories;

use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Content>
 */
class ContentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $group = Group::inRandomOrder()->first();

        return [
            'group_id' => $group -> id,
            'body' => fake() -> text(),
            'point' => fake() -> numberBetween(50-300),
            'type' => fake() -> text(10),
            'slug' => fake() -> text(10)
        ];
    }
}
