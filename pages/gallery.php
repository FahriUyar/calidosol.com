<?php
$pageTitle = t('seo_title', 'Galeri | ' . config('site_name'));
$pageDescription = t('seo_description', 'Otelimizin fotoğrafları');

render_page_hero(
    t('title', 'Galeri'),
    '',
    'images/pages/banners/01KSFPCSQAXCJB6HCJRTK5QDNV.jpg'
);

render_page_content_intro(
    t('title', 'Galeri'),
    '',
    t('content', 'Tesisimize ait görseller.')
);

// Kategorize edilmiş fotoğrafları klasörlerden al
$galleryPath = __DIR__ . '/../images/gallery';
$categories = [];

// Klasörleri oku
if (is_dir($galleryPath)) {
    $dirs = scandir($galleryPath);
    foreach ($dirs as $dir) {
        if ($dir !== '.' && $dir !== '..' && is_dir($galleryPath . '/' . $dir)) {
            $images = [];
            $files = scandir($galleryPath . '/' . $dir);
            foreach ($files as $file) {
                // Sadece resim dosyalarını al
                if (preg_match('/\.(jpg|jpeg|png|webp|gif)$/i', $file)) {
                    $images[] = 'images/gallery/' . $dir . '/' . $file;
                }
            }
            
            if (!empty($images)) {
                // Kategori adını slug'dan daha düzgün bir isme çevir (örn: restoran-bar -> Restoran Bar)
                $catName = ucwords(str_replace('-', ' ', $dir));
                $categories[$dir] = [
                    'name' => $catName,
                    'images' => $images
                ];
            }
        }
    }
}
?>

<section class="py-5" style="background-color: var(--color-bg-light);">
    <div class="container-fluid px-4 px-lg-5">
        <?php if (!empty($categories)): ?>
            
            <!-- Kategori Filtreleme Butonları -->
            <div class="d-flex flex-wrap justify-content-center gap-2 mb-5">
                <button class="btn btn-gallery-filter rounded-pill px-4 py-2 filter-btn active" data-filter="all">Tümü</button>
                <?php foreach ($categories as $slug => $cat): ?>
                    <button class="btn btn-gallery-filter rounded-pill px-4 py-2 filter-btn" data-filter="<?= e($slug) ?>">
                        <?= e($cat['name']) ?>
                    </button>
                <?php endforeach; ?>
            </div>

            <!-- Galeri Grid -->
            <div class="row g-4" id="gallery-container">
                <?php foreach ($categories as $slug => $cat): ?>
                    <?php foreach ($cat['images'] as $img): ?>
                        <div class="col-sm-6 col-md-4 col-lg-3 gallery-item mb-4" data-category="<?= e($slug) ?>">
                            <a href="<?= e(asset($img)) ?>" class="d-block overflow-hidden rounded-4 shadow-sm ratio ratio-1x1 position-relative group" data-fslightbox="gallery">
                                <img src="<?= e(asset($img)) ?>" class="w-100 h-100 object-fit-cover transition-transform" style="transition: transform 0.5s ease;" alt="<?= e($cat['name']) ?> Image" loading="lazy">
                                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center opacity-0 transition-all" style="background: rgba(0,0,0,0.3); transition: all 0.3s ease;">
                                    <i class="bi bi-arrows-fullscreen text-white fs-2"></i>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </div>

        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-images display-1 text-muted opacity-25"></i>
                <p class="text-muted mt-3 fs-5">Galeri fotoğrafları yakında eklenecektir.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php ob_start(); ?>
<!-- FsLightbox for Gallery -->
<script src="https://cdn.jsdelivr.net/npm/fslightbox@3.4.1/index.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const galleryItems = document.querySelectorAll('.gallery-item');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            // Aktif buton stilini güncelle
            filterBtns.forEach(b => {
                b.classList.remove('active');
            });
            this.classList.add('active');

            // Filtreleme işlemi
            const filterValue = this.getAttribute('data-filter');
            
            galleryItems.forEach(item => {
                if (filterValue === 'all' || item.getAttribute('data-category') === filterValue) {
                    item.style.display = 'block';
                    // Küçük bir animasyon etkisi için timeout
                    setTimeout(() => { item.style.opacity = '1'; item.style.transform = 'scale(1)'; }, 50);
                } else {
                    item.style.opacity = '0';
                    item.style.transform = 'scale(0.8)';
                    setTimeout(() => { item.style.display = 'none'; }, 300); // transition süresi kadar bekle
                }
            });
        });
    });
});
</script>
<?php $extraScripts .= ob_get_clean(); ?>

<?php ob_start(); ?>
<style>
.btn-gallery-filter {
    border: 2px solid var(--color-primary);
    color: var(--color-primary);
    background-color: transparent;
    transition: all 0.3s ease;
    font-weight: 500;
}
.btn-gallery-filter:hover, .btn-gallery-filter.active {
    background-color: var(--color-primary);
    color: var(--color-text, #212529); /* Koyu metin rengiyle okunabilirliği artırır */
}
.ratio-1x1:hover img { transform: scale(1.1); }
.ratio-1x1:hover > div { opacity: 1 !important; }
.gallery-item { transition: opacity 0.3s ease, transform 0.3s ease; }
</style>
<?php $extraHead .= ob_get_clean(); ?>
