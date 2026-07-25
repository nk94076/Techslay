<?php

declare(strict_types=1);

use App\Controllers\Front\HomeController;
use App\Controllers\Front\NewsletterController;
use App\Core\Router;
use App\Middleware\CsrfMiddleware;

/** @var Router $router */

$router->get('/', [HomeController::class, 'index']);
$router->post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'], [CsrfMiddleware::class]);
