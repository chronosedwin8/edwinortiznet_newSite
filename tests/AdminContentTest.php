<?php

declare(strict_types=1);

namespace Tests;

use App\Core\App;
use App\Core\Config;
use App\Core\Csrf;
use App\Core\DB;
use App\Core\Mailer;
use App\Core\RateLimiter;
use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Services\Seo\Redirects;
use App\Services\Seo\Sitemap;
use PHPUnit\Framework\TestCase;

/**
 * Panel: eliminar artículos y páginas (uno, varios, con traducción y 301), páginas protegidas,
 * crear y eliminar secciones y familias, y que lo nuevo se vea en el sitio público.
 * Todo lo que crea lleva "prueba-{run}" y se borra al final.
 */
final class AdminContentTest extends TestCase
{
    private string $csrf;
    private string $run;
    private int $adminId;

    protected function setUp(): void
    {
        try {
            DB::value('SELECT in_menu FROM hubs LIMIT 1');
        } catch (\Throwable) {
            $this->markTestSkipped('Base de datos no disponible o sin la migración 013');
        }
        Config::set('MAIL_DRIVER', 'array');
        Config::set('PAGE_CACHE', 'false');
        RateLimiter::disable();
        Session::fake();
        Mailer::$sent = [];
        Csrf::reset();
        $this->csrf = Csrf::token(Request::create('GET', '/'));
        $this->run = bin2hex(random_bytes(3));
        $this->adminId = DB::insert('admin_users', [
            'email' => "admin-{$this->run}@test.local", 'name' => 'Admin prueba',
            'password_hash' => password_hash('clave-segura-123', PASSWORD_ARGON2ID),
        ]);
        $res = $this->post('/admin/acceso/', ['email' => "admin-{$this->run}@test.local", 'password' => 'clave-segura-123']);
        $this->assertSame(303, $res->status);
    }

    protected function tearDown(): void
    {
        if (!isset($this->adminId)) {
            return;
        }
        $like = "%prueba-{$this->run}%";
        DB::run('DELETE FROM admin_users WHERE id = :id', ['id' => $this->adminId]);
        DB::run('DELETE FROM posts WHERE slug LIKE :s', ['s' => $like]);
        DB::run('DELETE FROM hubs WHERE `key` LIKE :s', ['s' => $like]);
        DB::run('DELETE FROM product_families WHERE `key` LIKE :s', ['s' => $like]);
        DB::run('DELETE FROM redirects WHERE source LIKE :s', ['s' => $like]);
        Redirects::clear();
        RateLimiter::disable(false);
    }

    private function post(string $uri, array $data = []): Response
    {
        return App::handle(Request::create('POST', $uri, $data + ['_csrf' => $this->csrf], [], [Csrf::COOKIE => $this->csrf]));
    }

    private function get(string $uri): Response
    {
        Redirects::clear();
        return App::handle(Request::create('GET', $uri));
    }

    private function flash(): ?string
    {
        return Session::flash('admin');
    }

    /** Entrada de prueba (y su traducción si se pide), publicada salvo que se indique otra cosa. */
    private function makePost(string $name, array $extra = [], bool $withEnglish = false): array
    {
        $group = sprintf('%08x-0000-4000-8000-%012x', random_int(0, 0xffffffff), random_int(0, 0xffffffffffff));
        $base = [
            'type' => 'post', 'locale' => 'es', 'translation_group' => $group, 'slug' => "$name-prueba-{$this->run}",
            'title' => "Título $name {$this->run}", 'excerpt' => 'Extracto', 'content_html' => '<p>Texto de prueba</p>', 'content_text' => 'Texto de prueba',
            'status' => 'published', 'published_at' => gmdate('Y-m-d H:i:s'),
        ];
        $es = DB::insert('posts', $extra + $base);
        $en = $withEnglish ? DB::insert('posts', ['locale' => 'en', 'slug' => "$name-en-prueba-{$this->run}", 'title' => "Title $name {$this->run}"] + $extra + $base) : null;
        return ['es' => $es, 'en' => $en, 'slug' => $base['slug'], 'en_slug' => "$name-en-prueba-{$this->run}"];
    }

    public function testSingleDeleteKeepsTranslationAndRedirectsToHub(): void
    {
        $hubId = (int) DB::value('SELECT id FROM hubs WHERE `key` = "excel"');
        $post = $this->makePost('uno', ['hub_id' => $hubId], true);
        $category = DB::value('SELECT id FROM categories ORDER BY id LIMIT 1');
        if ($category !== null) {
            DB::insert('post_category', ['post_id' => $post['es'], 'category_id' => (int) $category]);
        }
        $this->assertSame(200, $this->get("/{$post['slug']}/")->status);

        // La lista muestra la casilla y el botón de borrar de cada fila.
        $list = $this->get('/admin/contenido/?q=' . rawurlencode("prueba-{$this->run}"));
        $this->assertStringContainsString('data-row-check', $list->body);
        $this->assertStringContainsString('data-delete-dialog', $list->body);

        // Sin "confirmed" (navegador sin JavaScript): página de confirmación, no se borra nada.
        $confirm = $this->post('/admin/contenido/borrar/', ['ids' => [$post['es']], 'return' => '/admin/contenido/']);
        $this->assertSame(200, $confirm->status);
        $this->assertStringContainsString("Título uno {$this->run}", $confirm->body);
        $this->assertNotNull(DB::value('SELECT id FROM posts WHERE id = :id', ['id' => $post['es']]));

        $res = $this->post('/admin/contenido/borrar/', ['ids' => [$post['es']], 'redirect' => '1', 'confirmed' => '1', 'return' => '/admin/contenido/?type=post']);
        $this->assertSame(303, $res->status);
        $this->assertSame('/admin/contenido/?type=post', $res->headers['Location']);
        $this->assertSame('1 elemento eliminado.', $this->flash());
        $this->assertNull(DB::value('SELECT id FROM posts WHERE id = :id', ['id' => $post['es']]));
        $this->assertSame(0, (int) DB::value('SELECT COUNT(*) FROM post_category WHERE post_id = :id', ['id' => $post['es']]));

        // La versión en inglés sigue publicada; la URL borrada redirige (301) a su sección.
        $this->assertNotNull(DB::value('SELECT id FROM posts WHERE id = :id', ['id' => $post['en']]));
        $this->assertSame(200, $this->get("/en/{$post['en_slug']}/")->status);
        $gone = $this->get("/{$post['slug']}/");
        $this->assertSame(301, $gone->status);
        $this->assertSame('/excel/', $gone->headers['Location']);
    }

    public function testBulkDeleteWithTranslations(): void
    {
        $a = $this->makePost('a', [], true);
        $b = $this->makePost('b', ['status' => 'draft']);
        $res = $this->post('/admin/contenido/borrar/', ['ids' => [$a['es'], $b['es']], 'with_translations' => '1', 'redirect' => '1', 'confirmed' => '1']);
        $this->assertSame(303, $res->status);
        $this->assertSame('/admin/contenido/', $res->headers['Location']);
        $this->assertSame('3 elementos eliminados.', $this->flash());
        $this->assertSame(0, (int) DB::value('SELECT COUNT(*) FROM posts WHERE slug LIKE :s', ['s' => "%prueba-{$this->run}%"]));
        // Publicado sin sección → blog del idioma; el borrador no deja redirección.
        $this->assertSame('/en/blog/', DB::value('SELECT target FROM redirects WHERE source = :s', ['s' => "/en/{$a['en_slug']}/"]));
        $this->assertSame('/blog/', DB::value('SELECT target FROM redirects WHERE source = :s', ['s' => "/{$a['slug']}/"]));
        $this->assertNull(DB::value('SELECT id FROM redirects WHERE source = :s', ['s' => "/{$b['slug']}/"]));

        // Sin marcar "redirigir": no se crea la 301 y la URL da 404.
        $c = $this->makePost('c');
        $this->post('/admin/contenido/borrar/', ['ids' => [$c['es']], 'confirmed' => '1']);
        $this->assertNull(DB::value('SELECT id FROM redirects WHERE source = :s', ['s' => "/{$c['slug']}/"]));
        $this->assertSame(404, $this->get("/{$c['slug']}/")->status);
    }

    public function testProtectedPagesCannotBeDeleted(): void
    {
        $about = (int) DB::value('SELECT id FROM posts WHERE locale = "es" AND slug = "sobre-mi"');
        $privacy = (int) DB::value('SELECT id FROM posts WHERE locale = "es" AND slug = "privacidad"');
        $this->assertGreaterThan(0, $about);
        $this->assertStringNotContainsString('data-row-check" value="' . $about . '"', $this->get('/admin/contenido/?type=page')->body);
        $this->assertStringContainsString('No se puede eliminar', $this->get("/admin/contenido/$about/")->body);

        $res = $this->post('/admin/contenido/borrar/', ['ids' => [$about, $privacy], 'confirmed' => '1', 'redirect' => '1']);
        $this->assertSame(303, $res->status);
        $this->assertStringStartsWith('!No se eliminó nada', (string) Session::get('_flash_admin'));
        $this->assertNotNull(DB::value('SELECT id FROM posts WHERE id = :id', ['id' => $about]));
        $this->assertNotNull(DB::value('SELECT id FROM posts WHERE id = :id', ['id' => $privacy]));

        // Mezclado con uno normal: se borra el normal y se avisa del protegido. Tampoco cae por la traducción.
        $x = $this->makePost('x');
        $this->post('/admin/contenido/borrar/', ['ids' => [$x['es'], $about], 'with_translations' => '1', 'confirmed' => '1']);
        $message = (string) $this->flash();
        $this->assertStringContainsString('1 elemento eliminado.', $message);
        $this->assertStringContainsString('protegidas', $message);
        $this->assertNull(DB::value('SELECT id FROM posts WHERE id = :id', ['id' => $x['es']]));
        $this->assertNotNull(DB::value('SELECT id FROM posts WHERE locale = "en" AND slug = "about"'));
        $this->assertSame(200, $this->get('/sobre-mi/')->status);
    }

    public function testCreateSectionRendersPubliclyAndDeletes(): void
    {
        $slug = "seccion-prueba-{$this->run}";
        $res = $this->post('/admin/secciones/nueva/', [
            'key' => "seccion-prueba-{$this->run}", 'sort' => '90', 'in_menu' => '1',
            'es' => ['title' => "Sección de prueba {$this->run}", 'slug' => $slug, 'menu_title' => "Menú {$this->run}",
                'intro_html' => '<p>Introducción de la sección <script>alert(1)</script></p>', 'faq' => "¿Pregunta {$this->run}? | Respuesta",
                'seo_title' => 'Sección de prueba', 'seo_description' => 'Descripción de la sección de prueba'],
            'en' => ['title' => "Test section {$this->run}", 'slug' => "$slug-en", 'menu_title' => "Menu {$this->run}"],
        ]);
        $this->assertSame(303, $res->status);
        $hubId = (int) DB::value('SELECT id FROM hubs WHERE `key` = :k', ['k' => $slug]);
        $this->assertGreaterThan(0, $hubId);
        $this->assertSame("/admin/secciones/$hubId/", $res->headers['Location']);
        $this->assertSame(200, $this->get("/admin/secciones/$hubId/")->status);
        $this->assertSame(200, $this->get('/admin/secciones/nueva/')->status);

        // Página pública en los dos idiomas, menú principal, portada (con artículos) y sitemap.
        $page = $this->get("/$slug/");
        $this->assertSame(200, $page->status);
        $this->assertStringContainsString("Sección de prueba {$this->run}", $page->body);
        $this->assertStringContainsString("Pregunta {$this->run}", $page->body);
        $this->assertStringNotContainsString('<script>alert', $page->body);
        $this->assertSame(200, $this->get("/en/$slug-en/")->status);
        $this->assertStringContainsString('href="/' . $slug . '/"', $this->get('/blog/')->body);
        $this->assertStringContainsString("Menu {$this->run}", $this->get('/en/blog/')->body);
        $post = $this->makePost('en-seccion', ['hub_id' => $hubId]);
        $this->assertStringContainsString("Título en-seccion {$this->run}", $this->get('/')->body);
        $this->assertStringContainsString("/$slug/</loc>", Sitemap::build());

        // Slugs que no se pueden usar: una ruta fija, una entrada existente u otra sección.
        $before = (int) DB::value('SELECT COUNT(*) FROM hubs');
        foreach (['blog', 'tienda', $post['slug'], $slug] as $bad) {
            $this->post('/admin/secciones/nueva/', ['key' => "otra-prueba-{$this->run}", 'es' => ['title' => 'Otra', 'slug' => $bad]]);
            $this->assertStringStartsWith('!', (string) $this->flash(), $bad);
        }
        $this->assertSame($before, (int) DB::value('SELECT COUNT(*) FROM hubs'));

        // Con artículos no se elimina, salvo que se pida quitársela; luego su URL redirige al blog.
        $this->post("/admin/secciones/$hubId/borrar/", ['redirect' => '1']);
        $this->assertStringStartsWith('!', (string) $this->flash());
        $this->assertNotNull(DB::value('SELECT id FROM hubs WHERE id = :id', ['id' => $hubId]));
        $res = $this->post("/admin/secciones/$hubId/borrar/", ['redirect' => '1', 'unassign' => '1']);
        $this->assertSame('/admin/secciones/', $res->headers['Location']);
        $this->assertNull(DB::value('SELECT id FROM hubs WHERE id = :id', ['id' => $hubId]));
        $this->assertNull(DB::value('SELECT hub_id FROM posts WHERE id = :id', ['id' => $post['es']]));
        $gone = $this->get("/$slug/");
        $this->assertSame(301, $gone->status);
        $this->assertSame('/blog/', $gone->headers['Location']);
        $this->assertStringNotContainsString('href="/' . $slug . '/"', $this->get('/blog/')->body);

        // Las secciones que usa el código no se eliminan.
        $excel = (int) DB::value('SELECT id FROM hubs WHERE `key` = "excel"');
        $this->post("/admin/secciones/$excel/borrar/", ['unassign' => '1']);
        $this->assertStringStartsWith('!', (string) $this->flash());
        $this->assertNotNull(DB::value('SELECT id FROM hubs WHERE id = :id', ['id' => $excel]));
    }

    public function testCreateFamilyRendersPubliclyAndDeletes(): void
    {
        $slug = "familia-prueba-{$this->run}";
        $res = $this->post('/admin/familias/nueva/', [
            'key' => $slug, 'audience' => 'docente', 'sort' => '50',
            'es' => ['name' => "Familia prueba {$this->run}", 'slug' => $slug, 'description_html' => '<p>Descripción de la familia</p>'],
            'en' => ['name' => "Test family {$this->run}", 'slug' => "$slug-en"],
        ]);
        $this->assertSame(303, $res->status);
        $familyId = (int) DB::value('SELECT id FROM product_families WHERE `key` = :k', ['k' => $slug]);
        $this->assertGreaterThan(0, $familyId);
        $this->assertSame('docente', DB::value('SELECT audience FROM product_families WHERE id = :id', ['id' => $familyId]));
        $this->assertSame(200, $this->get("/admin/familias/$familyId/")->status);
        $this->assertSame(200, $this->get('/admin/familias/nueva/')->status);
        $this->assertStringContainsString("family-delete-$familyId", $this->get('/admin/familias/')->body);

        $page = $this->get("/categoria-producto/$slug/");
        $this->assertSame(200, $page->status);
        $this->assertStringContainsString("Familia prueba {$this->run}", $page->body);
        $this->assertStringContainsString('Descripción de la familia', $page->body);
        $this->assertStringContainsString("/categoria-producto/$slug/", $this->get('/tienda/')->body);
        $this->assertSame(200, $this->get("/en/product-category/$slug-en/")->status);

        // Slug repetido: error, sin crear nada.
        $this->post('/admin/familias/nueva/', ['es' => ['name' => 'Otra', 'slug' => $slug]]);
        $this->assertStringStartsWith('!', (string) $this->flash());

        // Una familia con productos no se elimina.
        $busy = (int) DB::value('SELECT family_id FROM products WHERE family_id IS NOT NULL LIMIT 1');
        $this->post("/admin/familias/$busy/borrar/");
        $this->assertStringStartsWith('!', (string) $this->flash());
        $this->assertNotNull(DB::value('SELECT id FROM product_families WHERE id = :id', ['id' => $busy]));

        // Vacía: se elimina y su URL redirige a la tienda.
        $res = $this->post("/admin/familias/$familyId/borrar/");
        $this->assertSame(303, $res->status);
        $this->assertNull(DB::value('SELECT id FROM product_families WHERE id = :id', ['id' => $familyId]));
        $gone = $this->get("/categoria-producto/$slug/");
        $this->assertSame(301, $gone->status);
        $this->assertSame('/tienda/', $gone->headers['Location']);
    }
}
