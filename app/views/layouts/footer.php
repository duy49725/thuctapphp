        </div>
    </div>
</body>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const sidebarItems = document.querySelectorAll('.sidebar_item');
    const urlParams = new URLSearchParams(window.location.search);
    const currentUrlParam = urlParams.get('url'); // Chỉ lấy tham số 'url'

    function setActiveItem() {
        sidebarItems.forEach(item => {
            const link = item.querySelector('a').href;
            const linkParams = new URLSearchParams(new URL(link).search);
            const linkUrlParam = linkParams.get('url');
            if (currentUrlParam === linkUrlParam) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });
    }

    setActiveItem();

    sidebarItems.forEach(item => {
        item.addEventListener('click', function() {
            sidebarItems.forEach(i => i.classList.remove('active'));
            this.classList.add('active');
        });
    });
});
</script>
</html>