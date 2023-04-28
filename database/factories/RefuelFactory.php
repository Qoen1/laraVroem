<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Refuel>
 */
class RefuelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'liters' => $this->faker->numberBetween(10, 100),
            'cost' => $this->faker->numberBetween(10, 100)
        ];
    }
}
