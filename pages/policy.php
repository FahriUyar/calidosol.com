<?php
$pageTitle = config('site_name') . ' - ' . t('page_title', 'Politikalar');
$pageDescription = t('page_description', 'Otel politikalarımız ve kurallarımız');

$policies = t('policies', []);
$currentSlug = $_GET['slug'] ?? null;
?>

<?php render_page_hero(
    t('page_title', 'Politikalar'),
    '',
    'images/pages/banners/01KT1XFNVHNCHZW8AHEMWRZMVP.webp'
); ?>

<?php if ($currentSlug && isset($policies[$currentSlug])): ?>
    <?php // Tekil politika detay sayfası ?>
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <nav aria-label="Breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= e(base_url('/')) ?>"><?= e(t('menu.home')) ?></a></li>
                            <li class="breadcrumb-item"><a href="<?= e(page_url('policy')) ?>"><?= e(t('page_title', 'Politikalar')) ?></a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?= e($policies[$currentSlug]['title']) ?></li>
                        </ol>
                    </nav>
                    <article class="bg-white p-4 p-md-5 rounded-4 shadow-sm border" style="border-color: rgba(0,0,0,0.06);">
                        <h2 class="h3 fw-bold mb-4" style="color: var(--color-primary);"><?= e($policies[$currentSlug]['title']) ?></h2>
                        <div class="policy-content text-muted" style="line-height: 1.9;">
                            <?= $policies[$currentSlug]['content'] ?>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>
<?php else: ?>
    <?php // Politika listesi sayfası ?>
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <?php if (!empty($policies)): ?>
                        <div class="row g-4">
                            <?php foreach ($policies as $slug => $policy): ?>
                                <div class="col-12">
                                    <a href="<?= e(base_url('bilgi/' . $slug)) ?>" class="text-decoration-none d-block">
                                        <article class="bg-white p-4 rounded-4 shadow-sm border policy-card" style="border-color: rgba(0,0,0,0.06); transition: all 0.3s ease;">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div>
                                                    <h2 class="h5 fw-bold mb-1" style="color: var(--color-primary);"><?= e($policy['title']) ?></h2>
                                                    <p class="text-muted mb-0 small"><?= e(config('site_name')) ?></p>
                                                </div>
                                                <i class="bi bi-chevron-right fs-4 text-muted" aria-hidden="true"></i>
                                            </div>
                                        </article>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="bg-white p-5 rounded-4 shadow-sm border" style="border-color: rgba(0,0,0,0.06);">
                            <h2 class="h3 fw-bold mb-4" style="color: var(--color-primary);"><?= e(t('page_title', 'Politikalarımız')) ?></h2>
                            <p class="text-muted">Politika içerikleri daha sonra eklenecektir.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
