<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;

class RecordController extends Controller
{
    public function create()
    {
        $categories = [
            ['name' => '食費', 'icon' => 'fa-utensils'],
            ['name' => '日用品', 'icon' => 'fa-soap'],
            ['name' => '交通費', 'icon' => 'fa-bus'],
            ['name' => '交際費', 'icon' => 'fa-user-friends'],
            ['name' => '光熱費', 'icon' => 'fa-bolt'],
            ['name' => '家賃', 'icon' => 'fa-home'],
            ['name' => '収入', 'icon' => 'fa-coins'],
            ['name' => '追加', 'icon' => 'fa-plus'],
        ];
        return view('income_expense.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:1',
            'category' => 'required|string|max:255',
            'note' => 'nullable|string|max:255',
            'date' => 'required|date',
        ]);

        if ($request->type === 'income') {
            Income::create([
                'user_id' => Auth::id(),
                'amount' => $request->amount,
                'category' => $request->category,
                'note' => $request->note,
                'earned_at' => $request->date,
            ]);
        } else {
            Expense::create([
                'user_id' => Auth::id(),
                'amount' => $request->amount,
                'category' => $request->category,
                'note' => $request->note,
                'spent_at' => $request->date,
            ]);
        }

        return redirect()->back()->with('success', '記録が保存されました');
    }
}
