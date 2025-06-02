<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserCategory;
use Illuminate\Support\Facades\Auth;

class UserCategoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
        ]);

        $userId = Auth::id();

        // 同じ名前のカテゴリが既に存在するか（削除済みは除く）
        $exists = UserCategory::where(function ($query) use ($userId) {
            $query->whereNull('user_id')
                ->orWhere('user_id', $userId);
        })
        ->where('is_deleted', false) // 追加
        ->where('name', $request->name)
        ->exists();

        if ($exists) {
            return redirect()->back()
                ->withErrors(['name' => '同じカテゴリ名が既に存在します。'])
                ->withInput();
        }

        // 並び順：そのユーザーが持つ「未削除の」カテゴリ数
        $count = UserCategory::where('user_id', $userId)
                    ->where('is_deleted', false)
                    ->count();

        UserCategory::create([
            'user_id'    => $userId,
            'name'       => $request->name,
            'icon'       => $request->icon,
            'sort_order' => $count,
            'is_deleted' => false, // 明示的に追加（念のため）
        ]);

        return redirect()->back()->with('success', 'カテゴリを追加しました。');
    }

    public function index()
    {
        $categories = UserCategory::where('user_id', Auth::id())
            ->where('is_deleted', false)
            ->orderBy('sort_order')
            ->get();

        return view('categories.index', compact('categories'));
    }

    public function destroy($id)
    {
        $category = UserCategory::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $category->update(['is_deleted' => true]);

        return redirect()->back()->with('success', 'カテゴリを削除しました。');
    }

}
