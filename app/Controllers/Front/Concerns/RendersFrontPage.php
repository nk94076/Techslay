<?php

declare(strict_types=1);

namespace App\Controllers\Front\Concerns;

use App\Models\CaseStudy;
use App\Models\Faq;
use App\Models\Industry;
use App\Models\Menu;
use App\Models\Page;
use App\Models\Service;
use App\Models\Statistic;
use App\Models\Testimonial;

/**
 * Shared renderer for any page built from page_sections. Every generic
 * section partial (statistics, services_grid, testimonials, faq, ...) can
 * appear on any page, so the same supporting data is always made available
 * regardless of which page/slug is being rendered.
 */
trait RendersFrontPage
{
    protected function renderPageBySlug(string $slug, array $overrides = []): void
    {
        $page = Page::findBySlug($slug);

        if ($page === null) {
            http_response_code(404);
            $this->view('front.errors.404', ['pageTitle' => 'Page Not Found'], 'front.layouts.main');

            return;
        }

        $sections = Page::sectionsFor((int) $page['id']);

        $data = array_merge([
            'pageTitle' => $page['title'],
            'sections' => $sections,
            'statistics' => Statistic::published(),
            'services' => Service::published(),
            'industries' => Industry::published(),
            'testimonials' => Testimonial::published(),
            'faqs' => Faq::byGroup('general'),
            'caseStudies' => CaseStudy::published(),
            'headerMenu' => Menu::itemsForLocation('header'),
            'footerMenu' => Menu::itemsForLocation('footer'),
        ], $overrides);

        $this->view('front.pages.dynamic', $data, 'front.layouts.main');
    }
}
