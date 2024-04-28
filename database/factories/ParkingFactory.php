<?php

namespace Database\Factories;

use App\Models\Parking;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class ParkingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word,
            'payment_per_hour' => $this->faker->numberBetween(5, 20),
            'capacity' => $this->faker->numberBetween(50, 200),
            'lan' => $this->faker->latitude(),
            'lon' => $this->faker->longitude(),
            'opening_time' => Carbon::parse('08:00:00'), // Example opening time
            'closing_time' => Carbon::parse('20:00:00'), // Example closing time

        ];
    }
}
