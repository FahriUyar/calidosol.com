<?php
/**
 * Yardımcı Fonksiyonlar — Calido Sol Hotel
 * Dil desteği, URL oluşturma ve güvenlik fonksiyonları.
 */

// Genel değişkenler
$GLOBALS['_lang'] = [];
$GLOBALS['_current_lang'] = 'tr';
$GLOBALS['_current_page'] = 'home';
$GLOBALS['_config'] = [];
$GLOBALS['_base_url'] = '';

/**
 * Projeyi başlatır: dil algılar, config yükler, dil dosyalarını yükler.
 */
function init_app(): void
{
    $config = require __DIR__ . '/config.php';
    $GLOBALS['_config'] = $config;

    // Base URL algılama
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $scriptDir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
    $GLOBALS['_base_url'] = $protocol . '://' . $host . $scriptDir;

    // Dil algılama
    $supported = $config['supported_locales'];
    $default = $config['default_locale'];
    $lang = $default;

    // 1. URL'den dil değiştirme: ?set_lang=de
    if (isset($_GET['set_lang']) && in_array($_GET['set_lang'], $supported, true)) {
        $lang = $_GET['set_lang'];
        setcookie('lang', $lang, time() + 86400 * 365, '/');
        // Redirect back to clean URL
        $redirect = $_SERVER['HTTP_REFERER'] ?? base_url('/');
        header('Location: ' . $redirect);
        exit;
    }

    // 2. Cookie'den dil okuma
    if (isset($_COOKIE['lang']) && in_array($_COOKIE['lang'], $supported, true)) {
        $lang = $_COOKIE['lang'];
    }

    // 3. ?lang= query parameter (doğrudan sayfa açma)
    if (isset($_GET['lang']) && in_array($_GET['lang'], $supported, true)) {
        $lang = $_GET['lang'];
        setcookie('lang', $lang, time() + 86400 * 365, '/');
    }

    $GLOBALS['_current_lang'] = $lang;

    // Sayfa algılama
    $page = $_GET['page'] ?? 'home';
    $page = preg_replace('/[^a-z0-9-]/', '', $page);
    if (empty($page)) $page = 'home';
    $GLOBALS['_current_page'] = $page;

    // Dil dosyalarını yükle — common her zaman yüklenir
    load_lang_file('common');

    // Sayfa bazlı dil dosyasını yükle
    $pageToLang = [
        'home'          => 'home',
        'odalar'        => 'rooms',
        'rooms'         => 'rooms',
        'room-detail'   => 'rooms',
        'beach'         => 'beach',
        'plaj-ve-havuzlar' => 'beach',
        'food'          => 'food',
        'yemek'         => 'food',
        'entertainment' => 'entertainment',
        'eglence'       => 'entertainment',
        'honeymoon'     => 'honeymoon',
        'balayi'        => 'honeymoon',
        'spa'           => 'spa',
        'meetings'      => 'meetings',
        'toplanti'      => 'meetings',
        'gallery'       => 'gallery',
        'galeri'        => 'gallery',
        'contact'       => 'contact',
        'iletisim'      => 'contact',
        'policy'        => 'policies',
    ];

    $langFile = $pageToLang[$page] ?? null;
    if ($langFile) {
        load_lang_file($langFile);
    }
}

/**
 * Dil dosyasını yükler ve global dil dizisine merge eder.
 */
function load_lang_file(string $filename): void
{
    $lang = $GLOBALS['_current_lang'];
    $path = __DIR__ . '/../lang/' . $lang . '/' . $filename . '.php';

    if (file_exists($path)) {
        $data = require $path;
        if (is_array($data)) {
            $GLOBALS['_lang'] = array_merge($GLOBALS['_lang'], $data);
        }
    }
}

/**
 * Çeviri fonksiyonu. Dot notation destekler: t('menu.home')
 */
function t(string $key, mixed $fallback = ''): mixed
{
    $keys = explode('.', $key);
    $value = $GLOBALS['_lang'];

    foreach ($keys as $k) {
        if (is_array($value) && isset($value[$k])) {
            $value = $value[$k];
        } else {
            return $fallback !== '' ? $fallback : $key;
        }
    }

    return $value !== null ? $value : ($fallback !== '' ? $fallback : $key);
}

/**
 * Aktif dili döndürür.
 */
function current_lang(): string
{
    return $GLOBALS['_current_lang'];
}

/**
 * Aktif sayfayı döndürür.
 */
function current_page(): string
{
    return $GLOBALS['_current_page'];
}

/**
 * Site yapılandırmasından bir değer döndürür.
 */
function config(string $key, $default = null)
{
    return $GLOBALS['_config'][$key] ?? $default;
}

/**
 * Dil değiştirme URL'i oluşturur.
 */
function lang_url(string $lang): string
{
    return base_url('/lang/' . $lang);
}

/**
 * Base URL ile birleştirilmiş yol döndürür.
 */
function base_url(string $path = ''): string
{
    return $GLOBALS['_base_url'] . '/' . ltrim($path, '/');
}

/**
 * Statik dosya yolu oluşturur (CSS, JS, görseller).
 */
function asset(string $path): string
{
    return base_url($path);
}

/**
 * Sayfa linkleri oluşturur. Temiz URL formatında.
 */
function page_url(string $page, string $slug = ''): string
{
    if ($page === 'home') return base_url('/');
    if ($slug) return base_url($page . '/' . $slug);
    return base_url($page);
}

/**
 * Verilen sayfanın aktif olup olmadığını kontrol eder.
 */
function is_current_page(string $page): bool
{
    $current = current_page();

    // Alias eşlemeleri
    $aliases = [
        'odalar' => 'rooms', 'rooms' => 'rooms', 'room-detail' => 'rooms',
        'plaj-ve-havuzlar' => 'beach', 'beach' => 'beach',
        'yemek' => 'food', 'food' => 'food',
        'eglence' => 'entertainment', 'entertainment' => 'entertainment',
        'balayi' => 'honeymoon', 'honeymoon' => 'honeymoon',
        'spa' => 'spa',
        'toplanti' => 'meetings', 'meetings' => 'meetings',
        'galeri' => 'gallery', 'gallery' => 'gallery',
        'iletisim' => 'contact', 'contact' => 'contact',
    ];

    $currentNorm = $aliases[$current] ?? $current;
    $pageNorm = $aliases[$page] ?? $page;

    return $currentNorm === $pageNorm;
}

/**
 * HTML escape — XSS koruması.
 */
function e(string $string): string
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Dil bazlı WhatsApp URL'ini döndürür.
 */
function whatsapp_url(): string
{
    $urls = config('whatsapp_url', []);
    return $urls[current_lang()] ?? ($urls['tr'] ?? '#');
}
