@extends('layouts.app')

@section('content')
<h2 class="text-xl font-semibold mb-4 text-center">収入・支出の記録</h2>
<div id="entryContainer" class="max-w-4xl mx-auto mt-8 bg-white rounded shadow p-6 transition-all duration-300">

<!-- トグル切替 -->
<div class="flex justify-center mb-6">
    <div class="inline-flex rounded-md shadow-sm border overflow-hidden" role="group">
        <button id="expenseBtn"
            class="toggle-btn px-6 py-2 text-sm font-medium bg-red-500 text-white border-r border-white">
            支出
        </button>
        <button id="incomeBtn"
            class="toggle-btn px-6 py-2 text-sm font-medium bg-gray-200 text-gray-600">
            収入
        </button>
    </div>
</div>


    <!-- 日付・金額 -->
    <div class="grid md:grid-cols-2 gap-4 mb-4">
        <!-- 日付 -->
        <div>
            <label class="block text-gray-700 mb-2">日付</label>
            <input type="date" class="w-full border rounded px-3 py-2" value="{{ now()->format('Y-m-d') }}">
        </div>

        <!-- 金額 -->
        <div>
            <label class="block text-gray-700 mb-2">金額</label>
            <input type="number" class="w-full border rounded px-3 py-2" placeholder="例：5000">
        </div>
    </div>

    <!-- カテゴリ -->
    <div class="mb-4">
        <label class="block text-gray-700 mb-2">カテゴリ</label>
        <div class="grid grid-cols-3 sm:grid-cols-5 md:grid-cols-7 gap-3">
            @php
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
            @endphp
            @foreach($categories as $cat)
                <button type="button"
                    class="flex flex-col items-center justify-center p-4 border border-gray-400 rounded hover:bg-gray-100 transition text-sm text-gray-700">
                    <i class="fas {{ $cat['icon'] }} text-xl mb-1"></i>
                    <span>{{ $cat['name'] }}</span>
                </button>
            @endforeach

        </div>
    </div>

    <!-- メモ -->
    <div class="mb-4">
        <label class="block text-gray-700 mb-2">メモ（任意）</label>
        <input type="text" class="w-full border rounded px-3 py-2" placeholder="メモを入力">
    </div>

    <!-- 登録ボタン -->
    <div class="text-right">
        <button class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded">
            登録
        </button>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const container = document.getElementById("entryContainer");
        const incomeBtn = document.getElementById("incomeBtn");
        const expenseBtn = document.getElementById("expenseBtn");

        function setMode(mode) {
            if (mode === "income") {
                container.style.backgroundColor = "#4bb9ae25";  // 青緑系（淡い）

                incomeBtn.classList.add("bg-teal-500", "text-white");
                incomeBtn.classList.remove("bg-gray-200", "text-gray-600");

                expenseBtn.classList.remove("bg-red-500", "text-white");
                expenseBtn.classList.add("bg-gray-200", "text-gray-600");
            } else {
                container.style.backgroundColor = "#e9c9d073";  // 赤系（淡い）

                expenseBtn.classList.add("bg-red-500", "text-white");
                expenseBtn.classList.remove("bg-gray-200", "text-gray-600");

                incomeBtn.classList.remove("bg-teal-500", "text-white");
                incomeBtn.classList.add("bg-gray-200", "text-gray-600");
            }
        }

        incomeBtn.addEventListener("click", () => setMode("income"));
        expenseBtn.addEventListener("click", () => setMode("expense"));

        // 初期モード（支出）
        setMode("expense");
    });
</script>
@endsection

