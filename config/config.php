<?php

declare(strict_types=1);

require_once __DIR__ . '/env.php';

// All timestamps are stored and compared in UTC — MySQL's NOW()/CURRENT_TIMESTAMP
// defaults are UTC on this server, so PHP-generated datetimes (published_at,
// scheduled_at, password reset expiry, etc.) must match or "publish at or
// before now" checks silently break. Convert to local time only for display.
date_default_timezone_set('UTC');

return [
    'app' => require __DIR__ . '/app.php',
    'database' => require __DIR__ . '/database.php',
];
