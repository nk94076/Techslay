<?php

declare(strict_types=1);

use App\Controllers\Front\BlogController;
use App\Controllers\Front\CaseStudyController;
use App\Controllers\Front\ContactController;
use App\Controllers\Front\HomeController;
use App\Controllers\Front\NewsletterController;
use App\Controllers\Front\PageController;
use App\Controllers\Front\SearchController;
use App\Controllers\Front\ServiceController;
use App\Controllers\Front\SitemapController;
use App\Core\Router;
use App\Middleware\CsrfMiddleware;

/** @var Router $router */

$router->get('/', [HomeController::class, 'index']);
$router->post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'], [CsrfMiddleware::class]);
$router->post('/contact/submit', [ContactController::class, 'submit'], [CsrfMiddleware::class]);

$router->get('/sitemap.xml', [SitemapController::class, 'xml']);
$router->get('/robots.txt', [SitemapController::class, 'robots']);
$router->get('/search', [SearchController::class, 'index']);

$router->get('/services', [ServiceController::class, 'index']);
$router->get('/services/{slug}', [ServiceController::class, 'show']);

$router->get('/case-studies', [CaseStudyController::class, 'index']);
$router->get('/case-studies/{slug}', [CaseStudyController::class, 'show']);

$router->get('/blog', [BlogController::class, 'index']);
$router->get('/blog/{slug}', [BlogController::class, 'show']);

// Any other CMS page (About, Publishers, Advertisers, Technology, Career,
// Contact, Privacy Policy, Terms, Cookie Policy, Disclaimer, ...) is served
// entirely from page_sections content — nothing page-specific is hardcoded.
$router->get('/{slug}', [PageController::class, 'show']);
