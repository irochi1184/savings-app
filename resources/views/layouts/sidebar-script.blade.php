<script>
    document.addEventListener("DOMContentLoaded", () => {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const icon = document.getElementById('toggleIcon');

        // 初期状態の読み込み
        const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        if (isCollapsed) {
            sidebar.classList.add('collapsed');
            mainContent.classList.add('collapsed');
            icon.classList.remove('fa-angle-double-left');
            icon.classList.add('fa-angle-double-right');
        }

        // トグル機能
        window.toggleSidebar = () => {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('collapsed');

            const collapsed = sidebar.classList.contains('collapsed');
            localStorage.setItem('sidebarCollapsed', collapsed);

            if (collapsed) {
                icon.classList.remove('fa-angle-double-left');
                icon.classList.add('fa-angle-double-right');
            } else {
                icon.classList.remove('fa-angle-double-right');
                icon.classList.add('fa-angle-double-left');
            }
        };
    });
</script>
