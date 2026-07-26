<?php

declare(strict_types=1);

use App\Core\Autoloader;
use App\Core\Router;
use App\Core\Session;
use App\Core\View;
use App\Models\Setting;

const BASE_PATH = __DIR__ . '/..';

require BASE_PATH . '/app/Core/Autoloader.php';
Autoloader::register(BASE_PATH);

$config = require BASE_PATH . '/config/config.php';

error_reporting($config['app']['debug'] ? E_ALL : 0);
ini_set('display_errors', $config['app']['debug'] ? '1' : '0');

set_exception_handler(static function (Throwable $e) use ($config): void {
    \App\Core\Logger::error($e->getMessage(), ['file' => $e->getFile(), 'line' => $e->getLine()]);
    http_response_code(500);

    if ($config['app']['debug']) {
        echo '<pre>' . htmlspecialchars((string) $e, ENT_QUOTES, 'UTF-8') . '</pre>';
    } else {
        echo 'Something went wrong. Please try again later.';
    }
});

$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
$isAdminPath = str_starts_with($requestPath, '/admin');

// The config flag is a file-level kill switch (works even if the database is
// unreachable); the Settings-backed flags are the normal admin-toggleable
// path. Either can trigger it. The admin area is always exempt so an admin
// can still log in and turn maintenance mode back off.
if (!$isAdminPath && ($config['app']['maintenance_mode'] || Setting::get('general', 'maintenance_mode') === 'true')) {
    http_response_code(503);
    View::output('front.errors.maintenance', [
        'siteName' => Setting::get('branding', 'site_name', $config['app']['name']),
        'heading' => 'Under Maintenance',
        'message' => Setting::get('general', 'maintenance_message', 'We are currently performing scheduled maintenance. Please check back soon.'),
    ]);
    exit;
}

if (!$isAdminPath && Setting::get('general', 'coming_soon_mode') === 'true') {
    http_response_code(503);
    View::output('front.errors.maintenance', [
        'siteName' => Setting::get('branding', 'site_name', $config['app']['name']),
        'heading' => 'Coming Soon',
        'message' => 'We are putting the finishing touches on our new site. Check back soon.',
    ]);
    exit;
}

Session::start();

$router = new Router();
require BASE_PATH . '/routes/web.php';
require BASE_PATH . '/routes/admin.php';

$router->dispatch();
