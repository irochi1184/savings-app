<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        \App\Models\Group::factory(3)->create()->each(function ($group) {
            \App\Models\User::factory(3)->create([
                'group_id' => $group->id,
                'role' => 'guest',
            ])->each(function ($user) use ($group) {
                \App\Models\Expense::factory(10)->create([
                    'user_id' => $user->id,
                    'group_id' => $group->id,
                ]);

                \App\Models\Income::factory(5)->create([
                    'user_id' => $user->id,
                    'group_id' => $group->id,
                ]);
            });
        });
    }
}
