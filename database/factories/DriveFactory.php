<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Drive>
 */
class DriveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'timestamp' => $this->faker->dateTimeBetween('-1 year'),
            'begin_odometer' => $this->faker->numberBetween(0, 50),
            'end_odometer' => $this->faker->numberBetween(50, 100),
        ];
    }
}
