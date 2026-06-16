<?php
$slug = $_GET['slug'] ?? '';
$rooms = t('room_list', []);
$room = null;
$otherRooms = [];

foreach ($rooms as $r) {
    if ($r['slug'] === $slug) {
        $room = $r;
    } else {
        $otherRooms[] = $r;
    }
}

if (!$room) {
    // Eğer o anki dilde slug bulunamadıysa, diğer dillerdeki slug'ları kontrol et
    $roomIndex = -1;
    $locales = config('supported_locales', ['tr', 'en', 'de']);
    foreach ($locales as $locale) {
        $langPath = __DIR__ . "/../lang/$locale/rooms.php";
        if (file_exists($langPath)) {
            $langData = require $langPath;
            if (isset($langData['room_list'])) {
                foreach ($langData['room_list'] as $i => $r) {
                    if ($r['slug'] === $slug) {
                        $roomIndex = $i;
                        break 2;
                    }
                }
            }
        }
    }

    // Eğer oda başka bir dildeki slug ile bulunduysa, şu anki dildeki doğru slug'a yönlendir (SEO 301)
    if ($roomIndex !== -1 && isset($rooms[$roomIndex])) {
        $correctSlug = $rooms[$roomIndex]['slug'];
        header("Location: " . page_url('odalar', $correctSlug), true, 301);
        exit;
    }

    // Oda tamamen bulunamadı
    http_response_code(404);
    echo '<div class="container py-5 text-center"><h1>404</h1><p>Oda bulunamadı.</p></div>';
    return;
}

// Global page variables for header/meta
$pageTitle = $room['seo_title'] ?? $room['name'] . ' - ' . config('site_name');
$pageDescription = $room['seo_description'] ?? strip_tags($room['short_description'] ?? '');
$pageImage = !empty($room['featured_image']) ? asset($room['featured_image']) : asset('images/og-default.jpg');

// Schema.org LD-JSON
ob_start();
?>
<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "HotelRoom",
        "name": "<?= e($room['name'] ?? '') ?>",
        "description": "<?= e(strip_tags($room['short_description'] ?? '')) ?>",
        "image": "<?= e($pageImage) ?>",
        "bed": {
            "@type": "BedDetails",
            "numberOfBeds": "<?= e($room['capacity'] ?? '') ?>",
            "typeOfBed": "Standard"
        },
        "occupancy": {
            "@type": "QuantitativeValue",
            "value": "<?= e($room['capacity'] ?? '') ?>"
        }
        <?php if (!empty($room['amenities'])): ?>
        ,"amenityFeature": [
            <?php foreach ($room['amenities'] as $index => $amenity): ?>
            {
                "@type": "LocationFeatureSpecification",
                "name": "<?= e($amenity) ?>",
                "value": true
            }<?= ($index < count($room['amenities']) - 1) ? ',' : '' ?>
            <?php endforeach; ?>
        ]
        <?php endif; ?>
    }
</script>
<?php
$extraHead .= ob_get_clean();
?>

<?php render_page_hero(
    $room['name'] ?? '',
    $room['short_description'] ?? '',
    $room['featured_image'] ?? ''
); ?>

<?php render_page_content_intro(
    t('rooms.room_details'),
    $room['name'] ?? '',
    $room['description'] ?? '',
    [
        ['url' => page_url('odalar'), 'label' => t('rooms.our_rooms')]
    ]
); ?>

<section class="py-5">
    <div class="container">
        <div class="row g-5">
            <!-- Sol: Galeri Slider -->
            <div class="col-lg-7 col-xl-8">
                <?php if (!empty($room['gallery'])): ?>
                <div id="roomGalleryCarousel" class="splide rounded-4 shadow-sm overflow-hidden">
                    <div class="splide__track">
                        <ul class="splide__list">
                            <?php foreach ($room['gallery'] as $index => $imagePath): ?>
                            <li class="splide__slide">
                                <img src="<?= e(asset($imagePath)) ?>"
                                     class="d-block w-100"
                                     style="aspect-ratio: 16/9; object-fit: cover;"
                                     alt="<?= e($room['name'] ?? '') ?> - <?= $index + 1 ?>">
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <?php else: ?>
                    <?php if (!empty($room['featured_image'])): ?>
                    <div class="rounded-4 shadow-sm overflow-hidden">
                        <img src="<?= e(asset($room['featured_image'])) ?>"
                             class="d-block w-100"
                             style="aspect-ratio: 16/9; object-fit: cover;"
                             alt="<?= e($room['name'] ?? '') ?>">
                    </div>
                    <?php else: ?>
                    <div class="rounded-4 shadow-sm bg-light d-flex align-items-center justify-content-center" style="aspect-ratio: 16/9;">
                        <i class="bi bi-image text-muted display-1"></i>
                    </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <!-- Sağ: Bilgi Kartı -->
            <div class="col-lg-5 col-xl-4">
                <aside class="room-detail__info-card shadow-sm p-4 rounded-4" style="background-color: var(--color-bg-white); border: 1px solid rgba(0,0,0,0.06);">
                    <h2 class="h5 fw-bold mb-4" style="color: var(--color-primary);"><?= e(t('rooms.room_info')) ?></h2>

                    <div class="room-detail__info-row d-flex justify-content-between border-bottom pb-2 mb-3">
                        <span class="room-detail__info-label text-muted">
                            <i class="bi bi-people-fill me-2" aria-hidden="true"></i> <?= e(t('common.capacity')) ?>
                        </span>
                        <span class="room-detail__info-value fw-medium"><?= e($room['capacity'] ?? '') ?> <?= e(t('common.person')) ?></span>
                    </div>

                    <?php if (!empty($room['size_m2'])): ?>
                    <div class="room-detail__info-row d-flex justify-content-between border-bottom pb-2 mb-3">
                        <span class="room-detail__info-label text-muted">
                            <i class="bi bi-arrows-angle-expand me-2" aria-hidden="true"></i> <?= e(t('common.size')) ?>
                        </span>
                        <span class="room-detail__info-value fw-medium"><?= e($room['size_m2']) ?> m²</span>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($room['amenities'])): ?>
                    <hr class="my-4 opacity-25">
                    <h3 class="h6 fw-bold mb-3"><?= e(t('rooms.amenities')) ?></h3>
                    <div class="room-detail__amenities d-flex flex-wrap gap-2">
                        <?php foreach ($room['amenities'] as $amenity): ?>
                        <span class="amenity-badge bg-light rounded-pill px-3 py-1 text-dark fs-6 border" style="font-size: 0.85rem !important;">
                            <i class="bi bi-check-circle-fill text-primary me-1" aria-hidden="true"></i> <?= e($amenity) ?>
                        </span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <?php if (config('reservation_url')): ?>
                    <a href="<?= e(config('reservation_url')) ?>"
                       class="btn btn-primary-custom w-100 mt-4 d-flex justify-content-center align-items-center gap-2 py-3 fw-bold rounded-3"
                       target="_blank"
                       rel="noopener noreferrer">
                        <i class="bi bi-calendar2-check fs-5" aria-hidden="true"></i> <?= e(t('menu.book_now')) ?>
                    </a>
                    <?php endif; ?>
                </aside>
            </div>
        </div>
    </div>
</section>

<!-- Diğer Odalar -->
<?php if (!empty($otherRooms)): ?>
<section class="py-5" style="background-color: var(--color-bg-light);">
    <div class="container">
        <h2 class="text-center fw-bold mb-5" style="color: var(--color-text);"><?= e(t('rooms.other_rooms')) ?></h2>
        <div class="rooms-grid">
            <?php foreach (array_slice($otherRooms, 0, 3) as $otherRoom): ?>
            <article class="room-card bg-white shadow-sm">
                <a href="<?= e(page_url('odalar', $otherRoom['slug'] ?? '')) ?>" class="room-card__link text-decoration-none text-dark" aria-label="<?= e($otherRoom['name'] ?? '') ?> detaylarını görüntüle">
                    <figure class="room-card__figure m-0">
                        <?php if (!empty($otherRoom['featured_image'])): ?>
                        <img src="<?= e(asset($otherRoom['featured_image'])) ?>"
                             alt="<?= e($otherRoom['name'] ?? '') ?>"
                             class="room-card__img w-100 object-fit-cover"
                             style="height: 200px;"
                             loading="lazy">
                        <?php else: ?>
                        <div class="room-card__img room-card__img--placeholder bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="bi bi-image fs-1 text-muted"></i>
                        </div>
                        <?php endif; ?>
                    </figure>
                    <div class="room-card__body p-3">
                        <h3 class="room-card__title h6 fw-bold mb-3"><?= e($otherRoom['name'] ?? '') ?></h3>
                        <span class="room-card__cta text-primary fw-medium d-flex align-items-center gap-2">
                            <?= e(t('common.view_details')) ?> <i class="bi bi-arrow-right" aria-hidden="true"></i>
                        </span>
                    </div>
                </a>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php ob_start(); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const carouselElement = document.querySelector('#roomGalleryCarousel');
    if (carouselElement) {
        new Splide('#roomGalleryCarousel', {
            type: 'loop',
            autoplay: true,
            interval: 4000,
            arrows: true,
            pagination: true
        }).mount();
    }
});
</script>
<?php $extraScripts .= ob_get_clean(); ?>
