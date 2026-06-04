/* =============================================
   BHORER KHOBOR — Public JS
   ============================================= */

document.addEventListener('DOMContentLoaded', function () {

    // Back to Top button
    const backToTop = document.getElementById('backToTop');
    if (backToTop) {
        window.addEventListener('scroll', function () {
            backToTop.classList.toggle('visible', window.scrollY > 300);
        });
        backToTop.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // Auto-dismiss alerts after 5 seconds
    document.querySelectorAll('.alert-dismissible').forEach(function (alert) {
        setTimeout(function () {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            if (bsAlert) bsAlert.close();
        }, 5000);
    });

    // Lazy image loading
    if ('IntersectionObserver' in window) {
        const imgs = document.querySelectorAll('img[loading="lazy"]');
        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) { observer.unobserve(entry.target); }
            });
        });
        imgs.forEach(function (img) { observer.observe(img); });
    }

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
});

function slugify(text) {
    return text.toString().toLowerCase().trim()
        .replace(/\s+/g, '-')
        .replace(/[^\w\-\u0980-\u09FF]+/g, '-')
        .replace(/--+/g, '-')
        .replace(/^-+|-+$/g, '');
}