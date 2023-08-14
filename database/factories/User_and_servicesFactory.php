<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User_and_services>
 */
class User_and_servicesFactory extends Factory
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
            'description' => Str::random(10),
            'founded_year' => '2022',
            'service_name' => fake()->name(),
            'user_id' => $user->id,
            'phone' => $user->phone,
            'mail' => $user->email
        ];
    }
}
