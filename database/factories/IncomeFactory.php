<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Income>
 */
class IncomeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::inRandomOrder()->first()?->id,
            'group_id' => \App\Models\Group::inRandomOrder()->first()?->id,
            'amount' => $this->faker->numberBetween(5000, 100000),
            'category' => $this->faker->randomElement(['給与', '副業', 'お小遣い']),
            'note' => $this->faker->optional()->sentence,
            'earned_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
        ];
    }
}
