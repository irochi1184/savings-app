<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])


    @include('layouts.styles')
</head>
<body class="font-sans antialiased bg-gray-100">
    @include('layouts.sidebar')
    @include('layouts.top-tabs')

    <div class="main-content" id="mainContent">
        @yield('content')
    </div>

    @include('layouts.sidebar-script')
    @yield('scripts')
</body>
</html>
