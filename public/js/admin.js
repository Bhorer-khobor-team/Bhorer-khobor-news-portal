/* =============================================
   BHORER KHOBOR — Admin Panel JS
   ============================================= */

document.addEventListener('DOMContentLoaded', function () {

    // Sidebar toggle
    const sidebar     = document.getElementById('sidebar');
    const mainWrapper = document.getElementById('mainWrapper');
    const toggleBtn   = document.getElementById('sidebarToggle');

    const overlay = document.createElement('div');
    overlay.className = 'bk-overlay';
    document.body.appendChild(overlay);

    if (toggleBtn) {
        toggleBtn.addEventListener('click', function () {
            if (window.innerWidth <= 991) {
                sidebar.classList.toggle('open');
                overlay.classList.toggle('active');
            } else {
                if (sidebar.classList.contains('collapsed')) {
                    sidebar.style.transform = '';
                    mainWrapper.style.marginLeft = 'var(--bk-sidebar-w)';
                    sidebar.classList.remove('collapsed');
                } else {
                    sidebar.style.transform = 'translateX(-100%)';
                    mainWrapper.style.marginLeft = '0';
                    sidebar.classList.add('collapsed');
                }
            }
        });
    }

    overlay.addEventListener('click', function () {
        sidebar.classList.remove('open');
        overlay.classList.remove('active');
    });

    // Image preview
    const imageInput   = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    if (imageInput && imagePreview) {
        imageInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    imagePreview.src = e.target.result;
                    imagePreview.classList.remove('d-none');
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Auto-dismiss alerts
    document.querySelectorAll('.alert-dismissible').forEach(function (alert) {
        setTimeout(function () {
            const instance = bootstrap.Alert.getOrCreateInstance(alert);
            if (instance) instance.close();
        }, 5000);
    });

    // Confirm delete popup
    window.confirmDelete = function () {
        return confirm('আপনি কি নিশ্চিত যে এটি মুছে ফেলতে চান?');
    };

    // Auto-slug from title
    const titleInput = document.getElementById('titleInput');
    const slugInput  = document.getElementById('slugInput');
    if (titleInput && slugInput) {
        titleInput.addEventListener('input', function () {
            if (!slugInput.dataset.manual) {
                slugInput.value = slugify(this.value);
            }
        });
        slugInput.addEventListener('input', function () {
            this.dataset.manual = '1';
        });
    }
});

function slugify(text) {
    return text.toString().toLowerCase().trim()
        .replace(/\s+/g, '-')
        .replace(/[^\w\-\u0980-\u09FF]+/g, '-')
        .replace(/--+/g, '-')
        .replace(/^-+|-+$/g, '');
}