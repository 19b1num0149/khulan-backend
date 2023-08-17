<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group>
 */
class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userid = User::inRandomOrder()->first();

        return [
            'name' => fake()->name(),
            'founded_year' => '2022',
            'description' => Str::random(10),
            'user_id' => $userid->id,
            'qr_data' => 'null',
        ];
    }
}
