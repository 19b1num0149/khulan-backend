<?php

namespace Database\Factories;

use App\Models\Content;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $content = Content::inRandomOrder()->first();
        return [
            'short_text'=> $content -> body,
            'content_id' => $content -> id,
            'read_at' => fake() -> date()
        ];
    }
}
