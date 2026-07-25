<?php

declare(strict_types=1);

namespace App\Controllers\Front;

use App\Core\Controller;
use App\Models\CaseStudy;
use App\Models\Menu;

final class CaseStudyController extends Controller
{
    public function index(): void
    {
        $this->view('front.case-studies.index', [
            'pageTitle' => 'Case Studies',
            'caseStudies' => CaseStudy::published(),
            'headerMenu' => Menu::itemsForLocation('header'),
            'footerMenu' => Menu::itemsForLocation('footer'),
        ], 'front.layouts.main');
    }

    public function show(string $slug): void
    {
        $case = CaseStudy::findBySlug($slug);

        if ($case === null) {
            http_response_code(404);
            $this->view('front.errors.404', ['pageTitle' => 'Case Study Not Found'], 'front.layouts.main');

            return;
        }

        $this->view('front.case-studies.show', [
            'pageTitle' => $case['title'],
            'metaDescription' => $case['summary'],
            'case' => $case,
            'metrics' => json_decode((string) ($case['metrics'] ?? '[]'), true) ?: [],
            'headerMenu' => Menu::itemsForLocation('header'),
            'footerMenu' => Menu::itemsForLocation('footer'),
        ], 'front.layouts.main');
    }
}
