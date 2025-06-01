<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
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
            'amount' => $this->faker->numberBetween(100, 5000),
            'category' => $this->faker->randomElement(['食費', '交通費', '日用品', '交際費']),
            'note' => $this->faker->optional()->sentence,
            'spent_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
        ];
    }
}
