<?php

declare(strict_types=1);

use App\Core\Autoloader;
use App\Core\Router;
use App\Core\Session;

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

if ($config['app']['maintenance_mode']) {
    http_response_code(503);
    echo 'This site is currently undergoing maintenance. Please check back soon.';
    exit;
}

Session::start();

$router = new Router();
require BASE_PATH . '/routes/web.php';
require BASE_PATH . '/routes/admin.php';

$router->dispatch();
