<?php
/**
 * Tekrar Kullanılan Bileşen Render Fonksiyonları
 * Blade component'larının düz PHP karşılıkları.
 */

/**
 * Sayfa Hero Banner'ı
 */
function render_page_hero(string $title, string $subtitle = '', string $bgImage = ''): void
{
?>
<section class="page-hero position-relative d-flex align-items-center justify-content-center" role="banner">
    <?php if ($bgImage): ?>
        <img src="<?= e(asset($bgImage)) ?>" 
             alt="<?= e($title) ?>" 
             class="page-hero__bg" 
             loading="eager"
             fetchpriority="high">
    <?php else: ?>
        <div class="page-hero__bg page-hero__bg--fallback"></div>
    <?php endif; ?>
    
    <div class="page-hero__overlay"></div>
    
    <div class="container position-relative z-1 text-center">
        <ol class="breadcrumb justify-content-center mb-0 small text-uppercase" style="letter-spacing: 1px;">
            <li class="breadcrumb-item"><a href="<?= e(base_url('/')) ?>" class="text-white-50 text-decoration-none"><?= e(t('menu.home')) ?></a></li>
            <li class="breadcrumb-item active text-white" aria-current="page"><?= e($title) ?></li>
        </ol>
        <div class="glass-card d-inline-block py-4 px-5 mx-auto mt-3" style="border-radius: 12px;">
            <h1 class="display-5 fw-bold text-white mb-0" style="text-shadow: 0 2px 4px rgba(0,0,0,0.3);"><?= e($title) ?></h1>
            <?php if ($subtitle): ?>
                <p class="fs-5 text-white opacity-75 mt-2 mb-0"><?= e($subtitle) ?></p>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php
}

/**
 * Sayfa İçerik Giriş Bölümü
 */
function render_page_content_intro(string $sectionTitle, string $heading = '', string $content = '', array $breadcrumbs = []): void
{
?>
<section class="page-content-intro">
    <div class="container-fluid px-4 px-lg-5">
        <nav aria-label="Breadcrumb" class="pt-4 pb-2">
            <ol class="breadcrumb-custom">
                <li><a href="<?= e(base_url('/')) ?>"><?= e(t('menu.home')) ?></a></li>
                <?php foreach ($breadcrumbs as $crumb): ?>
                    <li><a href="<?= e($crumb['url']) ?>"><?= e($crumb['label']) ?></a></li>
                <?php endforeach; ?>
                <li aria-current="page"><?= e($sectionTitle) ?></li>
            </ol>
        </nav>

        <div class="row g-4 pb-5 pt-3">
            <div class="col-lg-3 col-md-4 mb-3 mb-md-0">
                <div class="page-content-intro__title-wrapper">
                    <span class="page-content-intro__line" aria-hidden="true"></span>
                    <h2 class="page-content-intro__title"><?= e($sectionTitle) ?></h2>
                </div>
            </div>

            <div class="col-lg-9 col-md-8">
                <?php if ($heading): ?>
                    <h3 class="page-content-intro__heading"><?= e($heading) ?></h3>
                <?php endif; ?>

                <?php if ($content): ?>
                    <div class="page-content-intro__content">
                        <?= $content ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php
}

/**
 * Timeline Section
 */
function render_timeline_section(array $items): void
{
?>
<section class="py-5 timeline-section">
    <div class="container">
        <div class="timeline-container position-relative">
            <div class="timeline-divider d-none d-lg-block"></div>

            <?php foreach ($items as $index => $item):
                $isLeft = ($item['align'] ?? 'left') === 'left';
                $imageUrl = $item['image'] ?? '';
                if ($imageUrl && !str_starts_with($imageUrl, 'http')) {
                    $imageUrl = asset($imageUrl);
                }
            ?>
                <div class="row align-items-center mb-5 timeline-row">
                    <?php if ($isLeft): ?>
                        <div class="col-lg-6 position-relative z-1 mb-4 mb-lg-0">
                            <img src="<?= e($imageUrl) ?>" alt="<?= e($item['title'] ?? '') ?>" class="img-fluid rounded-4 shadow-sm w-100 timeline-img" loading="lazy">
                        </div>
                        <div class="d-none d-lg-block timeline-dot-wrapper">
                            <div class="timeline-dot"></div>
                        </div>
                        <div class="col-lg-6 ps-lg-5 position-relative z-1">
                            <div class="timeline-content p-4 p-lg-5">
                                <h3 class="fw-bold mb-3 timeline-title d-inline-block px-3 py-2 rounded"><?= e($item['title'] ?? '') ?></h3>
                                <p class="text-muted fs-5 mt-3" style="line-height: 1.8;"><?= nl2br(e($item['content'] ?? '')) ?></p>
                                <?php if (!empty($item['service_hours'])): ?>
                                    <p class="mt-2 text-muted"><small><?= e(t('common.service_hours', 'Hizmet Saatleri')) ?>: <?= e($item['service_hours']) ?></small></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="col-lg-6 pe-lg-5 position-relative z-1 order-2 order-lg-1">
                            <div class="timeline-content p-4 p-lg-5 text-lg-end">
                                <h3 class="fw-bold mb-3 timeline-title d-inline-block px-3 py-2 rounded"><?= e($item['title'] ?? '') ?></h3>
                                <p class="text-muted fs-5 mt-3" style="line-height: 1.8;"><?= nl2br(e($item['content'] ?? '')) ?></p>
                                <?php if (!empty($item['service_hours'])): ?>
                                    <p class="mt-2 text-muted"><small><?= e(t('common.service_hours', 'Hizmet Saatleri')) ?>: <?= e($item['service_hours']) ?></small></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="d-none d-lg-block timeline-dot-wrapper">
                            <div class="timeline-dot"></div>
                        </div>
                        <div class="col-lg-6 position-relative z-1 mb-4 mb-lg-0 order-1 order-lg-2">
                            <img src="<?= e($imageUrl) ?>" alt="<?= e($item['title'] ?? '') ?>" class="img-fluid rounded-4 shadow-sm w-100 timeline-img" loading="lazy">
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php
}

/**
 * Özellik Listesi
 */
function render_features_list(string $title, array $items): void
{
?>
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-4 mb-4 mb-lg-0">
                <div class="d-flex align-items-center mb-3">
                    <div style="width: 50px; height: 3px; background-color: var(--color-primary); margin-right: 15px;"></div>
                    <h2 class="h3 fw-bold mb-0" style="color: var(--color-primary);"><?= e($title) ?></h2>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="feature-list-card shadow-sm p-4 p-md-5 rounded-4">
                    <div class="row g-4">
                        <?php foreach ($items as $item): ?>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-chevron-right text-primary me-2 fw-bold" aria-hidden="true"></i>
                                <span class="fw-medium text-dark"><?= e($item['label'] ?? ($item ?? '')) ?></span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
}

/**
 * Barlar Bölümü
 */
function render_bars_section(string $title, array $bars, array $notes = []): void
{
?>
<section class="py-5 bars-section" aria-labelledby="bars-section-heading">
    <div class="container">
        <div class="row align-items-start">
            <div class="col-lg-3 col-md-4 mb-4 mb-md-0">
                <div class="d-flex align-items-center mb-3">
                    <span class="bars-section__line" aria-hidden="true"></span>
                    <h2 id="bars-section-heading" class="bars-section__title"><?= e($title) ?></h2>
                </div>
            </div>
            <div class="col-lg-9 col-md-8">
                <div class="bars-section__card shadow-sm p-4 p-md-5 rounded-4">
                    <?php if (!empty($bars)): ?>
                    <div class="row g-3 mb-4">
                        <?php foreach ($bars as $bar): ?>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-chevron-right text-primary me-2 fw-bold" aria-hidden="true"></i>
                                <span class="fw-semibold text-dark"><?= e($bar['name'] ?? '') ?></span>
                                <span class="ms-1 text-muted">— <?= e($bar['hours'] ?? '') ?></span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($notes)): ?>
                    <div class="bars-section__notes">
                        <?php foreach ($notes as $note): ?>
                            <?php if (($note['type'] ?? 'info') === 'highlight'): ?>
                                <p class="bars-section__note bars-section__note--highlight mb-2">
                                    <i class="bi bi-chevron-right me-1" aria-hidden="true"></i>
                                    <strong><?= e($note['text'] ?? '') ?></strong>
                                </p>
                            <?php else: ?>
                                <p class="bars-section__note mb-1">
                                    <small>* <?= e($note['text'] ?? '') ?></small>
                                </p>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
}

/**
 * Yemek Programı Tablosu
 */
function render_meal_schedule(string $title, array $items): void
{
?>
<section class="py-5" aria-labelledby="meal-schedule-heading">
    <div class="container">
        <article class="meal-schedule-card shadow-sm rounded-4 p-4 p-md-5">
            <h2 id="meal-schedule-heading" class="h4 fw-bold mb-4"><?= e($title) ?></h2>
            <div class="table-responsive">
                <table class="meal-schedule-table w-100">
                    <thead>
                        <tr>
                            <th scope="col"><?= e(t('common.meal', 'Öğün')) ?></th>
                            <th scope="col"><?= e(t('common.time', 'Saat')) ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?= e($item['meal_name'] ?? '') ?></td>
                            <td><?= e($item['time'] ?? '') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </article>
    </div>
</section>
<?php
}

/**
 * Bilgi Tablosu
 */
function render_info_table(string $title, string $header1, string $header2, array $items): void
{
?>
<section class="py-5" aria-labelledby="info-table-heading">
    <div class="container">
        <article class="meal-schedule-card shadow-sm rounded-4 p-4 p-md-5">
            <h2 id="info-table-heading" class="h4 fw-bold mb-4"><?= e($title) ?></h2>
            <div class="table-responsive">
                <table class="meal-schedule-table w-100">
                    <thead>
                        <tr>
                            <th scope="col"><?= e($header1) ?></th>
                            <th scope="col" style="text-align: left !important;"><?= e($header2) ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?= e($item['col_1'] ?? '') ?></td>
                            <td style="text-align: left !important; color: var(--color-text); font-weight: normal;"><?= e($item['col_2'] ?? '') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </article>
    </div>
</section>
<?php
}

/**
 * Önemli Bilgiler Kutusu
 */
function render_info_notice(string $title, string $content): void
{
?>
<section class="py-5" aria-labelledby="info-notice-heading">
    <div class="container">
        <article class="info-notice rounded-4 p-4 p-md-5">
            <div class="d-flex align-items-center mb-3">
                <i class="bi bi-journal-text me-2 fs-5" aria-hidden="true" style="color: var(--color-text);"></i>
                <h2 id="info-notice-heading" class="h5 fw-bold mb-0"><?= e($title) ?></h2>
            </div>
            <div class="info-notice__content">
                <?= nl2br(e($content)) ?>
            </div>
        </article>
    </div>
</section>
<?php
}
