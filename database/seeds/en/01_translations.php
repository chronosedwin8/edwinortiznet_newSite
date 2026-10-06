<?php

declare(strict_types=1);

use App\Core\DB;
use App\Services\Importer\HtmlCleaner;
use App\Services\Importer\WxrImporter;

/*
 * Traducciones al inglés (todas con needs_review = 1 para que Edwin las revise en el panel).
 * Fuente: database/seeds/en/data/*.php. No toca el contenido en español.
 */
return static function (): string {
    $data = __DIR__ . '/data';
    $cleaner = new HtmlCleaner();
    $count = ['hubs' => 0, 'families' => 0, 'products' => 0, 'posts' => 0, 'pages' => 0];

    // --- Hubs -----------------------------------------------------------------------------
    $hubs = [
        'excel' => [
            'slug' => 'excel-automation',
            'title' => 'Excel automation for office work',
            'menu_title' => 'Excel automation',
            'seo_title' => 'Excel automation: guides and templates for office work',
            'seo_description' => 'Automate Excel and Word: bulk emails with attachments, mail merge to individual PDFs, QR codes and barcodes. Step-by-step guides and ready-made templates.',
            'intro' => <<<'HTML'
<p>If every week you repeat the same tasks in Excel and Word — sending dozens of emails with different attachments, creating one PDF for every row of a list, numbering invoices or generating QR codes for an inventory — this is where you learn to stop doing it by hand.</p>
<p>These guides come from years of teaching office software to teachers, administrative assistants and small business owners. Each tutorial explains the full procedure so you can build it yourself, and at the end you’ll find the ready-to-use template that applies the same logic, tested and with email support.</p>
<p>A note before you start: the screenshots and the templates show Spanish-language Excel and Word. Every English guide names the English menu or function and, the first time it appears, the Spanish name you’ll see in the images.</p>
<p>Where to start? If you send bulk email, go straight to the guide on sending emails with attachments from Excel and Outlook. If you produce certificates, letters or reports, see how to mail merge into separate documents. If you manage inventory, look at the QR code and barcode generators.</p>
HTML,
            'faq' => [
                ['q' => 'Which version of Excel do the templates need?', 'a' => 'The macro-based templates work in Excel for Windows (2016, 2019, 2021 and Microsoft 365) with macros enabled. Each product page lists its exact requirements.'],
                ['q' => 'Are the templates in English?', 'a' => 'The template interface is in Spanish; each product page says whether an English version exists. An English quick-start guide is included with every purchase.'],
                ['q' => 'Do they work on Excel for Mac or Excel on the web?', 'a' => 'Templates that use VBA macros and desktop Outlook do not work in Excel on the web and have limitations on Mac. Check the requirements before buying.'],
            ],
        ],
        'ia-para-docentes' => [
            'slug' => 'ai-for-teachers',
            'title' => 'AI and technology for teachers',
            'menu_title' => 'AI for teachers',
            'seo_title' => 'AI and technology for teachers: practical classroom guides',
            'seo_description' => 'Practical ideas to use artificial intelligence and technology in the classroom and to automate a teacher’s admin work, from a teacher with 20+ years of experience.',
            'intro' => <<<'HTML'
<p>I have spent more than twenty years in the classroom teaching math and technology, and I know a teacher’s time never stretches far enough: planning, grading, paperwork, meetings — and on top of that, keeping up with tools that change every month.</p>
<p>This section gathers what has worked for me to make technology serve the teacher and not the other way round: using artificial intelligence to prepare materials without giving up your professional judgement, and automating admin tasks with Excel and Word so you have more time for your students.</p>
<p>Here you’ll find reviews of classroom tools, from AI assistants for planning and grading to platforms for teaching programming, along with analyses of education in Colombia, Latin America and the world written from the point of view of teachers, families and students.</p>
HTML,
            'faq' => [
                ['q' => 'Can I use AI to plan my lessons?', 'a' => 'Yes, as support for ideas, examples and first drafts. Always review the result: AI makes mistakes and doesn’t know your group.'],
                ['q' => 'Do I need programming skills?', 'a' => 'No. The guides are written for teachers of any subject and explain every step.'],
            ],
        ],
        'herramientas' => [
            'slug' => 'tools',
            'title' => 'Free tools',
            'menu_title' => 'Tools',
            'seo_title' => 'Free tools: QR code generator and number to words',
            'seo_description' => 'Free tools that run in your browser without sending your data anywhere: a QR code generator with PNG and SVG download and a number-to-words converter.',
            'intro' => <<<'HTML'
<p>These tools solve small tasks that come up every day at the office and at school. They run right in your browser: what you type is never sent to a server, you don’t need an account, and once the page has loaded they even work offline.</p>
<p>The QR code generator creates codes for links or text and downloads them as PNG or SVG, ready to print. The number-to-words converter writes amounts in words, with an optional dollars-and-cents format for cheques and invoices.</p>
<p>If you need to do the same thing hundreds of times — say, one QR code per product in your inventory — each tool links to its automated Excel version.</p>
HTML,
            'faq' => [
                ['q' => 'Is my data stored anywhere?', 'a' => 'No. The tools run in your browser and never send what you type to the server.'],
                ['q' => 'Can I use the QR codes commercially?', 'a' => 'Yes. The codes are yours and never expire: they contain the text or link you typed.'],
            ],
        ],
    ];
    foreach ($hubs as $key => $h) {
        $hubId = DB::value('SELECT id FROM hubs WHERE `key` = :k', ['k' => $key]);
        if ($hubId === null) {
            continue;
        }
        DB::upsert('hub_translations', [
            'hub_id' => (int) $hubId, 'locale' => 'en', 'slug' => $h['slug'], 'title' => $h['title'], 'menu_title' => $h['menu_title'],
            'intro_html' => $h['intro'], 'faq_json' => json_encode($h['faq'], JSON_UNESCAPED_UNICODE),
            'seo_title' => $h['seo_title'], 'seo_description' => $h['seo_description'], 'needs_review' => 1,
        ], ['hub_id', 'locale']);
        $count['hubs']++;
    }

    // --- Familias -------------------------------------------------------------------------
    foreach ((require "$data/families.php") as $key => $f) {
        $familyId = DB::value('SELECT id FROM product_families WHERE `key` = :k', ['k' => $key]);
        if ($familyId === null) {
            continue;
        }
        DB::upsert('product_family_translations', [
            'family_id' => (int) $familyId, 'locale' => 'en', 'slug' => $f['slug'], 'name' => $f['name'],
            'description_html' => $f['description_html'], 'needs_review' => 1,
        ], ['family_id', 'locale']);
        $count['families']++;
    }

    // --- Mapa de enlaces internos ES → EN (para reescribir enlaces en los textos traducidos) ---
    $posts = [];
    foreach (glob("$data/posts-*.php") ?: [] as $file) {
        $posts += require $file;
    }
    $products = require "$data/products.php";
    $linkMap = [];
    foreach ($posts as $wpId => $p) {
        $es = DB::value('SELECT slug FROM posts WHERE wp_id = :w', ['w' => $wpId]);
        if ($es !== null) {
            $linkMap["/$es/"] = "/en/{$p['slug']}/";
        }
    }
    foreach ($products as $wpId => $p) {
        $es = DB::value('SELECT t.slug FROM product_translations t JOIN products p ON p.id = t.product_id WHERE p.wp_id = :w AND t.locale = "es"', ['w' => $wpId]);
        if ($es !== null) {
            $linkMap["/producto/$es/"] = "/en/product/{$p['slug']}/";
        }
    }
    $linkMap += ['/excel/' => '/en/excel-automation/', '/herramientas/' => '/en/tools/', '/tienda/' => '/en/shop/', '/sobre-mi/' => '/en/about/', '/contacto/' => '/en/contact/'];
    $rewrite = static function (string $html) use ($linkMap): string {
        return (string) preg_replace_callback('#href="(/[^"\#?]*)([^"]*)"#', function (array $m) use ($linkMap): string {
            $path = $m[1] === '' ? '/' : $m[1];
            if (!str_ends_with($path, '/')) {
                $path .= '/';
            }
            return isset($linkMap[$path]) ? 'href="' . $linkMap[$path] . $m[2] . '"' : $m[0];
        }, $html);
    };

    // --- Productos ------------------------------------------------------------------------
    foreach ($products as $wpId => $p) {
        $productId = DB::value('SELECT id FROM products WHERE wp_id = :w', ['w' => $wpId]);
        if ($productId === null) {
            continue;
        }
        $short = $rewrite($cleaner->sanitize((string) $p['short_html']));
        $desc = $rewrite($cleaner->sanitize((string) $p['description_html']));
        DB::upsert('product_translations', [
            'product_id' => (int) $productId, 'locale' => 'en', 'slug' => $p['slug'], 'title' => $p['title'],
            'short_html' => $short, 'description_html' => $desc,
            'includes_html' => $p['includes_html'] ?? null, 'requirements' => $p['requirements'] ?? null,
            'license_text' => $p['license_text'] ?? null,
            'faq_json' => json_encode($p['faq'] ?? [], JSON_UNESCAPED_UNICODE),
            'search_text' => HtmlCleaner::toText($p['title'] . ' ' . $short . ' ' . $desc),
            'seo_title' => $p['seo_title'] ?? null, 'seo_description' => $p['seo_description'] ?? null, 'needs_review' => 1,
        ], ['product_id', 'locale']);
        $count['products']++;
    }

    // --- Artículos tutoriales -------------------------------------------------------------
    foreach ($posts as $wpId => $p) {
        $source = DB::one('SELECT * FROM posts WHERE wp_id = :w', ['w' => $wpId]);
        if ($source === null) {
            continue;
        }
        $html = $rewrite($cleaner->sanitize((string) $p['content_html'], ['title' => $p['title']]));
        $text = HtmlCleaner::toText($html);
        $postId = DB::upsert('posts', [
            'type' => 'post', 'locale' => 'en', 'translation_group' => $source['translation_group'],
            'slug' => $p['slug'], 'title' => $p['title'], 'excerpt' => $p['excerpt'],
            'content_html' => $html, 'content_text' => $text,
            'cover_url' => $source['cover_url'], 'cover_alt' => $p['title'],
            'cover_width' => $source['cover_width'], 'cover_height' => $source['cover_height'], 'cover_srcset' => $source['cover_srcset'],
            'hub_id' => $source['hub_id'], 'related_product_id' => $source['related_product_id'],
            'status' => 'published', 'seo_title' => $p['seo_title'], 'seo_description' => $p['seo_description'],
            'focus_keyword' => $p['focus_keyword'] ?? null, 'reading_minutes' => HtmlCleaner::readingMinutes($text),
            'needs_review' => 1, 'published_at' => $source['published_at'], 'updated_at' => $source['updated_at'],
        ], ['locale', 'slug']);
        DB::run('INSERT IGNORE INTO post_category (post_id, category_id, is_primary) SELECT :n, category_id, is_primary FROM post_category WHERE post_id = :s', ['n' => $postId, 's' => (int) $source['id']]);
        $count['posts']++;
    }

    // --- Sobre mí y políticas -------------------------------------------------------------
    $groups = ['sobre-mi' => 'page-about', 'privacidad' => 'policy-privacy', 'terminos' => 'policy-terms', 'reembolsos' => 'policy-refunds', 'cookies' => 'policy-cookies'];
    foreach ((require "$data/pages.php") as $esSlug => $p) {
        $html = $rewrite($cleaner->sanitize((string) $p['content_html']));
        $text = HtmlCleaner::toText($html);
        DB::upsert('posts', [
            'type' => $esSlug === 'sobre-mi' ? 'page' : 'policy', 'locale' => 'en',
            'translation_group' => WxrImporter::uuid($groups[$esSlug]),
            'slug' => $p['slug'], 'title' => $p['title'], 'excerpt' => excerpt_text($text, 200),
            'content_html' => $html, 'content_text' => $text, 'status' => 'published',
            'seo_title' => $p['seo_title'] ?? null, 'seo_description' => $p['seo_description'] ?? null,
            'reading_minutes' => HtmlCleaner::readingMinutes($text), 'needs_review' => 1,
            'published_at' => '2026-10-05 12:00:00', 'updated_at' => '2026-10-05 12:00:00',
        ], ['locale', 'slug']);
        $count['pages']++;
    }

    // --- Categorías en inglés (para las entradas traducidas) --------------------------------
    $catNames = [
        'excel' => 'Excel', 'oficina' => 'Office', 'correos-masivos' => 'Bulk email', 'blog' => 'Blog', 'business' => 'Business',
        'educacion' => 'Education', 'para-profesores' => 'For teachers', 'pensamiento-computacional' => 'Computational thinking',
        'productividad-personal' => 'Personal productivity', 'tecnologia' => 'Technology',
    ];
    foreach ($catNames as $wpSlug => $name) {
        $catId = DB::value('SELECT id FROM categories WHERE wp_slug = :s', ['s' => $wpSlug]);
        if ($catId !== null) {
            DB::upsert('category_translations', [
                'category_id' => (int) $catId, 'locale' => 'en', 'slug' => HtmlCleaner::slugify($name), 'name' => $name, 'needs_review' => 1,
            ], ['category_id', 'locale']);
        }
    }

    return sprintf('%d hubs, %d familias, %d productos, %d artículos, %d páginas', ...array_values($count));
};
