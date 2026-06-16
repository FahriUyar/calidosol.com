<?php
$pageTitle = t('page.seo_title');
$pageDescription = t('page.seo_description');
$rooms = t('room_list', []);
?>

<?php render_page_hero(
    t('page.title'),
    t('page.subtitle'),
    'images/pages/banners/01KT1X86DZRBQ1AVA6ZB279WRJ.webp' // Hardcoded placeholder banner for now, can be updated later
); ?>

<?php render_page_content_intro(
    t('rooms.our_rooms'),
    '',
    t('page.content')
); ?>

<section class="py-5" style="background: linear-gradient(180deg, #ffffff 0%, var(--color-bg-light) 100%);">
    <div class="container-fluid px-4 px-lg-5">
        <?php if (!empty($rooms)): ?>
            <div class="rooms-grid">
                <?php foreach ($rooms as $room): ?>
                    <article class="room-card">
                        <a href="<?= e(page_url('odalar', $room['slug'] ?? '')) ?>" class="room-card__link" aria-label="<?= e($room['name'] ?? '') ?> detaylarını görüntüle">
                            <figure class="room-card__figure">
                                <?php if (!empty($room['featured_image'])): ?>
                                    <img src="<?= e(asset($room['featured_image'])) ?>" 
                                         alt="<?= e($room['name'] ?? '') ?>" 
                                         class="room-card__img"
                                         loading="lazy">
                                <?php else: ?>
                                    <div class="room-card__img room-card__img--placeholder">
                                        <i class="bi bi-image fs-1 text-muted"></i>
                                    </div>
                                <?php endif; ?>
                            </figure>

                            <div class="room-card__body">
                                <h2 class="room-card__title"><?= e($room['name'] ?? '') ?></h2>
                                
                                <?php if (!empty($room['short_description'])): ?>
                                    <p class="room-card__desc"><?= e($room['short_description']) ?></p>
                                <?php endif; ?>

                                <div class="room-card__meta">
                                    <span class="room-card__meta-item" aria-label="Kapasite">
                                        <i class="bi bi-people-fill" aria-hidden="true"></i> <?= e($room['capacity'] ?? '') ?> <?= e(t('common.person')) ?>
                                    </span>
                                    <?php if (!empty($room['size_m2'])): ?>
                                        <span class="room-card__meta-item" aria-label="Oda büyüklüğü">
                                            <i class="bi bi-arrows-angle-expand" aria-hidden="true"></i> <?= e($room['size_m2']) ?> m²
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <span class="room-card__cta">
                                    <?= e(t('common.view_details')) ?> <i class="bi bi-arrow-right" aria-hidden="true"></i>
                                </span>
                            </div>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-door-open display-1 text-muted opacity-25"></i>
                <p class="text-muted mt-3 fs-5">Oda bilgileri yakında eklenecektir.</p>
            </div>
        <?php endif; ?>
    </div>
</section>
