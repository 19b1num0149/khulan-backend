<?php

namespace Database\Factories;

use App\Models\Group_event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group_event_itineraries>
 */
class Group_event_itinerariesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $event = Group_event::inRandomOrder()->first();
        return [
            'event_id' => $event -> id,
            'description' => fake() -> text(20),
            'title' => fake() -> name()
        ];
    }
}
