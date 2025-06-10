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
        $currentMonth = now()->format('Y-m');

        // カテゴリ別支出合計（今月のみ）
        $categoryExpenses = Expense::select('category', DB::raw('SUM(amount) as total'))
            ->where('user_id', $userId)
            ->where('spent_at', 'like', $currentMonth . '%')
            ->groupBy('category')
            ->pluck('total', 'category');

        return view('dashboard', compact('categoryExpenses', 'monthlyExpenses', 'transactions'));
    }
}
