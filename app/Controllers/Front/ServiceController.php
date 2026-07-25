<?php

declare(strict_types=1);

namespace App\Controllers\Front;

use App\Core\Controller;
use App\Models\Menu;
use App\Models\Service;

final class ServiceController extends Controller
{
    public function index(): void
    {
        $this->view('front.services.index', [
            'pageTitle' => 'Our Services',
            'services' => Service::published(),
            'headerMenu' => Menu::itemsForLocation('header'),
            'footerMenu' => Menu::itemsForLocation('footer'),
        ], 'front.layouts.main');
    }

    public function show(string $slug): void
    {
        $service = Service::findBySlug($slug);

        if ($service === null) {
            http_response_code(404);
            $this->view('front.errors.404', ['pageTitle' => 'Service Not Found'], 'front.layouts.main');

            return;
        }

        $this->view('front.services.show', [
            'pageTitle' => $service['title'],
            'metaDescription' => $service['short_description'],
            'service' => $service,
            'otherServices' => array_slice(array_filter(Service::published(), static fn ($s) => $s['id'] !== $service['id']), 0, 3),
            'headerMenu' => Menu::itemsForLocation('header'),
            'footerMenu' => Menu::itemsForLocation('footer'),
        ], 'front.layouts.main');
    }
}
