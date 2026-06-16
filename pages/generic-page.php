<?php
/**
 * Standart içerik sayfaları (Beach, Food, Spa vb.) için genel şablon.
 */
$pageTitle = t('seo_title');
$pageDescription = t('seo_description');

// Her sayfa için uygun banner resmini seçme (statik klasördeki mevcut isimlere göre geçici atama)
$bannerMap = [
    'beach' => 'images/pages/banners/01KSD59PRK4KX3R216JB6DRY14.webp',
    'food' => 'images/pages/banners/01KSFJJ2P3TD4EW752TJBHGNGG.jpg',
    'entertainment' => 'images/pages/banners/01KSFK33D8BRVR48NV3TP1R17F.jpg',
    'honeymoon' => 'images/pages/banners/01KSFKGB6KTYVWYKQA184PT80Z.png',
    'spa' => 'images/pages/banners/01KSFKXJ3ABYYMBTWG3KCK79X0.png',
    'meetings' => 'images/pages/banners/01KSFM85F2WH72M2HW66ZZX1N4.png'
];

$currentPageName = current_page();
$aliases = [
    'plaj-ve-havuzlar' => 'beach', 'yemek' => 'food', 'eglence' => 'entertainment',
    'balayi' => 'honeymoon', 'toplanti' => 'meetings'
];
$basePageName = $aliases[$currentPageName] ?? $currentPageName;

$bannerImage = $bannerMap[$basePageName] ?? '';

render_page_hero(
    t('title'),
    '',
    $bannerImage
);

render_page_content_intro(
    t('title'),
    '',
    t('content')
);

$components = t('components', []);

foreach ($components as $component) {
    $type = $component['type'] ?? '';
    $data = $component['data'] ?? [];

    switch ($type) {
        case 'features_list':
            render_features_list($data['title'] ?? '', $data['items'] ?? []);
            break;
        case 'timeline_section':
            render_timeline_section($data['items'] ?? []);
            break;
        case 'bars_section':
            render_bars_section($data['title'] ?? '', $data['bars'] ?? [], $data['notes'] ?? []);
            break;
        case 'meal_schedule':
            render_meal_schedule($data['title'] ?? '', $data['items'] ?? []);
            break;
        case 'info_table':
            render_info_table($data['title'] ?? '', $data['header_1'] ?? '', $data['header_2'] ?? '', $data['items'] ?? []);
            break;
        case 'info_notice':
            render_info_notice($data['title'] ?? '', $data['content'] ?? '');
            break;
    }
}
?>
