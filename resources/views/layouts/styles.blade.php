<!-- Fonts & Icons -->
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<!-- Scripts -->
@vite(['resources/css/app.css', 'resources/js/app.js'])

<style>
    body { margin: 0; }
    .sidebar {
        width: 220px; background-color: #57a79fb3; padding: 20px;
        height: 100vh; position: fixed; top: 0; left: 0;
        transition: width 0.3s ease; overflow-x: hidden;
        overflow-y: auto; box-sizing: border-box;
    }
    .sidebar h2 span { margin-right: 90px; }
    .sidebar h2 { padding-bottom: 20px; }
    .sidebar.collapsed { width: 50px; }
    .sidebar.collapsed h2 span { display: none; }
    .sidebar-toggle {
        background: none; border: none; cursor: pointer;
        font-size: 16px; color: #333;
    }
    /* .sidebar button.menu-button {
        display: flex; align-items: center;
        width: 100%; padding: 10px 0; color: #333;
        background: none; border: none; font-weight: 500;
        text-align: left; cursor: pointer; transition: background 0.2s ease;
    }
    .sidebar button.menu-button i {
        width: 20px; text-align: center; margin-left: 2px;
    }
    .sidebar button.menu-button span {
        margin-left: 12px;
    }
    .sidebar.collapsed button.menu-button span {
        display: none;
    }
    .sidebar.collapsed button.menu-button {
        justify-content: center;
        padding: 14px 0;
    }
    .sidebar button.menu-button:hover {
        background-color: rgba(255, 255, 255, 0.4);
        border-radius: 3px;
    } */

    /* 共通スタイル（button も a も対応） */
    .sidebar .menu-button {
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
        text-decoration: none; /* aタグ用 */
    }

    /* アイコン */
    .sidebar .menu-button i {
        width: 20px;
        text-align: center;
        margin-left: 2px;
    }

    /* テキスト */
    .sidebar .menu-button span {
        margin-left: 12px;
    }

    /* 折りたたみ時はテキスト非表示 */
    .sidebar.collapsed .menu-button span {
        display: none;
    }

    /* 折りたたみ時のアイコン中央寄せ */
    .sidebar.collapsed .menu-button {
        justify-content: center;
        padding: 14px 0;
    }

    /* ホバー時 */
    .sidebar .menu-button:hover {
        background-color: rgba(255, 255, 255, 0.4);
        border-radius: 3px;
    }

    .top-tabs {
        position: fixed; left: 220px; right: 0; top: 0;
        height: 50px; background-color: #e7ecec;
        display: flex; align-items: center;
        padding: 0 24px; border-bottom: 1px solid #ccc;
        z-index: 1000; transition: left 0.3s ease;
    }
    .top-tabs.collapsed { left: 50px; }
    .top-tabs button {
        background: none; border: none; font-size: 15px;
        color: #333; margin-right: 20px; cursor: pointer;
        padding: 4px 8px;
    }
    .top-tabs button:hover {
        background-color: rgba(0, 0, 0, 0.1);
        border-radius: 3px;
    }
    .main-content {
        margin-left: 220px; padding: 80px 24px 24px 24px;
        min-height: 100vh; transition: margin-left 0.3s ease;
    }
    .main-content.collapsed {
        margin-left: 50px;
    }

    .icon-option {
        transition: all 0.2s ease;
    }
    .icon-option.selected {
        border: 2px solid #3b82f6; /* 青色 */
        background-color: #e0f2fe;
    }

</style>
