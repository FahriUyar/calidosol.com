<header class="site-header py-3">
    <div class="container-fluid px-4 d-flex justify-content-between align-items-center">
        
        <!-- Sol Bölüm: Menü ve İletişim -->
        <div class="d-flex align-items-center gap-4">
            <button id="menu-toggle" class="btn btn-link text-dark text-decoration-none p-0 border-0 d-flex align-items-center gap-2 fw-medium" aria-label="Menüyü Aç" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                </svg>
                MENU
            </button>
            
            <div class="d-none d-lg-flex align-items-center gap-2">
                <?php if (config('contact_phone')): ?>
                <a href="tel:<?= e(preg_replace('/[^0-9+]/', '', config('contact_phone'))) ?>" class="header-icon-btn">
                    <i class="bi bi-telephone-fill" aria-hidden="true"></i>
                    <?= e(config('contact_phone')) ?>
                </a>
                <?php endif; ?>
                <a href="<?= e(whatsapp_url()) ?>" class="header-icon-btn icon-only" aria-label="WhatsApp" target="_blank" rel="noopener noreferrer"><i class="bi bi-whatsapp" aria-hidden="true"></i></a>
                <?php if (config('messenger_url')): ?>
                <a href="<?= e(config('messenger_url')) ?>" class="header-icon-btn icon-only" aria-label="Messenger" target="_blank" rel="noopener noreferrer"><i class="bi bi-messenger" aria-hidden="true"></i></a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Orta Bölüm: Logo -->
        <div class="logo text-center flex-grow-1">
            <a href="<?= e(base_url('/')) ?>" class="text-decoration-none d-inline-flex flex-column align-items-center">
                <?php if (config('site_logo')): ?>
                    <img src="<?= e(asset(config('site_logo'))) ?>" alt="<?= e(config('site_name')) ?> Logo" style="max-height: 65px; object-fit: contain;">
                <?php else: ?>
                    <div class="d-flex align-items-center">
                        <span class="fs-3 fw-bold" style="color: var(--color-primary);">CALIDO SOL</span>
                    </div>
                    <span class="text-muted" style="font-size: 0.7rem; letter-spacing: 2px;">— HOTEL —</span>
                <?php endif; ?>
            </a>
        </div>
        
        <!-- Sağ Bölüm: Dil ve Rezervasyon -->
        <div class="d-flex align-items-center gap-3">
            <div class="d-none d-md-flex text-muted small gap-1 fw-medium">
                <?php foreach (config('supported_locales', []) as $i => $locale): ?>
                    <a href="<?= e(lang_url($locale)) ?>" class="text-decoration-none <?= current_lang() === $locale ? 'text-dark fw-bold' : 'text-muted' ?>">
                        <?= strtoupper($locale) ?>
                    </a>
                    <?php if ($i < count(config('supported_locales', [])) - 1): ?>
                        <span class="text-muted opacity-50">|</span>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            
            <?php if (config('reservation_url')): ?>
            <a href="<?= e(config('reservation_url')) ?>" class="btn btn-primary-custom rounded-1" target="_blank" rel="noopener noreferrer">
                <i class="bi bi-calendar2-check" aria-hidden="true"></i> <?= e(t('menu.book_now')) ?>
            </a>
            <?php endif; ?>
        </div>

    </div>
</header>
