<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Expense;
use App\Models\Income;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class SampleFinancialDataSeeder extends Seeder
{
    public function run(): void
    {
        // テスト用ユーザーの作成
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'テストユーザー',
                'password' => Hash::make('password'),
                'role' => 'host'
            ]
        );

        // 支出と収入のカテゴリ
        $expenseCategories = ['食費', '日用品', '交通費', '交際費', '趣味・娯楽'];
        $incomeCategories = ['給与', '副収入'];

        // 2025年1月〜5月までの日付でループ
        $start = Carbon::create(2025, 1, 1);
        $end = Carbon::create(2025, 5, 31);

        while ($start->lte($end)) {
            // 月に10件前後の支出・収入を生成
            for ($i = 0; $i < rand(8, 12); $i++) {
                // 支出
                Expense::create([
                    'user_id' => $user->id,
                    'amount' => rand(500, 10000),
                    'category' => $expenseCategories[array_rand($expenseCategories)],
                    'note' => '自動生成された支出',
                    'spent_at' => $start->copy()->addDays(rand(0, 27)),
                ]);

                // 収入（毎月1〜2件）
                if ($i < 2) {
                    Income::create([
                        'user_id' => $user->id,
                        'amount' => rand(10000, 300000),
                        'category' => $incomeCategories[array_rand($incomeCategories)],
                        'note' => '自動生成された収入',
                        'earned_at' => $start->copy()->addDays(rand(0, 27)),
                    ]);
                }
            }

            $start->addMonth();
        }
    }
}
