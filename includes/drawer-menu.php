<div id="drawer-menu" popover="manual" aria-label="Ana Menü">
    <div class="drawer-sheet" tabindex="-1">
        
        <div class="drawer-close-wrapper">
            <button id="menu-close-btn" class="btn btn-link text-white text-decoration-none p-0 d-flex align-items-center gap-2" aria-label="Menüyü Kapat">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854z"/>
                </svg>
                <span class="fs-5 fw-medium">MENU</span>
            </button>
        </div>
        
        <nav class="drawer-nav flex-grow-1 mt-3">
            <ul>
                <li><a href="<?= e(base_url('/')) ?>" class="<?= is_current_page('home') ? 'fw-bold active' : '' ?>"><?= e(t('menu.home')) ?></a></li>
                <li><a href="<?= e(base_url('odalar')) ?>" class="<?= is_current_page('rooms') ? 'fw-bold active' : '' ?>"><?= e(t('menu.rooms')) ?></a></li>
                <li><a href="<?= e(base_url('beach')) ?>" class="<?= is_current_page('beach') ? 'fw-bold active' : '' ?>"><?= e(t('menu.beach')) ?></a></li>
                <li><a href="<?= e(base_url('food')) ?>" class="<?= is_current_page('food') ? 'fw-bold active' : '' ?>"><?= e(t('menu.food')) ?></a></li>
                <li><a href="<?= e(base_url('entertainment')) ?>" class="<?= is_current_page('entertainment') ? 'fw-bold active' : '' ?>"><?= e(t('menu.entertainment')) ?></a></li>
                <li><a href="<?= e(base_url('honeymoon')) ?>" class="<?= is_current_page('honeymoon') ? 'fw-bold active' : '' ?>"><?= e(t('menu.honeymoon')) ?></a></li>
                <li><a href="<?= e(base_url('spa')) ?>" class="<?= is_current_page('spa') ? 'fw-bold active' : '' ?>"><?= e(t('menu.spa')) ?></a></li>
                <li><a href="<?= e(base_url('meetings')) ?>" class="<?= is_current_page('meetings') ? 'fw-bold active' : '' ?>"><?= e(t('menu.meetings')) ?></a></li>
                <li><a href="<?= e(base_url('gallery')) ?>" class="<?= is_current_page('gallery') ? 'fw-bold active' : '' ?>"><?= e(t('menu.gallery')) ?></a></li>
                <li><a href="<?= e(base_url('contact')) ?>" class="<?= is_current_page('contact') ? 'fw-bold active' : '' ?>"><?= e(t('menu.contact')) ?></a></li>
            </ul>
        </nav>

        <div class="drawer-footer">
        <div class="mt-auto pt-4 border-top border-light border-opacity-25 d-flex gap-4">
            <?php if (config('contact_phone')): ?>
            <a href="tel:<?= e(preg_replace('/[^0-9+]/', '', config('contact_phone'))) ?>" class="text-white fs-4" aria-label="Phone"><i class="bi bi-telephone-fill" aria-hidden="true"></i></a>
            <?php endif; ?>
            <a href="<?= e(whatsapp_url()) ?>" class="text-white fs-4" aria-label="WhatsApp" target="_blank" rel="noopener noreferrer"><i class="bi bi-whatsapp" aria-hidden="true"></i></a>
            <?php if (config('messenger_url')): ?>
            <a href="<?= e(config('messenger_url')) ?>" class="text-white fs-4" aria-label="Messenger" target="_blank" rel="noopener noreferrer"><i class="bi bi-messenger" aria-hidden="true"></i></a>
            <?php endif; ?>
        </div>
            
            <div class="lang-pill-container shadow-sm">
                <?php foreach (config('supported_locales', []) as $locale): ?>
                    <a href="<?= e(lang_url($locale)) ?>" class="<?= current_lang() === $locale ? 'active' : '' ?>">
                        <?= strtoupper($locale) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        
    </div>
</div>
