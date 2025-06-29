<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Expense;
use App\Models\Income;
use App\Models\UserCategory;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class SampleFinancialDataSeeder extends Seeder
{
    public function run(): void
    {
        // テストユーザー作成
        $user = User::firstOrCreate(
            ['email' => 'ken.office.arita@gmail.com'],
            [
                'name' => 'ありけん',
                'password' => Hash::make('password'),
                'role' => 'host'
            ]
        );

        // 支出カテゴリをUserCategoryに登録（必要なら一度だけ）
        $expenseCategories = [
            ['name' => '食費',   'icon' => 'fa-utensils'],
            ['name' => '日用品', 'icon' => 'fa-soap'],
            ['name' => '交通費', 'icon' => 'fa-bus'],
            ['name' => '光熱費', 'icon' => 'fa-bolt'],
            ['name' => '家賃',   'icon' => 'fa-home'],
            ['name' => '通信費', 'icon' => 'fa-wifi'],
        ];

        foreach ($expenseCategories as $i => $cat) {
            UserCategory::firstOrCreate([
                'user_id' => $user->id,
                'name' => $cat['name']
            ], [
                'icon' => $cat['icon'],
                'sort_order' => $i + 1,
                'is_deleted' => false,
            ]);
        }

        $incomeCategories = ['給与', '副収入'];

        // 日付範囲：2025年1月〜5月
        $start = Carbon::create(2024, 1, 1);
        $end = Carbon::create(2025, 5, 31);

        // カテゴリ名リストを取得
        $expenseCategoryNames = UserCategory::where('user_id', $user->id)->pluck('name')->toArray();

        while ($start->lte($end)) {
            for ($i = 0; $i < rand(8, 12); $i++) {
                // 支出作成
                Expense::create([
                    'user_id' => $user->id,
                    'amount' => rand(500, 150000),
                    'category' => $expenseCategoryNames[array_rand($expenseCategoryNames)],
                    'note' => '自動生成された支出',
                    'spent_at' => $start->copy()->addDays(rand(0, 27)),
                ]);

                // 収入作成（少なめ）
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
