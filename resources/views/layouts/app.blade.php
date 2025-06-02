<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            margin: 0;
        }

        .sidebar {
            width: 220px;
            background-color: #57a79fb3;
            padding: 20px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            transition: width 0.3s ease;
            overflow-x: hidden;
            overflow-y: auto;
            box-sizing: border-box;
        }

        .sidebar h2 span{
            margin-right: 90px;
        }

        .sidebar h2 {
            padding-bottom: 20px;
        }

        .sidebar.collapsed {
            width: 50px;
        }

        .sidebar.collapsed h2 span {
            display: none;
        }

        .sidebar-toggle {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 16px;
            color: #333;
        }

        .sidebar button.menu-button {
            display: flex;
            align-items: center;
            width: 100%;
            padding: 10px 0;
            color: #333;
            background: none;
            border: none;
            font-weight: 500;
            text-align: left;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .sidebar button.menu-button i {
            width: 20px;
            text-align: center;
            margin-left: 2px;
        }

        .sidebar button.menu-button span {
            margin-left: 12px;
        }

        .sidebar.collapsed button.menu-button span {
            display: none;
        }

        .sidebar.collapsed button.menu-button {
            justify-content: center;
            padding: 14px 0; /* アイコンにゆとりある縦余白を追加 */
        }

        .sidebar button.menu-button:hover {
            background-color: rgba(255, 255, 255, 0.4);
            border-radius: 3px;
        }

        .top-tabs {
            position: fixed;
            left: 220px;
            right: 0;
            top: 0;
            height: 50px;
            background-color: #e7ecec;
            display: flex;
            align-items: center;
            padding: 0 24px;
            border-bottom: 1px solid #ccc;
            z-index: 1000;
            transition: left 0.3s ease;
        }

        .top-tabs.collapsed {
            left: 50px;
        }

        .top-tabs button {
            background: none;
            border: none;
            font-size: 15px;
            color: #333;
            margin-right: 20px;
            cursor: pointer;
            padding: 4px 8px;
        }

        .top-tabs button:hover {
            background-color: rgba(0, 0, 0, 0.1);
            border-radius: 3px;
        }

        .main-content {
            margin-left: 220px;
            padding: 80px 24px 24px 24px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        .main-content.collapsed {
            margin-left: 50px;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100">

    <!-- サイドバー -->
    <div class="sidebar" id="sidebar">
        <h2>
            <span>資産管理</span>
            <button class="sidebar-toggle" onclick="toggleSidebar()">
                <i class="fas fa-angle-double-left" id="toggleIcon"></i>
            </button>
        </h2>
<button class="menu-button" data-label="ダッシュボード"><i class="fas fa-home"></i> <span>ダッシュボード</span></button>
<button class="menu-button" data-label="収入・支出を記録"><i class="fas fa-pen"></i> <span>収入・支出を記録</span></button>
<button class="menu-button" data-label="通知設定"><i class="fas fa-bell"></i> <span>通知設定</span></button>
<button class="menu-button" data-label="ログイン設定"><i class="fas fa-user"></i> <span>ログイン設定</span></button>
<button class="menu-button" data-label="デザイン設定"><i class="fas fa-palette"></i> <span>デザイン設定</span></button>
<button class="menu-button" data-label="その他"><i class="fas fa-cogs"></i> <span>その他</span></button>

    </div>

    <!-- トップタブバー -->
    <div class="top-tabs" id="topTabs">
        <button>棒グラフ</button>
        <button>円グラフ</button>
        <button>TEST</button>
    </div>

    <!-- メインコンテンツ -->
    <div class="main-content" id="mainContent">
        @yield('content')
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const topTabs = document.getElementById('topTabs');
            const mainContent = document.getElementById('mainContent');
            const icon = document.getElementById('toggleIcon');

            sidebar.classList.toggle('collapsed');
            topTabs.classList.toggle('collapsed');
            mainContent.classList.toggle('collapsed');

            // 切り替えアイコン
            if (sidebar.classList.contains('collapsed')) {
                icon.classList.remove('fa-angle-double-left');
                icon.classList.add('fa-angle-double-right');
            } else {
                icon.classList.remove('fa-angle-double-right');
                icon.classList.add('fa-angle-double-left');
            }
        }
    </script>

    @yield('scripts')
</body>
</html>
