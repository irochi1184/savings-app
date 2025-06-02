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

    <div id="entryContainer" class="max-w-4xl mx-auto mt-8 bg-white rounded shadow p-6 transition-all duration-300">

        <!-- トグル切替 -->
        <input type="hidden" name="type" id="recordType" value="{{ old('type', 'expense') }}">
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
                @php
                    $userId = auth()->id();

                    $categories = \App\Models\UserCategory::where('is_deleted', false)
                        ->where('user_id', $userId)
                        ->orderBy('sort_order')
                        ->get();
                @endphp

                @foreach($categories as $cat)
                    <button type="button"
                        class="category-btn flex flex-col items-center justify-center p-4 border border-gray-400 rounded hover:bg-gray-100 text-sm text-gray-700 {{ old('category') === $cat->name ? 'bg-gray-200' : '' }}"
                        data-category="{{ $cat->name }}">
                        <i class="fas {{ $cat->icon }} text-xl mb-1"></i>
                        <span>{{ $cat->name }}</span>
                    </button>
                @endforeach

                <button type="button" onclick="document.getElementById('addCategoryModal').showModal();" class="flex flex-col items-center justify-center p-4 border border-gray-400 rounded hover:bg-gray-100 text-sm text-gray-700">
                    <i class="fas fa-plus text-xl mb-1"></i>
                    <span>追加</span>
                </button>
            </div>
            <input type="hidden" name="category" id="selectedCategory" value="{{ old('category') }}">
            @error('category')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">メモ（任意）</label>
            <input type="text" name="note" class="w-full border rounded px-3 py-2" placeholder="メモを入力" value="{{ old('note') }}">
            @error('note')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="text-right">
            <button class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded">
                登録
            </button>
        </div>
    </div>
</form>
<dialog id="addCategoryModal" class="rounded p-4 border w-96 bg-white shadow-md">
    <form method="POST" action="{{ route('categories.store') }}">
        @csrf
        <label class="block mb-2">カテゴリ名</label>
        <input type="text" name="name" required class="border w-full mb-2 rounded px-2 py-1">

        <label class="block mb-2">アイコンを選択</label>
        <div class="grid grid-cols-6 gap-2 max-h-40 overflow-y-auto mb-4">
            @php
                $icons = [
                    'fa-utensils','fa-soap','fa-bus','fa-bolt','fa-home','fa-wifi','fa-gamepad','fa-coins','fa-briefcase','fa-hand-holding-usd','fa-gift','fa-car','fa-heart',
                    'fa-dog','fa-tshirt','fa-book','fa-notes-medical','fa-mug-hot',
                    'fa-apple-alt','fa-shopping-cart','fa-tv','fa-tooth','fa-baby','fa-hamburger',
                    'fa-biking','fa-chair','fa-fish','fa-leaf','fa-camera','fa-tree','fa-money-bill','fa-couch',
                    'fa-plane','fa-subway','fa-mobile-alt','fa-plug','fa-capsules','fa-paint-roller','fa-seedling',
                    'fa-laptop','fa-glass-cheers','fa-clipboard-list','fa-calendar-alt','fa-flag','fa-shower',
                    'fa-paw','fa-socks','fa-umbrella','fa-mountain','fa-bed','fa-balance-scale'
                ];
            @endphp
            @foreach($icons as $icon)
                <label class="cursor-pointer">
                    <input type="radio" name="icon" value="{{ $icon }}" class="hidden">
                    <div class="p-2 border rounded text-center hover:bg-gray-100 icon-option">
                        <i class="fas {{ $icon }}"></i>
                    </div>
                </label>
            @endforeach
        </div>

        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded w-full">
            追加
        </button>
    </form>
</dialog>
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

                incomeBtn.classList.remove("bg-gray-300");
                incomeBtn.classList.add("bg-teal-500", "text-white");
                expenseBtn.classList.remove("bg-red-400");
                expenseBtn.classList.add("bg-gray-300", "text-gray-700");
            } else {
                container.style.backgroundColor = "#e9c9d073";
                typeInput.value = "expense";

                expenseBtn.classList.remove("bg-gray-300");
                expenseBtn.classList.add("bg-red-400", "text-white");
                incomeBtn.classList.remove("bg-teal-500");
                incomeBtn.classList.add("bg-gray-300", "text-gray-700");
            }
        }

        incomeBtn.addEventListener("click", () => setMode("income"));
        expenseBtn.addEventListener("click", () => setMode("expense"));

        setMode("{{ old('type', 'expense') }}");

        const categoryButtons = document.querySelectorAll(".category-btn");
        const selectedCategoryInput = document.getElementById("selectedCategory");
        categoryButtons.forEach(btn => {
            btn.addEventListener("click", () => {
                categoryButtons.forEach(b => b.classList.remove("bg-gray-200"));
                btn.classList.add("bg-gray-200");
                selectedCategoryInput.value = btn.dataset.category;
            });
        });

        const modal = document.getElementById('addCategoryModal');
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.close();
            }
        });

        const iconOptions = document.querySelectorAll('input[name="icon"]');
        iconOptions.forEach(radio => {
            radio.addEventListener("change", () => {
                document.querySelectorAll(".icon-option").forEach(div => {
                    div.classList.remove("selected");
                });
                radio.parentElement.querySelector("div").classList.add("selected");
            });
        });
    });
</script>
@endsection