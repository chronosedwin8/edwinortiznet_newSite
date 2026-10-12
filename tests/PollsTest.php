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
use App\Services\Content\ContentRenderer;
use App\Services\Polls;
use App\Services\Reactions;
use PHPUnit\Framework\TestCase;

/**
 * Encuestas cortas de los artículos ({{encuesta:clave}}): votos anónimos (HMAC), una respuesta por pregunta que se puede
 * cambiar, validación, resultados y cruce por segmento. Se usa la encuesta real del artículo del colegio virtual.
 */
final class PollsTest extends TestCase
{
    private const KEY = 'colegio-virtual-ia';
    private string $csrf;

    protected function setUp(): void
    {
        try {
            DB::value('SELECT COUNT(*) FROM poll_votes');
        } catch (\Throwable) {
            $this->markTestSkipped('Base de datos no disponible o sin migrar (021)');
        }
        Config::set('PAGE_CACHE', 'false');
        RateLimiter::disable();
        Csrf::reset();
        $this->csrf = Csrf::token(Request::create('GET', '/'));
        DB::run('DELETE FROM poll_votes WHERE poll_key = :k', ['k' => self::KEY]);
    }

    protected function tearDown(): void
    {
        DB::run('DELETE FROM poll_votes WHERE poll_key = :k', ['k' => self::KEY]);
        RateLimiter::disable(false);
    }

    private function vote(array $answers, array $cookies = [], bool $withCsrf = true, string $key = self::KEY): Response
    {
        $server = ['HTTP_ACCEPT' => 'application/json', 'CONTENT_TYPE' => 'application/json'];
        if ($withCsrf) {
            $server['HTTP_X_CSRF_TOKEN'] = $this->csrf;
        }
        return App::handle(Request::create('POST', "/api/encuestas/$key", [], $server, $cookies + [Csrf::COOKIE => $this->csrf], (string) json_encode(['answers' => $answers, 'locale' => 'es'])));
    }

    private function cookie(Response $res): string
    {
        foreach ((array) ($res->headers['Set-Cookie'] ?? []) as $header) {
            if (preg_match('/^' . Reactions::COOKIE . '=([a-f0-9]{48});/', $header, $m)) {
                return $m[1];
            }
        }
        $this->fail('No se fijó la cookie del visitante');
    }

    private function results(array $cookies = []): array
    {
        $res = App::handle(Request::create('GET', '/api/encuestas/' . self::KEY, [], ['HTTP_ACCEPT' => 'application/json'], $cookies));
        $this->assertSame(200, $res->status);
        $this->assertSame('no-store', $res->headers['Cache-Control'] ?? null);
        return json_decode($res->body, true);
    }

    public function testVoteIsStoredAnonymouslyAndShowsResultsAndMine(): void
    {
        $empty = $this->results();
        $this->assertSame(0, $empty['people']);
        $this->assertCount(5, $empty['questions']);
        $this->assertSame([], $empty['mine']);

        $res = $this->vote([0 => 2, 1 => 3, 4 => 0]);
        $this->assertSame(200, $res->status, $res->body);
        $cookie = $this->cookie($res);
        $data = json_decode($res->body, true);
        $this->assertTrue($data['ok']);
        $this->assertSame(1, $data['people']);
        $this->assertSame(1, $data['questions'][0]['counts'][2]);
        $this->assertSame(['0' => 2, '1' => 3, '4' => 0], $data['mine']);
        // La base guarda el HMAC, nunca la cookie ni la IP.
        $this->assertSame(0, (int) DB::value('SELECT COUNT(*) FROM poll_votes WHERE visitor = :v', ['v' => $cookie]));
        $this->assertSame(Polls::visitorHash($cookie, self::KEY), DB::value('SELECT visitor FROM poll_votes WHERE question = 0 AND poll_key = :k', ['k' => self::KEY]));

        // Con la cookie se recuerdan las respuestas; sin ella, no.
        $this->assertSame(['0' => 2, '1' => 3, '4' => 0], $this->results([Reactions::COOKIE => $cookie])['mine']);
        $this->assertSame([], $this->results()['mine']);
    }

    public function testChangingAnAnswerUpdatesInsteadOfDuplicating(): void
    {
        $cookie = $this->cookie($this->vote([0 => 1]));
        $res = $this->vote([0 => 4], [Reactions::COOKIE => $cookie]);
        $data = json_decode($res->body, true);
        $this->assertSame(1, $data['people']);
        $this->assertSame(0, $data['questions'][0]['counts'][1]);
        $this->assertSame(1, $data['questions'][0]['counts'][4]);
        $this->assertSame(1, (int) DB::value('SELECT COUNT(*) FROM poll_votes WHERE poll_key = :k', ['k' => self::KEY]));
        $this->assertArrayNotHasKey('Set-Cookie', $res->headers, 'No se crea otra cookie');
    }

    public function testInvalidAnswersAndMissingCsrfAreRejected(): void
    {
        $this->assertSame(419, $this->vote([0 => 1], [], false)->status);
        $this->assertSame(422, $this->vote([0 => 9, 7 => 0, 'x' => 'y'])->status, 'Opción o pregunta inexistente');
        $this->assertSame(404, $this->vote([0 => 1], [], true, 'no-existe')->status);
        $this->assertSame(404, App::handle(Request::create('GET', '/api/encuestas/no-existe'))->status);
        $this->assertSame(0, (int) DB::value('SELECT COUNT(*) FROM poll_votes WHERE poll_key = :k', ['k' => self::KEY]));
        // Se aceptan las válidas aunque vengan mezcladas con inválidas.
        $this->assertSame(200, $this->vote([0 => 1, 9 => 2])->status);
        $this->assertSame(1, (int) DB::value('SELECT COUNT(*) FROM poll_votes WHERE poll_key = :k', ['k' => self::KEY]));
    }

    public function testSegmentsCrossTheSegmentQuestionWithTheRest(): void
    {
        // Pregunta 5 (índice 4) = rol: 0 docente, 2 familia.
        $this->vote([0 => 4, 1 => 1, 4 => 0]);
        $this->vote([0 => 4, 1 => 1, 4 => 0]);
        $this->vote([0 => 0, 1 => 0, 4 => 2]);
        $segments = Polls::segments(self::KEY);
        $this->assertSame(2, $segments[0]['people']);
        $this->assertSame(1, $segments[2]['people']);
        $this->assertSame(2, $segments[0]['questions'][0][4]);
        $this->assertSame(1, $segments[2]['questions'][1][0]);
        $this->assertArrayNotHasKey(4, $segments[0]['questions'], 'La pregunta de segmentación no se cruza consigo misma');
    }

    public function testDefinitionsKeepSameShapeInBothLanguagesAndLimitQuestions(): void
    {
        foreach (glob(Config::root('resources/polls/*.php')) as $file) {
            $all = require $file;
            $es = $all['es']['questions'];
            $en = $all['en']['questions'];
            $this->assertSame(count($es), count($en), basename($file));
            $this->assertLessThanOrEqual(Polls::MAX_QUESTIONS, count($es), basename($file));
            foreach ($es as $i => $q) {
                $this->assertSame(count($q['options']), count($en[$i]['options']), basename($file) . " pregunta $i");
                $this->assertStringNotContainsString('«', $q['q']);
            }
            $this->assertSame($all['es']['segment'] ?? null, $all['en']['segment'] ?? null);
        }
    }

    public function testMarkerRendersTheWidgetAndLoadsTheScript(): void
    {
        $post = ['id' => 0, 'locale' => 'es', 'content_html' => '<h2 id="a">Uno</h2><p>Texto.</p><p>{{encuesta:' . self::KEY . '}}</p><p>{{encuesta:no-existe}}</p>'];
        $html = ContentRenderer::render($post)['html'];
        $this->assertStringContainsString('data-poll-api="/api/encuestas/' . self::KEY . '"', $html);
        $this->assertSame(26, substr_count($html, 'class="poll__opt"'));
        $this->assertStringNotContainsString('{{encuesta', $html);
        $this->assertSame(['js/poll.js'], ContentRenderer::scripts($html));
        $this->assertSame([], ContentRenderer::scripts('<p>Sin encuesta</p>'));

        $en = ContentRenderer::render(['locale' => 'en'] + $post)['html'];
        $this->assertStringContainsString('What worries you most?', $en);
    }
}
