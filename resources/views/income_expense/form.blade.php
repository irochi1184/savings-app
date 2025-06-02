@extends('layouts.app')

@section('content')
<h2 class="text-xl font-semibold mb-4 text-center">収入・支出の記録</h2>

@if(session('success'))
    <div class="mb-4 text-green-600 font-semibold">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
        <ul class="list-disc pl-5 space-y-1 text-sm">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('record.store') }}">
    @csrf

    <input type="hidden" name="type" id="recordType" value="expense">

    <div id="entryContainer" class="max-w-4xl mx-auto mt-8 bg-white rounded shadow p-6 transition-all duration-300">

        <!-- トグル切替 -->
        <div class="flex justify-center mb-6">
            <div class="inline-flex rounded-md shadow-sm border overflow-hidden" role="group">
                <button type="button" id="expenseBtn"
                    class="toggle-btn px-6 py-2 text-sm font-medium text-white bg-red-400 hover:bg-red-500 border-r border-white">
                    支出
                </button>
                <button type="button" id="incomeBtn"
                    class="toggle-btn px-6 py-2 text-sm font-medium text-white bg-teal-500 hover:bg-teal-600">
                    収入
                </button>
            </div>
        </div>

        <!-- 日付 -->
        <div>
            <label class="block text-gray-700 mb-2">日付</label>
            <input type="date" name="date" class="w-full border rounded px-3 py-2" value="{{ old('date', now()->format('Y-m-d')) }}">
            @error('date')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- 金額 -->
        <div>
            <label class="block text-gray-700 mb-2">金額</label>
            <input type="number" name="amount" class="w-full border rounded px-3 py-2" placeholder="例：5000" value="{{ old('amount') }}">
            @error('amount')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- カテゴリ -->
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">カテゴリ</label>
            <div class="grid grid-cols-3 sm:grid-cols-5 md:grid-cols-7 gap-3">
                @foreach($categories as $cat)
                    <button type="button"
                        class="category-btn flex flex-col items-center justify-center p-4 border border-gray-400 rounded hover:bg-gray-100 text-sm text-gray-700 {{ old('category') === $cat['name'] ? 'bg-gray-200' : '' }}"
                        data-category="{{ $cat['name'] }}">
                        <i class="fas {{ $cat['icon'] }} text-xl mb-1"></i>
                        <span>{{ $cat['name'] }}</span>
                    </button>
                @endforeach
            </div>
            <input type="hidden" name="category" id="selectedCategory" value="{{ old('category') }}">
            @error('category')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- メモ -->
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">メモ（任意）</label>
            <input type="text" name="note" class="w-full border rounded px-3 py-2" placeholder="メモを入力" value="{{ old('note') }}">
            @error('note')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- 登録ボタン -->
        <div class="text-right">
            <button class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded">
                登録
            </button>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const container = document.getElementById("entryContainer");
        const incomeBtn = document.getElementById("incomeBtn");
        const expenseBtn = document.getElementById("expenseBtn");
        const typeInput = document.getElementById("recordType");

        function setMode(mode) {
            if (mode === "income") {
                container.style.backgroundColor = "#4bb9ae25";
                typeInput.value = "income";
            } else {
                container.style.backgroundColor = "#e9c9d073";
                typeInput.value = "expense";
            }
        }

        incomeBtn.addEventListener("click", () => setMode("income"));
        expenseBtn.addEventListener("click", () => setMode("expense"));
        setMode("expense");

        // カテゴリ選択
        const categoryButtons = document.querySelectorAll(".category-btn");
        const selectedCategoryInput = document.getElementById("selectedCategory");
        categoryButtons.forEach(btn => {
            btn.addEventListener("click", () => {
                categoryButtons.forEach(b => b.classList.remove("bg-gray-200"));
                btn.classList.add("bg-gray-200");
                selectedCategoryInput.value = btn.dataset.category;
            });
        });
    });
</script>
@endsection
