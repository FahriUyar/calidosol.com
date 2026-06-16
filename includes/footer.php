<footer class="site-footer bg-dark text-white py-4 mt-auto">
    <div class="container-fluid px-4">
        <div class="row align-items-center">
            
            <!-- Sol: Logo -->
            <div class="col-md-3 mb-4 mb-md-0 text-center text-md-start">
                <a href="<?= e(base_url('/')) ?>" class="text-decoration-none d-inline-flex flex-column">
                    <?php if (config('site_logo')): ?>
                        <img src="<?= e(asset(config('site_logo'))) ?>" alt="<?= e(config('site_name')) ?> Logo" style="max-height: 50px; object-fit: contain; filter: brightness(0) invert(1); opacity: 0.8;" loading="lazy">
                    <?php else: ?>
                        <span class="fs-5 fw-bold text-white opacity-75">CALIDO SOL</span>
                    <?php endif; ?>
                </a>
            </div>

            <!-- Orta: İletişim & Sosyal Medya -->
            <div class="col-md-5 d-flex flex-column flex-md-row align-items-center gap-3 gap-md-4 mb-4 mb-md-0">
                <div class="text-white-50 small text-center text-md-start">
                    <?php if (config('contact_email')): ?>
                        <a href="mailto:<?= e(config('contact_email')) ?>" class="text-white-50 text-decoration-none me-3 d-block d-md-inline"><?= e(config('contact_email')) ?></a>
                    <?php endif; ?>
                    <?php if (config('contact_phone')): ?>
                        <span class="d-block d-md-inline <?= config('contact_email') ? 'border-md-start border-secondary ps-md-3' : '' ?>"><?= e(config('contact_phone')) ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="d-flex gap-3 mt-2 mt-md-0 justify-content-center">
                    <?php if (config('facebook_url')): ?>
                    <a href="<?= e(config('facebook_url')) ?>" class="text-white-50 text-decoration-none fs-5 hover-white" aria-label="Facebook" target="_blank" rel="noopener noreferrer"><i class="bi bi-facebook" aria-hidden="true"></i></a>
                    <?php endif; ?>
                    <?php if (config('instagram_url')): ?>
                    <a href="<?= e(config('instagram_url')) ?>" class="text-white-50 text-decoration-none fs-5 hover-white" aria-label="Instagram" target="_blank" rel="noopener noreferrer"><i class="bi bi-instagram" aria-hidden="true"></i></a>
                    <?php endif; ?>
                    <a href="<?= e(whatsapp_url()) ?>" class="text-white-50 text-decoration-none fs-5 hover-white" aria-label="WhatsApp" target="_blank" rel="noopener noreferrer"><i class="bi bi-whatsapp" aria-hidden="true"></i></a>
                    <?php if (config('messenger_url')): ?>
                    <a href="<?= e(config('messenger_url')) ?>" class="text-white-50 text-decoration-none fs-5 hover-white" aria-label="Messenger" target="_blank" rel="noopener noreferrer"><i class="bi bi-messenger" aria-hidden="true"></i></a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Sağ: Linkler -->
            <div class="col-md-4 text-center text-md-end">
                <div class="d-flex flex-wrap justify-content-center justify-content-md-end gap-3 mb-2">
                    <a href="<?= e(page_url('contact')) ?>" class="text-white-50 text-decoration-none small hover-white"><?= e(t('menu.contact')) ?></a>
                    <a href="<?= e(page_url('policy')) ?>" class="text-white-50 text-decoration-none small hover-white"><?= e(t('common.footer_policies')) ?></a>
                    <a href="<?= e(asset('docs/antalya-hakkinda.pdf')) ?>" target="_blank" rel="noopener noreferrer" class="text-white-50 text-decoration-none small hover-white"><?= e(t('common.footer_about_antalya')) ?></a>
                    <a href="<?= e(asset('docs/otel-kurallari.pdf')) ?>" target="_blank" rel="noopener noreferrer" class="text-white-50 text-decoration-none small hover-white"><?= e(t('common.footer_hotel_rules')) ?></a>
                </div>
                <p class="text-white-50 small mb-0">&copy; <?= date('Y') ?> <?= e(config('site_name')) ?>. <?= e(t('common.all_rights', 'Tüm hakları saklıdır.')) ?></p>
            </div>

        </div>
    </div>
</footer>
