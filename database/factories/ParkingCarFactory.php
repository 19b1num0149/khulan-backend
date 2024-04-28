<?php

namespace Database\Factories;

use App\Models\ParkingCar;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParkingCarFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ParkingCar::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 10), // Example user ID
            'parking_id' => $this->faker->numberBetween(1, 10), // Example parking ID
            'car_number' => $this->faker->regexify('[A-Z0-9]{7}'), // Generate a random car number
            'parked_at' => $this->faker->dateTimeBetween('-1 week', 'now'), // Random parked_at timestamp
            'moved_at' => $this->faker->optional()->dateTimeBetween('-1 week', 'now'), // Random moved_at timestamp or null
            'ordered_at' => $this->faker->optional()->dateTimeBetween('-1 week', 'now'), // Random ordered_at timestamp or null
            'order_cancelled_at' => $this->faker->optional()->dateTimeBetween('-1 week', 'now'), // Random order_cancelled_at timestamp or null
            'paid_at' => $this->faker->optional()->dateTimeBetween('-1 week', 'now'), // Random paid_at timestamp or null
            'is_active' => $this->faker->boolean(), // Random boolean value
        ];
    }
}
