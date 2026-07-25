<?php

declare(strict_types=1);

require_once __DIR__ . '/env.php';

date_default_timezone_set('Asia/Kolkata');

return [
    'app' => require __DIR__ . '/app.php',
    'database' => require __DIR__ . '/database.php',
];
