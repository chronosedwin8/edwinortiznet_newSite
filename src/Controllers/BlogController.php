<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Models\Post;
use App\Services\I18n\I18n;

final class BlogController extends Controller
{
    private const PER_PAGE = 10;

    public function index(Request $request, ?string $n = null): Response
    {
        $locale = I18n::locale();
        $page = $n === null ? 1 : (int) $n;
        if ($n !== null && $page === 1) {
            return $this->redirect(route('blog'), 301);
        }
        $total = Post::countPublished($locale);
        $pages = max(1, (int) ceil($total / self::PER_PAGE));
        if ($page > $pages) {
            $this->notFound();
        }
        $posts = Post::latest($locale, self::PER_PAGE, ($page - 1) * self::PER_PAGE);
        $path = $page === 1 ? route('blog') : route('blog.page', ['n' => $page]);
        $crumbs = [[t('nav.home'), route('home')], [t('nav.blog'), route('blog')]];
        if ($page > 1) {
            $crumbs[] = [t('blog.page_n', ['n' => $page]), $path];
        }
        return $this->page('pages/blog', [
            'posts' => $posts,
            'page' => $page,
            'pages' => $pages,
            'crumbs' => $crumbs,
        ], [
            'title' => $page === 1 ? t('blog.seo_title') : t('blog.seo_title_page', ['n' => $page]),
            'description' => t('blog.seo_description'),
            'canonical' => $path,
            'alternates' => $page === 1 ? ['es' => route('blog', [], 'es'), 'en' => route('blog', [], 'en')] : [],
            'breadcrumbs' => $crumbs,
            'preload_image' => $posts[0]['cover_url'] ?? null,
            'body_class' => 'page-blog',
        ]);
    }
}
