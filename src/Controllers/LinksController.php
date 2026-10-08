<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\DB;
use App\Core\Request;
use App\Core\Response;
use App\Services\Social\Catalog;
use App\Services\Social\ImageMaker;

/**
 * «Enlace en la bio» de Instagram (/enlaces/): lo último que se compartió en redes, con imagen y enlace,
 * más las secciones principales. Página ligera para el celular; noindex (es un índice de enlaces que ya
 * están en el sitio) y sin caché de página para que siempre muestre lo último publicado.
 */
final class LinksController extends Controller
{
    public const LIMIT = 12;

    public function index(Request $request): Response
    {
        $items = [];
        try {
            $keys = DB::column(
                "SELECT content_key FROM social_posts WHERE status = 'published' GROUP BY content_key ORDER BY MAX(published_at) DESC LIMIT " . self::LIMIT
            );
        } catch (\Throwable) {
            $keys = []; // sin la migración 018 todavía
        }
        foreach ($keys as $key) {
            $item = Catalog::item((string) $key);
            if ($item !== null) {
                $items[$item['key']] = $item;
            }
        }
        // Mientras haya pocas publicaciones, se completa con lo más reciente del blog.
        if (count($items) < self::LIMIT) {
            foreach (DB::column("SELECT id FROM posts WHERE locale = 'es' AND type = 'post' AND status = 'published' AND published_at <= UTC_TIMESTAMP() ORDER BY published_at DESC LIMIT 24") as $id) {
                if (count($items) >= self::LIMIT) {
                    break;
                }
                $item = isset($items['post:' . $id]) ? null : Catalog::item('post:' . $id);
                if ($item !== null) {
                    $items[$item['key']] = $item;
                }
            }
        }
        $cards = [];
        foreach ($items as $item) {
            $image = $item['cover'] ?? null;
            if ($image === null) {
                $image = ImageMaker::facebook($item);
            }
            $cards[] = [
                'title' => $item['title'],
                'kicker' => ImageMaker::kicker($item),
                'url' => self::utm((string) $item['path']),
                'image' => $image,
                'srcset' => !empty($item['cover']) ? ($item['srcset'] ?? null) : null,
            ];
        }
        $sections = [
            [t('links.blog'), route('blog', [], 'es')],
            [t('links.shop'), route('shop', [], 'es')],
            [t('links.tools'), route('tools', [], 'es')],
        ];
        foreach (DB::all("SELECT t.slug, COALESCE(t.menu_title, t.title) AS title FROM hubs h JOIN hub_translations t ON t.hub_id = h.id AND t.locale = 'es' WHERE h.`key` IN ('excel', 'ia-para-docentes', 'concurso-docente') ORDER BY h.sort") as $hub) {
            $sections[] = [(string) $hub['title'], '/' . $hub['slug'] . '/'];
        }
        $sections = array_map(fn ($s) => [$s[0], self::utm($s[1])], $sections);
        return $this->page('pages/links', ['cards' => $cards, 'sections' => $sections], [
            'title' => t('links.title'),
            'description' => t('links.description'),
            'noindex' => true,
            'body_class' => 'page-links',
            'styles' => ['css/links.css'],
        ])->header('Cache-Control', 'public, max-age=300');
    }

    private static function utm(string $path): string
    {
        return $path . (str_contains($path, '?') ? '&' : '?') . 'utm_source=instagram&utm_medium=social&utm_campaign=bio';
    }
}
