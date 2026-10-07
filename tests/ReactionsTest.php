<?php

declare(strict_types=1);

namespace Tests;

use App\Core\App;
use App\Core\Config;
use App\Core\Csrf;
use App\Core\DB;
use App\Core\RateLimiter;
use App\Core\Request;
use App\Core\Response;
use App\Services\Reactions;
use PHPUnit\Framework\TestCase;

final class ReactionsTest extends TestCase
{
    private string $csrf;
    /** @var int[] */
    private array $ids = [];
    private int $postId = 0;

    protected function setUp(): void
    {
        try {
            DB::value('SELECT COUNT(*) FROM post_reactions');
        } catch (\Throwable) {
            $this->markTestSkipped('Base de datos no disponible o sin migrar');
        }
        Config::set('PAGE_CACHE', 'false');
        RateLimiter::disable();
        Csrf::reset();
        $this->csrf = Csrf::token(Request::create('GET', '/'));
        $this->postId = $this->makePost('post', 'published');
    }

    protected function tearDown(): void
    {
        if ($this->ids !== []) {
            DB::run('DELETE FROM posts WHERE id IN (' . DB::in($this->ids) . ')', $this->ids);
        }
        RateLimiter::disable(false);
    }

    private function makePost(string $type, string $status, string $locale = 'es'): int
    {
        $slug = 'reacciones-' . bin2hex(random_bytes(4));
        $id = DB::insert('posts', [
            'type' => $type, 'locale' => $locale, 'translation_group' => bin2hex(random_bytes(16)), 'slug' => $slug,
            'title' => 'Artículo de prueba de reacciones', 'excerpt' => 'Resumen de prueba.', 'content_html' => '<p>Texto de prueba.</p>',
            'content_text' => 'Texto de prueba.', 'status' => $status, 'published_at' => DB::now(), 'updated_at' => DB::now(),
        ]);
        $this->ids[] = $id;
        return $id;
    }

    /** @param array<string,string> $cookies */
    private function react(int $postId, ?string $reaction, array $cookies = [], bool $withCsrf = true): Response
    {
        $server = ['HTTP_ACCEPT' => 'application/json', 'CONTENT_TYPE' => 'application/json'];
        if ($withCsrf) {
            $server['HTTP_X_CSRF_TOKEN'] = $this->csrf;
        }
        $body = (string) json_encode(['reaction' => $reaction]);
        return App::handle(Request::create('POST', "/api/reacciones/$postId", [], $server, $cookies + [Csrf::COOKIE => $this->csrf], $body));
    }

    private function visitorCookie(Response $response): string
    {
        foreach ((array) ($response->headers['Set-Cookie'] ?? []) as $header) {
            if (preg_match('/^' . Reactions::COOKIE . '=([a-f0-9]{48});/', $header, $m)) {
                $this->assertStringContainsString('HttpOnly', $header);
                $this->assertStringContainsString('SameSite=Lax', $header);
                $this->assertStringContainsString('Max-Age=' . Reactions::COOKIE_MAX_AGE, $header);
                return $m[1];
            }
        }
        $this->fail('No se fijó la cookie del visitante');
    }

    private function get(int $postId, array $cookies = []): array
    {
        $res = App::handle(Request::create('GET', "/api/reacciones/$postId", [], ['HTTP_ACCEPT' => 'application/json'], $cookies));
        $this->assertSame(200, $res->status);
        $this->assertSame('no-store', $res->headers['Cache-Control'] ?? null);
        return json_decode($res->body, true);
    }

    public function testSetChangeAndRemoveReaction(): void
    {
        $empty = $this->get($this->postId);
        $this->assertSame(0, $empty['total']);
        $this->assertNull($empty['mine']);
        $this->assertSame(array_keys(Reactions::TYPES), array_keys($empty['counts']));

        $res = $this->react($this->postId, 'insightful');
        $this->assertSame(200, $res->status, $res->body);
        $data = json_decode($res->body, true);
        $this->assertTrue($data['ok']);
        $this->assertSame('insightful', $data['mine']);
        $this->assertSame(1, $data['total']);
        $cookie = $this->visitorCookie($res);
        // La base guarda el HMAC, nunca el valor de la cookie.
        $this->assertSame(Reactions::visitorHash($cookie), DB::value('SELECT visitor FROM post_reactions WHERE post_id = :p', ['p' => $this->postId]));
        $this->assertSame(0, (int) DB::value('SELECT COUNT(*) FROM post_reactions WHERE visitor = :v', ['v' => $cookie]));

        // Cambiar: sigue habiendo una sola fila y no se crea otra cookie.
        $res = $this->react($this->postId, 'love', [Reactions::COOKIE => $cookie]);
        $data = json_decode($res->body, true);
        $this->assertSame('love', $data['mine']);
        $this->assertSame(1, $data['total']);
        $this->assertSame(1, $data['counts']['love']);
        $this->assertSame(0, $data['counts']['insightful']);
        $this->assertArrayNotHasKey('Set-Cookie', $res->headers);
        $this->assertSame('love', $this->get($this->postId, [Reactions::COOKIE => $cookie])['mine']);
        $this->assertNull($this->get($this->postId)['mine']);

        // Quitar.
        $data = json_decode($this->react($this->postId, null, [Reactions::COOKIE => $cookie])->body, true);
        $this->assertNull($data['mine']);
        $this->assertSame(0, $data['total']);
        $this->assertSame(0, (int) DB::value('SELECT COUNT(*) FROM post_reactions WHERE post_id = :p', ['p' => $this->postId]));
    }

    public function testOneReactionPerVisitorAndCounts(): void
    {
        $a = $this->visitorCookie($this->react($this->postId, 'like'));
        $this->react($this->postId, 'like', [Reactions::COOKIE => $a]);
        $this->react($this->postId, 'like', [Reactions::COOKIE => $a]);
        $this->visitorCookie($this->react($this->postId, 'like'));
        $this->visitorCookie($this->react($this->postId, 'thoughtful'));
        $this->visitorCookie($this->react($this->postId, 'celebrate'));
        $this->visitorCookie($this->react($this->postId, 'celebrate'));
        $this->visitorCookie($this->react($this->postId, 'celebrate'));

        $data = $this->get($this->postId);
        $this->assertSame(6, $data['total']);
        $this->assertSame(['like' => 2, 'insightful' => 0, 'celebrate' => 3, 'love' => 0, 'thoughtful' => 1], $data['counts']);
        $this->assertSame(['celebrate', 'like', 'thoughtful'], $data['top']);

        // Varias entradas en una sola consulta (sin N+1); una entrada sin reacciones devuelve ceros.
        $other = $this->makePost('post', 'published', 'en');
        $all = Reactions::summaries([$this->postId, $other]);
        $this->assertSame(6, $all[$this->postId]['total']);
        $this->assertSame(0, $all[$other]['total']);
        $this->assertSame([], $all[$other]['top']);
    }

    public function testCsrfIsRequired(): void
    {
        $res = $this->react($this->postId, 'like', [], false);
        $this->assertSame(419, $res->status);
        $this->assertSame(0, (int) DB::value('SELECT COUNT(*) FROM post_reactions WHERE post_id = :p', ['p' => $this->postId]));

        // Token que no coincide con la cookie.
        $server = ['HTTP_ACCEPT' => 'application/json', 'CONTENT_TYPE' => 'application/json', 'HTTP_X_CSRF_TOKEN' => $this->csrf];
        Csrf::reset();
        $other = Csrf::token(Request::create('GET', '/'));
        $this->assertNotSame($this->csrf, $other);
        $res = App::handle(Request::create('POST', "/api/reacciones/{$this->postId}", [], $server, [Csrf::COOKIE => $other], '{"reaction":"like"}'));
        $this->assertSame(419, $res->status);
    }

    public function testUnpublishedPagesAndUnknownReturn404(): void
    {
        foreach ([$this->makePost('post', 'draft'), $this->makePost('page', 'published'), $this->makePost('policy', 'published'), 99999999] as $id) {
            $this->assertSame(404, $this->react($id, 'like')->status, "POST $id");
            $res = App::handle(Request::create('GET', "/api/reacciones/$id"));
            $this->assertSame(404, $res->status, "GET $id");
        }
        $this->assertSame(0, (int) DB::value('SELECT COUNT(*) FROM post_reactions WHERE post_id IN (' . DB::in($this->ids) . ')', $this->ids));
    }

    public function testInvalidReactionIsRejected(): void
    {
        $this->assertSame(422, $this->react($this->postId, 'angry')->status);
        // Quitar sin haber reaccionado no crea la cookie.
        $res = $this->react($this->postId, null);
        $this->assertSame(200, $res->status);
        $this->assertArrayNotHasKey('Set-Cookie', $res->headers);
    }

    public function testFormFallbackWithoutJavascriptRedirectsToArticle(): void
    {
        $slug = (string) DB::value('SELECT slug FROM posts WHERE id = :id', ['id' => $this->postId]);
        $res = App::handle(Request::create('POST', "/api/reacciones/{$this->postId}", ['reaction' => 'celebrate', '_csrf' => $this->csrf], [], [Csrf::COOKIE => $this->csrf]));
        $this->assertSame(303, $res->status);
        $this->assertSame("/$slug/#reacciones", $res->headers['Location']);
        $this->assertSame(1, Reactions::summary($this->postId)['counts']['celebrate']);
        $this->visitorCookie($res);
    }

    public function testArticleRendersReactionBarAndShareLinks(): void
    {
        $slug = (string) DB::value('SELECT slug FROM posts WHERE id = :id', ['id' => $this->postId]);
        $html = App::handle(Request::create('GET', "/$slug/"))->body;
        $this->assertStringContainsString('data-rx-api="/api/reacciones/' . $this->postId . '"', $html);
        $this->assertStringNotContainsString(Csrf::PLACEHOLDER, $html);
        $this->assertStringContainsString('https://wa.me/?text=', $html);
        $this->assertStringContainsString('https://www.linkedin.com/sharing/share-offsite/?url=' . rawurlencode(url("/$slug/")), $html);
        $this->assertStringContainsString('og:image:alt', $html);

        // Las páginas no llevan reacciones.
        $page = $this->makePost('page', 'published');
        $pageSlug = (string) DB::value('SELECT slug FROM posts WHERE id = :id', ['id' => $page]);
        $this->assertStringNotContainsString('data-rx-api', App::handle(Request::create('GET', "/$pageSlug/"))->body);
    }
}
