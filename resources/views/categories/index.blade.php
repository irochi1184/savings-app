@extends('layouts.app')

@section('content')
<h2 class="text-xl font-semibold mb-4 text-center">カテゴリー設定</h2>

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

<!-- カテゴリ一覧 -->
<div class="grid grid-cols-3 sm:grid-cols-5 md:grid-cols-7 gap-4 mb-6">
    @foreach($categories as $category)
        <div class="border p-4 rounded text-center relative">
            <i class="fas {{ $category->icon }} text-2xl mb-2"></i>
            <div>{{ $category->name }}</div>
            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" 
                  class="absolute top-1 right-1"
                  onsubmit="return confirm('本当に「{{ $category->name }}」を削除してもよろしいですか？');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-800">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </div>
    @endforeach
</div>

<!-- 追加フォーム -->
<h3 class="text-lg font-semibold mb-2">カテゴリーを追加</h3>
<form method="POST" action="{{ route('categories.store') }}">
    @csrf
    <div class="mb-2">
        <input type="text" name="name" placeholder="カテゴリ名" required class="w-full border px-3 py-2 rounded">
    </div>

    <div class="mb-4">
        <label class="block mb-2">アイコンを選択</label>
        <div class="grid grid-cols-6 sm:grid-cols-9 md:grid-cols-12 gap-2 max-h-40 overflow-y-auto">
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
    </div>

    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded w-full">
        追加
    </button>
</form>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const iconOptions = document.querySelectorAll('input[name="icon"]');
        iconOptions.forEach(radio => {
            radio.addEventListener("change", () => {
                document.querySelectorAll(".icon-option").forEach(div => {
                    div.classList.remove("ring", "ring-blue-500");
                });
                radio.parentElement.querySelector("div").classList.add("ring", "ring-blue-500");
            });
        });
    });
</script>
@endsection
