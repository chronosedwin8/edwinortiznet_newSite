<?php

declare(strict_types=1);

namespace App\Services\Search;

use App\Core\DB;

/**
 * Búsqueda con índices FULLTEXT (modo booleano con prefijos) y respaldo LIKE para términos cortos.
 */
final class Search
{
    /** @return array{posts: array, products: array} */
    public static function run(string $query, string $locale, int $limitPosts = 6, int $limitProducts = 4): array
    {
        $query = trim(mb_substr($query, 0, 100));
        if (mb_strlen($query) < 2) {
            return ['posts' => [], 'products' => []];
        }
        $terms = array_values(array_filter(
            preg_split('/[^\p{L}\p{N}]+/u', mb_strtolower($query)) ?: [],
            fn ($t) => mb_strlen($t) >= 2
        ));
        if ($terms === []) {
            return ['posts' => [], 'products' => []];
        }
        $long = array_values(array_filter($terms, fn ($t) => mb_strlen($t) >= 3));
        if ($long !== []) {
            $boolean = implode(' ', array_map(fn ($t) => '+' . $t . '*', $long));
            $posts = DB::all(
                'SELECT id, type, locale, slug, title, excerpt, cover_url, published_at,
                        MATCH(title, excerpt, content_text) AGAINST(:q1 IN BOOLEAN MODE) * 1 + (title LIKE :like) * 5 AS score
                 FROM posts
                 WHERE locale = :l AND status = "published" AND type IN ("post","page")
                   AND MATCH(title, excerpt, content_text) AGAINST(:q2 IN BOOLEAN MODE)
                 ORDER BY score DESC, published_at DESC LIMIT ' . (int) $limitPosts,
                ['q1' => $boolean, 'q2' => $boolean, 'l' => $locale, 'like' => '%' . $long[0] . '%']
            );
            $products = DB::all(
                'SELECT p.id, t.slug, t.title, t.locale, p.price_cop, p.price_usd, p.status, p.cover_url,
                        MATCH(t.title, t.search_text) AGAINST(:q1 IN BOOLEAN MODE) + (t.title LIKE :like) * 5 AS score
                 FROM product_translations t JOIN products p ON p.id = t.product_id
                 WHERE t.locale = :l AND p.status IN ("active","coming_soon")
                   AND MATCH(t.title, t.search_text) AGAINST(:q2 IN BOOLEAN MODE)
                 ORDER BY score DESC LIMIT ' . (int) $limitProducts,
                ['q1' => $boolean, 'q2' => $boolean, 'l' => $locale, 'like' => '%' . $long[0] . '%']
            );
        } else {
            $like = '%' . $terms[0] . '%';
            $posts = DB::all(
                'SELECT id, type, locale, slug, title, excerpt, cover_url, published_at FROM posts
                 WHERE locale = :l AND status = "published" AND type IN ("post","page") AND title LIKE :q
                 ORDER BY published_at DESC LIMIT ' . (int) $limitPosts,
                ['l' => $locale, 'q' => $like]
            );
            $products = DB::all(
                'SELECT p.id, t.slug, t.title, t.locale, p.price_cop, p.price_usd, p.status, p.cover_url FROM product_translations t
                 JOIN products p ON p.id = t.product_id
                 WHERE t.locale = :l AND p.status IN ("active","coming_soon") AND t.title LIKE :q LIMIT ' . (int) $limitProducts,
                ['l' => $locale, 'q' => $like]
            );
        }
        return ['posts' => $posts, 'products' => $products];
    }
}
