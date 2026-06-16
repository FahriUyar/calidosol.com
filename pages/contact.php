<?php
$pageTitle = t('seo_title');
$pageDescription = t('seo_description');

render_page_hero(
    t('title'),
    '',
    'images/pages/banners/01KT1XFNVHNCHZW8AHEMWRZMVP.webp'
);

render_page_content_intro(
    t('title'),
    '',
    t('content')
);
?>

<section style="background-color: var(--color-bg-light);">
    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="contact-info-card shadow-sm p-4 p-md-5 rounded-4 bg-white border" style="border-color: rgba(0,0,0,0.06);">
                    <h2 class="h4 fw-bold mb-5 text-center" style="color: var(--color-primary);"><?= e(t('menu.contact')) ?></h2>

                    <div class="row g-4 justify-content-center">
                        <?php if (config('contact_phone')): ?>
                            <div class="col-md-4">
                                <div class="d-flex flex-column align-items-center text-center gap-3">
                                    <div class="bg-light text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                                        <i class="bi bi-telephone-fill fs-4"></i>
                                    </div>
                                    <div>
                                        <h3 class="h6 fw-bold mb-2">Telefon</h3>
                                        <a href="tel:<?= e(preg_replace('/[^0-9+]/', '', config('contact_phone'))) ?>" class="text-decoration-none text-muted"><?= e(config('contact_phone')) ?></a>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (config('contact_email')): ?>
                            <div class="col-md-4">
                                <div class="d-flex flex-column align-items-center text-center gap-3">
                                    <div class="bg-light text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                                        <i class="bi bi-envelope-fill fs-4"></i>
                                    </div>
                                    <div>
                                        <h3 class="h6 fw-bold mb-2">E-Posta</h3>
                                        <a href="mailto:<?= e(config('contact_email')) ?>" class="text-decoration-none text-muted"><?= e(config('contact_email')) ?></a>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (config('contact_address')): ?>
                            <div class="col-md-4">
                                <div class="d-flex flex-column align-items-center text-center gap-3">
                                    <div class="bg-light text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                                        <i class="bi bi-geo-alt-fill fs-4"></i>
                                    </div>
                                    <div>
                                        <h3 class="h6 fw-bold mb-2">Adres</h3>
                                        <span class="text-muted"><?= e(config('contact_address')) ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <hr class="my-5" style="opacity: 0.08;">
                    
                    <h3 class="h5 fw-bold mb-4 text-center" style="color: var(--color-primary);">Sosyal Medya ve Mesajlaşma</h3>
                    <div class="d-flex flex-wrap justify-content-center gap-4">
                        <a href="<?= e(whatsapp_url()) ?>" class="bg-light text-primary rounded-circle d-flex align-items-center justify-content-center text-decoration-none social-icon-btn" target="_blank" rel="noopener noreferrer">
                            <i class="bi bi-whatsapp fs-4"></i>
                        </a>

                        <?php if (config('messenger_url')): ?>
                        <a href="<?= e(config('messenger_url')) ?>" class="bg-light text-primary rounded-circle d-flex align-items-center justify-content-center text-decoration-none social-icon-btn" target="_blank" rel="noopener noreferrer">
                            <i class="bi bi-messenger fs-4"></i>
                        </a>
                        <?php endif; ?>

                        <?php if (config('facebook_url')): ?>
                        <a href="<?= e(config('facebook_url')) ?>" class="bg-light text-primary rounded-circle d-flex align-items-center justify-content-center text-decoration-none social-icon-btn" target="_blank" rel="noopener noreferrer">
                            <i class="bi bi-facebook fs-4"></i>
                        </a>
                        <?php endif; ?>

                        <?php if (config('instagram_url')): ?>
                        <a href="<?= e(config('instagram_url')) ?>" class="bg-light text-primary rounded-circle d-flex align-items-center justify-content-center text-decoration-none social-icon-btn" target="_blank" rel="noopener noreferrer">
                            <i class="bi bi-instagram fs-4"></i>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tam Genişlik Harita -->
    <div class="w-100 map-container" style="height: 500px;">
        <?= config('google_maps_iframe') ?>
    </div>
</section>

<?php ob_start(); ?>
<style>
    .map-container iframe {
        width: 100% !important;
        height: 100% !important;
        display: block;
        border: none;
    }
    .social-icon-btn {
        width: 56px;
        height: 56px;
        transition: all 0.3s ease;
    }
    .social-icon-btn:hover {
        background-color: var(--color-primary) !important;
        color: white !important;
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.1);
    }
</style>
<?php $extraHead .= ob_get_clean(); ?>