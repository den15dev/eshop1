<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
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
            'user_id' => User::all('id')->random()->id,
            'term' => fake()->randomElement(['days', 'weeks', 'months']),
            'mark' => fake()->numberBetween(1, 5),
            'pros' => fake('ru_RU')->realText(400),
            'cons' => fake('ru_RU')->realText(400),
            'comnt' => fake('ru_RU')->realText(400),
            'created_at' => $date_time,
            'updated_at' => $date_time,
        ];
    }
}
