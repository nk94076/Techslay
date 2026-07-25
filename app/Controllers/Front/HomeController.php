<?php

declare(strict_types=1);

namespace App\Controllers\Front;

use App\Core\Controller;
use App\Models\Faq;
use App\Models\Industry;
use App\Models\Menu;
use App\Models\Page;
use App\Models\Service;
use App\Models\Statistic;
use App\Models\Testimonial;

final class HomeController extends Controller
{
    public function index(): void
    {
        $page = Page::findBySlug('home');
        $sections = $page !== null ? Page::sectionsFor((int) $page['id']) : [];

        $this->view('front.home.index', [
            'pageTitle' => 'Performance Affiliate Network for Advertisers & Publishers',
            'metaDescription' => 'ClickNet connects advertisers and publishers through transparent CPS, CPL and CPI performance marketing campaigns.',
            'sections' => $sections,
            'statistics' => Statistic::published(),
            'services' => Service::published(),
            'industries' => Industry::published(),
            'testimonials' => Testimonial::published(),
            'faqs' => Faq::byGroup('general'),
            'headerMenu' => Menu::itemsForLocation('header'),
            'footerMenu' => Menu::itemsForLocation('footer'),
        ], 'front.layouts.main');
    }
}
