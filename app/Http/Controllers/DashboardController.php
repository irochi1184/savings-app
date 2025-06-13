<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Expense;
use App\Models\Income;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 月別支出の合計
        $monthlyExpenses = Expense::where('user_id', $user->id)
            ->selectRaw("DATE_FORMAT(spent_at, '%Y-%m') as month, SUM(amount) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // 収支をまとめて取得（収入も「支出形式」に寄せる）
        $expenses = Expense::where('user_id', $user->id)
            ->select('spent_at as date', 'category', 'amount', 'note', DB::raw("'支出' as type"))
            ->get();

        $incomes = Income::where('user_id', $user->id)
            ->select('earned_at as date', 'category', 'amount', 'note', DB::raw("'収入' as type"))
            ->get();

        // 合体して日付でソート
        $transactions = $expenses->concat($incomes)->sortByDesc('date')->take(30);

        $userId = Auth::id();
        $currentYear = now()->year;
        $currentMonth = now()->month;

        // 選択年月によるカテゴリ別支出
        $availableYears = Expense::selectRaw('YEAR(spent_at) as year')
            ->where('user_id', Auth::id())
            ->distinct()
            ->pluck('year');

        return view('dashboard', compact(
            'monthlyExpenses', 
            'transactions',
            'availableYears',
            'currentYear',
            'currentMonth',
        ));
    }

    public function categorySummary(Request $request)
    {
        $year = $request->year;
        $month = $request->month;

        $userId = Auth::id();

        $expenses = Expense::where('user_id', $userId)
            ->whereYear('spent_at', $year)
            ->whereMonth('spent_at', $month)
            ->get();

        $categoryTotals = $expenses->groupBy('category')->map(function ($group) {
            return $group->sum('amount');
        });

        $totalAmount = $categoryTotals->sum();

        return response()->json([
            'labels' => $categoryTotals->keys()->values(),
            'data' => $categoryTotals->values(),
            'total' => $totalAmount
        ]);
    }
}
