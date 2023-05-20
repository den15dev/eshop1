<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reaction>
 */
class ReactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date_time = fake()->dateTimeBetween('-3 month');

        return [
            'review_id' => fake()->randomElement([23, 24]),
            'user_id' => fake()->numberBetween(1, 3),
            'up_down' => fake()->randomElement([0, 1]),
            'created_at' => $date_time,
            'updated_at' => $date_time,
        ];
    }
}
