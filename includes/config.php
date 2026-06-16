<?php

/**
 * Site Ayarları — Calido Sol Hotel
 * Veritabanındaki settings tablosundan taşınan sabit yapılandırma.
 */

return [
    'site_name'       => 'Calido Sol Hotel',
    'contact_email'   => 'info@calidosol.com.tr',
    'contact_phone'   => '+90 242 524 56 60',
    'contact_address' => 'River Tourism Center, Okurcalar, Okurcalar Alara Yolu, 07415 Alanya/Antalya',
    'reservation_url' => 'https://sara.holidayplus.pro/onlinehotelbooking/?widget_id=62&hotel_id=23&customer=saratur&key=y18YylBS83bvu6TxprTArg3q84L3q84L',

    // Sosyal Medya
    'facebook_url'   => 'https://www.facebook.com/calidosol.official/',
    'instagram_url'  => 'https://www.instagram.com/calidosol.official/',
    'messenger_url'  => 'https://m.me/calidosolhotel',

    // WhatsApp — dil bazlı
    'whatsapp_url' => [
        'tr' => 'https://api.whatsapp.com/send/?phone=902425245660&text=Merhaba%21+Otelinizdeki+oda+se%C3%A7enekleri+ve+fiyatlar%C4%B1+%C3%B6%C4%9Frenebilir+miyim%3F&app_absent=0',
        'en' => 'https://api.whatsapp.com/send/?phone=902425245660&text=Hello%21+Could+I+get+information+about+room+options+and+prices+at+your+hotel%3F&app_absent=0',
        'de' => 'https://api.whatsapp.com/send/?phone=902425245660&text=Hallo%21+K%C3%B6nnte+ich+Informationen+%C3%BCber+die+Zimmeroptionen+und+Preise+in+Ihrem+Hotel+bekommen%3F&app_absent=0',
    ],

    // Google Maps
    'google_maps_iframe' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d38671.35398257438!2d31.635632799264233!3d36.668007976063066!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14dcace7e813508b%3A0xe609a7696782ccce!2sHotel%20Calido%20Sol!5e0!3m2!1str!2str!4v1779632117764!5m2!1str!2str" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',

    // Logo & Favicon
    'site_logo'    => 'images/settings/logo/logo.webp',
    'site_favicon' => 'images/settings/favicon/favicon.png',

    // Desteklenen diller
    'supported_locales' => ['tr', 'en', 'de'],
    'default_locale'    => 'tr',
];
