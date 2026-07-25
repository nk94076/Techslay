<?php

declare(strict_types=1);

return [
    'name' => env('APP_NAME', 'ClickNet'),
    'env' => env('APP_ENV', 'production'),
    'debug' => (bool) env('APP_DEBUG', false),
    'url' => rtrim((string) env('APP_URL', 'http://localhost'), '/'),
    'key' => env('APP_KEY', ''),
    'timezone' => 'Asia/Kolkata',

    'upload_max_size' => ((int) env('UPLOAD_MAX_SIZE_MB', 10)) * 1024 * 1024,
    'upload_allowed_images' => ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'],
    'upload_allowed_videos' => ['mp4', 'webm', 'mov'],
    'upload_allowed_documents' => ['pdf'],

    'admin_prefix' => 'admin',

    'maintenance_mode' => false,
];
