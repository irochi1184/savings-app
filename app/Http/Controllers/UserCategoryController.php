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
            'color' => 'required'
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
            'color'      => $request->color,
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

        $icons = [
            'fa-utensils','fa-soap','fa-bus','fa-bolt','fa-home','fa-wifi','fa-gamepad','fa-coins','fa-briefcase','fa-hand-holding-usd','fa-gift','fa-car','fa-heart',
            'fa-dog','fa-tshirt','fa-book','fa-notes-medical','fa-mug-hot',
            'fa-apple-alt','fa-shopping-cart','fa-tv','fa-tooth','fa-baby','fa-hamburger',
            'fa-biking','fa-chair','fa-fish','fa-leaf','fa-camera','fa-tree','fa-money-bill','fa-couch',
            'fa-plane','fa-subway','fa-mobile-alt','fa-plug','fa-capsules','fa-paint-roller','fa-seedling',
            'fa-laptop','fa-glass-cheers','fa-clipboard-list','fa-calendar-alt','fa-flag','fa-shower',
            'fa-paw','fa-socks','fa-umbrella','fa-mountain','fa-bed','fa-balance-scale'
        ];

        $pastelColors = [
            '#FFB3BA', '#FFDFBA', '#FFFFBA', '#BAFFC9', '#BAE1FF',
            '#E6E6FA', '#FFFACD', '#D8BFD8', '#E0FFFF', '#F0FFF0',
            '#FFDAB9', '#FFE4E1', '#F5DEB3', '#FFF0F5', '#FFCCFF',
            '#CCFFCC', '#FFFFCC', '#CCCCFF', '#CCFFFF', '#FFCCE5',
            '#CCFFEB', '#FAFAD2', '#F0F8FF', '#F5F5DC', '#F8F8FF',
            '#FFEFD5', '#F0E68C', '#FFDEAD', '#E9967A', '#87CEFA',
            '#AFEEEE', '#DDA0DD', '#F5FFFA', '#FFE4B5', '#FAF0E6',
            '#FFF5EE', '#E0EEE0', '#FFF8DC', '#EEE8AA', '#EED5B7',
            '#B0E0E6', '#D3FFCE', '#F4A460', '#FFB6C1', '#FFA07A',
            '#20B2AA', '#87CEEB', '#FFC0CB'
        ];

        return view('categories.index', compact('categories', 'icons', 'pastelColors'));
    }

    public function destroy($id)
    {
        $category = UserCategory::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $category->update(['is_deleted' => true]);

        return redirect()->back()->with('success', 'カテゴリを削除しました。');
    }

}
