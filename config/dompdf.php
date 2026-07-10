<?php

return [

    'show_warnings' => false,
    'public_path' => null,
    'convert_entities' => true,

    'options' => [

        'default_font' => 'Amiri',
        'font_dir' => base_path('public/fonts/'),
        'font_cache' => storage_path('fonts/'),
        'isHtml5ParserEnabled' => true,
        'isRemoteEnabled' => true,



      

        // 🔹 السماح بالملفات المحلية
        'chroot' => realpath(base_path()),

        // إعدادات إضافية افتراضية
        'pdf_backend' => 'CPDF',
        'default_media_type' => 'screen',
        'default_paper_size' => 'a4',
        'default_paper_orientation' => 'portrait',
        'dpi' => 96,
        'enable_php' => false,
        'enable_javascript' => true,
        'enable_remote' => true,
        'font_height_ratio' => 1.1,
        'enable_html5_parser' => true,
    ],
];
