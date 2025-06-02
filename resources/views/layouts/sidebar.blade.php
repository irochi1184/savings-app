<div class="sidebar" id="sidebar">
    <h2>
        <span>資産管理</span>
        <button class="sidebar-toggle" onclick="toggleSidebar()">
            <i class="fas fa-angle-double-left" id="toggleIcon"></i>
        </button>
    </h2>

    <a href="{{ route('dashboard') }}" class="menu-button"><i class="fas fa-home"></i> <span>ダッシュボード</span></a>
    <a href="{{ route('record.create') }}" class="menu-button"><i class="fas fa-pen"></i> <span>収入・支出を記録</span></a>
    <a href="{{ route('categories.index') }}" class="menu-button"><i class="fas fa-folder-open"></i> <span>カテゴリー設定</span></a>
    <a href="{{ route('record.create') }}" class="menu-button"><i class="fas fa-bell"></i> <span>通知設定</span></a>
    <a href="{{ route('record.create') }}" class="menu-button"><i class="fas fa-user"></i> <span>ログイン設定</span></a>
    <a href="{{ route('record.create') }}" class="menu-button"><i class="fas fa-palette"></i> <span>デザイン設定</span></a>
    <a href="{{ route('record.create') }}" class="menu-button"><i class="fas fa-cogs"></i> <span>その他</span></a>
</div>
