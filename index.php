<?php
/**
 * Calido Sol Hotel — Front Controller
 * Tüm istekleri karşılar, dil ve sayfa algılaması yapar,
 * layout'u sararak ilgili sayfa dosyasını yükler.
 */

// Yardımcı fonksiyonları yükle
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/components.php';

// Uygulamayı başlat (dil algıla, config yükle, dil dosyalarını yükle)
init_app();

// Sayfa dosyası eşlemesi
$pageMap = [
    'home'          => 'home',
    'odalar'        => 'rooms',
    'rooms'         => 'rooms',
    'room-detail'   => 'room-detail',
    'beach'         => 'generic-page',
    'plaj-ve-havuzlar' => 'generic-page',
    'food'          => 'generic-page',
    'yemek'         => 'generic-page',
    'entertainment' => 'generic-page',
    'eglence'       => 'generic-page',
    'honeymoon'     => 'generic-page',
    'balayi'        => 'generic-page',
    'spa'           => 'generic-page',
    'meetings'      => 'generic-page',
    'toplanti'      => 'generic-page',
    'gallery'       => 'gallery',
    'galeri'        => 'gallery',
    'contact'       => 'contact',
    'iletisim'      => 'contact',
    'policy'        => 'policy',
];

$currentPage = current_page();
$pageFile = $pageMap[$currentPage] ?? null;

// Sayfa dosyası var mı kontrol et
if ($pageFile === null || !file_exists(__DIR__ . '/pages/' . $pageFile . '.php')) {
    // 404
    http_response_code(404);
    $pageFile = 'home'; // Fallback olarak anasayfayı göster
}

// Sayfa meta bilgileri (sayfa dosyaları $pageTitle ve $pageDescription set edebilir)
$pageTitle = config('site_name');
$pageDescription = 'Calido Sol Hotel - Eşsiz tatil deneyimi';
$pageImage = asset('images/og-default.jpg');
$extraHead = '';
$extraScripts = '';

// Output buffering ile sayfa içeriğini yakala
ob_start();
require __DIR__ . '/pages/' . $pageFile . '.php';
$pageContent = ob_get_clean();

// HTML çıktısını oluştur
?>
<!DOCTYPE html>
<html lang="<?= e(current_lang()) ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Dynamic Meta Details -->
    <title><?= e($pageTitle) ?></title>
    <meta name="description" content="<?= e($pageDescription) ?>">
    <link rel="canonical" href="<?= e(base_url($_SERVER['REQUEST_URI'] ?? '/')) ?>">
    
    <?php foreach (config('supported_locales', []) as $locale): ?>
        <link rel="alternate" hreflang="<?= e($locale) ?>" href="<?= e(base_url('/')) ?>">
    <?php endforeach; ?>
    <link rel="alternate" hreflang="x-default" href="<?= e(base_url('/')) ?>">
    
    <!-- Favicon -->
    <?php if (config('site_favicon')): ?>
        <link rel="icon" type="image/png" href="<?= e(asset(config('site_favicon'))) ?>">
    <?php else: ?>
        <link rel="icon" type="image/x-icon" href="<?= e(asset('favicon.ico')) ?>">
    <?php endif; ?>
    
    <!-- Open Graph & Twitter Card -->
    <meta property="og:title" content="<?= e($pageTitle) ?>">
    <meta property="og:description" content="<?= e($pageDescription) ?>">
    <meta property="og:image" content="<?= e($pageImage) ?>">
    <meta property="og:url" content="<?= e(base_url($_SERVER['REQUEST_URI'] ?? '/')) ?>">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">

    <!-- Preconnect for Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Montserrat:wght@500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3 CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Splide CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">

    <!-- Global CSS -->
    <link href="<?= e(asset('css/app.css')) ?>" rel="stylesheet">

    <?= $extraHead ?>
</head>
<body>
    
    <?php require __DIR__ . '/includes/header.php'; ?>
    <?php require __DIR__ . '/includes/drawer-menu.php'; ?>

    <main id="main-content">
        <?= $pageContent ?>
    </main>

    <?php require __DIR__ . '/includes/footer.php'; ?>

    <!-- Bootstrap 5.3 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmxc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <!-- Global JS -->
    <script src="<?= e(asset('js/app.js')) ?>"></script>

    <!-- Splide JS -->
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    
    <?= $extraScripts ?>
</body>
</html>
