<?php

declare(strict_types=1);

namespace App\Controllers\Front;

use App\Core\Controller;
use App\Core\Database;
use App\Models\Menu;

final class BlogController extends Controller
{
    private const PER_PAGE = 9;

    public function index(): void
    {
        $page = max(1, (int) $this->input('page', 1));
        $categorySlug = (string) $this->input('category', '');
        $offset = ($page - 1) * self::PER_PAGE;

        $where = "WHERE p.status = 'published' AND p.published_at <= NOW()";
        $params = [];

        if ($categorySlug !== '') {
            $where .= ' AND c.slug = :category';
            $params['category'] = $categorySlug;
        }

        $total = (int) (Database::fetchOne(
            "SELECT COUNT(*) AS total FROM blog_posts p LEFT JOIN blog_categories c ON c.id = p.category_id {$where}",
            $params
        )['total'] ?? 0);

        $posts = Database::fetchAll(
            "SELECT p.*, c.name AS category_name, c.slug AS category_slug, a.name AS author_name
             FROM blog_posts p
             LEFT JOIN blog_categories c ON c.id = p.category_id
             LEFT JOIN authors a ON a.id = p.author_id
             {$where}
             ORDER BY p.published_at DESC
             LIMIT " . self::PER_PAGE . ' OFFSET ' . $offset,
            $params
        );

        $this->view('front.blog.index', [
            'pageTitle' => 'Blog',
            'posts' => $posts,
            'categories' => Database::fetchAll('SELECT * FROM blog_categories ORDER BY name ASC'),
            'activeCategory' => $categorySlug,
            'currentPage' => $page,
            'lastPage' => (int) max(1, ceil($total / self::PER_PAGE)),
            'headerMenu' => Menu::itemsForLocation('header'),
            'footerMenu' => Menu::itemsForLocation('footer'),
        ], 'front.layouts.main');
    }

    public function show(string $slug): void
    {
        $post = Database::fetchOne(
            "SELECT p.*, c.name AS category_name, c.slug AS category_slug, a.name AS author_name, a.bio AS author_bio
             FROM blog_posts p
             LEFT JOIN blog_categories c ON c.id = p.category_id
             LEFT JOIN authors a ON a.id = p.author_id
             WHERE p.slug = :slug AND p.status = 'published' AND p.published_at <= NOW()",
            ['slug' => $slug]
        );

        if ($post === null) {
            http_response_code(404);
            $this->view('front.errors.404', ['pageTitle' => 'Post Not Found'], 'front.layouts.main');

            return;
        }

        Database::query('UPDATE blog_posts SET views = views + 1 WHERE id = :id', ['id' => $post['id']]);

        $related = Database::fetchAll(
            'SELECT p.* FROM blog_posts p
             JOIN blog_related_posts r ON r.related_post_id = p.id
             WHERE r.blog_post_id = :id AND p.status = "published"
             LIMIT 3',
            ['id' => $post['id']]
        );

        $tags = Database::fetchAll(
            'SELECT t.* FROM blog_tags t
             JOIN blog_post_tag pt ON pt.blog_tag_id = t.id
             WHERE pt.blog_post_id = :id',
            ['id' => $post['id']]
        );

        $this->view('front.blog.show', [
            'pageTitle' => $post['title'],
            'metaDescription' => $post['excerpt'],
            'post' => $post,
            'tableOfContents' => json_decode((string) ($post['table_of_contents'] ?? '[]'), true) ?: [],
            'related' => $related,
            'tags' => $tags,
            'headerMenu' => Menu::itemsForLocation('header'),
            'footerMenu' => Menu::itemsForLocation('footer'),
        ], 'front.layouts.main');
    }
}
