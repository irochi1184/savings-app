<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const topTabs = document.getElementById('topTabs');
        const mainContent = document.getElementById('mainContent');
        const icon = document.getElementById('toggleIcon');

        sidebar.classList.toggle('collapsed');
        topTabs.classList.toggle('collapsed');
        mainContent.classList.toggle('collapsed');

        if (sidebar.classList.contains('collapsed')) {
            icon.classList.remove('fa-angle-double-left');
            icon.classList.add('fa-angle-double-right');
        } else {
            icon.classList.remove('fa-angle-double-right');
            icon.classList.add('fa-angle-double-left');
        }
    }
</script>
