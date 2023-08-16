<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User_Service>
 */
class User_ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'=>rand(1,10),
            'description'=>fake()->sentence(),
            'founded_year'=>fake()->year(),
            'phone'=>fake()->phoneNumber(),
            'mail'=>fake()->safeEmail(),
            'service_name'=>fake()->sentence(),
        ];
    }
}
