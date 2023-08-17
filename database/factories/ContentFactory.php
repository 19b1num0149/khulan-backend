<?php

namespace Database\Factories;

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
        return [
            'group_id'=>rand(1,5),
            'body'=>fake()->sentence(),
            'point'=>rand(1,5),
            'type'=>fake()->sentence(),
            'slug'=>fake()->sentence(),
        ];
    }
}
