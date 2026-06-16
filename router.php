<?php
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Static dosyaları doğrudan sun (ancak dizinleri değil, sadece dosyaları)
if ($uri !== '/' && is_file(__DIR__ . $uri)) {
    return false;
}

// .htaccess rewrite kurallarını simüle et
$parts = explode('/', trim($uri, '/'));

// /lang/xx → dil değiştirme
if (count($parts) >= 2 && $parts[0] === 'lang' && in_array($parts[1], ['tr', 'en', 'de'])) {
    $_GET['set_lang'] = $parts[1];
}
// /odalar/slug → oda detay
elseif (count($parts) === 2 && $parts[0] === 'odalar') {
    $_GET['page'] = 'room-detail';
    $_GET['slug'] = $parts[1];
}
// /bilgi/slug → politika detay
elseif (count($parts) === 2 && $parts[0] === 'bilgi') {
    $_GET['page'] = 'policy';
    $_GET['slug'] = $parts[1];
}
// /xx/page → dil prefix ile sayfa (opsiyonel)
elseif (count($parts) > 0 && in_array($parts[0], ['tr', 'en', 'de'])) {
    $_GET['set_lang'] = $parts[0];
    $_GET['page'] = $parts[1] ?? 'home';
}
// /page-name → temiz URL
elseif (count($parts) > 0 && !empty($parts[0])) {
    $_GET['page'] = $parts[0];
}

require_once __DIR__ . '/index.php';
