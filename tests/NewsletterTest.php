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
use App\Models\Setting;
use App\Services\Content\AntiSpam;
use App\Services\Newsletter\Builder;
use App\Services\Newsletter\Interests;
use App\Services\Newsletter\NewsletterSettings;
use App\Services\Newsletter\Renderer;
use App\Services\Newsletter\Sender;
use App\Services\Newsletter\Tracking;
use App\Services\Subscribers;
use PHPUnit\Framework\TestCase;

/**
 * Suscriptores con temas y origen, centro de preferencias, baja de un clic y boletín (armado, envío por lotes,
 * cabeceras y seguimiento).
 */
final class NewsletterTest extends TestCase
{
    private string $csrf;
    private string $run;
    /** @var int[] */
    private array $issues = [];
    private array $settingsBackup = [];

    protected function setUp(): void
    {
        try {
            DB::value('SELECT COUNT(*) FROM newsletter_issues');
        } catch (\Throwable) {
            $this->markTestSkipped('Base de datos sin la migración 019');
        }
        Config::set('MAIL_DRIVER', 'array');
        Config::set('PAGE_CACHE', 'false');
        RateLimiter::disable();
        Session::fake();
        Mailer::$sent = [];
        Csrf::reset();
        Sender::$throttle = false;
        $this->csrf = Csrf::token(Request::create('GET', '/'));
        $this->run = bin2hex(random_bytes(3));
        foreach (array_keys(NewsletterSettings::DEFAULTS) as $k) {
            $this->settingsBackup[$k] = DB::value('SELECT `value` FROM settings WHERE `key` = :k', ['k' => "newsletter.$k"]);
        }
    }

    protected function tearDown(): void
    {
        if (!isset($this->run)) {
            return;
        }
        foreach ($this->issues as $id) {
            DB::run('DELETE FROM newsletter_issues WHERE id = :id', ['id' => $id]);
        }
        DB::run('DELETE FROM subscribers WHERE email LIKE :e', ['e' => "%{$this->run}@test.local"]);
        DB::run('DELETE FROM admin_users WHERE email LIKE :e', ['e' => "%{$this->run}@test.local"]);
        foreach ($this->settingsBackup as $k => $v) {
            if ($v === null) {
                DB::run('DELETE FROM settings WHERE `key` = :k', ['k' => "newsletter.$k"]);
            } else {
                Setting::set("newsletter.$k", (string) $v);
            }
        }
        Setting::clear();
        Config::set('MAIL_DRIVER', 'array');
        RateLimiter::disable(false);
        Sender::$throttle = true;
    }

    private function email(string $name): string
    {
        return "$name-{$this->run}@test.local";
    }

    private function post(string $uri, array $data, array $server = [], bool $cookie = true): Response
    {
        $data += ['_csrf' => $this->csrf, '_ts' => AntiSpam::stamp(time() - 5), 'website' => ''];
        return App::handle(Request::create('POST', $uri, $data, $server, $cookie ? [Csrf::COOKIE => $this->csrf] : []));
    }

    private function subscriber(string $name, string $status = 'active', string $interests = '', string $locale = 'es'): array
    {
        $row = Subscribers::add($this->email($name), $locale, ['source_type' => 'home', 'interests' => Interests::fromSet($interests)]);
        DB::update('subscribers', ['status' => $status, 'interests' => $interests, 'confirmed_at' => $status === 'active' ? DB::now() : null], ['id' => (int) $row['id']]);
        return Subscribers::byId((int) $row['id']) ?? [];
    }

    private function fakeIssue(array $content = []): array
    {
        $content = $content ?: ['es' => ['posts' => [
            ['key' => 'post:1', 'id' => 1, 'title' => 'Fórmulas de Excel', 'summary' => 'Resumen Excel', 'url' => url('/excel-1/'), 'image' => null, 'alt' => 'x', 'hub_key' => 'excel', 'hub_title' => 'Excel', 'interests' => ['excel'], 'published_at' => '2026-10-07 10:00:00', 'minutes' => 4, 'new' => true],
            ['key' => 'post:2', 'id' => 2, 'title' => 'Concurso Docente', 'summary' => 'Resumen concurso', 'url' => url('/concurso-1/'), 'image' => null, 'alt' => 'x', 'hub_key' => 'concurso-docente', 'hub_title' => 'Concurso', 'interests' => ['concurso'], 'published_at' => '2026-10-06 10:00:00', 'minutes' => 4, 'new' => true],
            ['key' => 'post:3', 'id' => 3, 'title' => 'IA en el aula', 'summary' => 'Resumen IA', 'url' => url('/ia-1/'), 'image' => null, 'alt' => 'x', 'hub_key' => 'ia-para-docentes', 'hub_title' => 'IA', 'interests' => ['docentes', 'tecnologia'], 'published_at' => '2026-10-05 10:00:00', 'minutes' => 4, 'new' => true],
            ['key' => 'post:4', 'id' => 4, 'title' => 'Concurso viejo', 'summary' => 'Viejo', 'url' => url('/concurso-0/'), 'image' => null, 'alt' => 'x', 'hub_key' => 'concurso-docente', 'hub_title' => 'Concurso', 'interests' => ['concurso'], 'published_at' => '2026-09-01 10:00:00', 'minutes' => 4, 'new' => false],
        ], 'offers' => [
            ['key' => 'product:1', 'kind' => 'product', 'title' => 'Plantilla Excel', 'summary' => 's', 'url' => url('/producto/x/'), 'image' => null, 'alt' => 'x', 'price' => '$ 40.000', 'interests' => ['excel']],
            ['key' => 'product:2', 'kind' => 'product', 'title' => 'Curso concurso', 'summary' => 's', 'url' => url('/producto/y/'), 'image' => null, 'alt' => 'x', 'price' => '$ 80.000', 'interests' => ['concurso']],
            ['key' => 'tool:fundales', 'kind' => 'tool', 'title' => 'Simulacro', 'summary' => 's', 'url' => url('/herramientas/simulacro-concurso-docente/'), 'image' => null, 'alt' => 'x', 'price' => null, 'interests' => ['concurso']],
            ['key' => 'tool:qr', 'kind' => 'tool', 'title' => 'QR', 'summary' => 's', 'url' => url('/herramientas/generador-qr/'), 'image' => null, 'alt' => 'x', 'price' => null, 'interests' => ['excel']],
        ]], 'en' => ['posts' => [], 'offers' => []]];
        return ['id' => 0, 'issue_key' => 'boletin-prueba-' . $this->run, 'scheduled_for' => DB::now(), 'subject' => 'x', 'subject_manual' => 0,
            'intro_es' => 'Hola intro', 'intro_en' => 'Hi intro', 'content' => $content];
    }

    private function createIssue(string $scheduled, bool $approved = true): array
    {
        $issue = Builder::createIssue($scheduled, 'admin', false);
        $this->issues[] = (int) $issue['id'];
        if ($approved) {
            DB::run('UPDATE newsletter_issues SET approved_at = UTC_TIMESTAMP(), preview_sent_at = UTC_TIMESTAMP() WHERE id = :id', ['id' => (int) $issue['id']]);
        }
        return Builder::issue((int) $issue['id']) ?? [];
    }

    // ------------------------------------------------------------------ alta, confirmación y preferencias

    public function testSubscribeCapturesSourceUtmAndInterests(): void
    {
        $res = $this->post('/suscripcion/', [
            'email' => $this->email('cap'), 'source' => 'article:mi-guia', 'tag' => 'excel',
            'source_type' => 'article', 'source_path' => '/mi-guia/', 'source_title' => 'Mi guía de Excel',
            'interests' => ['excel', 'inventado'], 'ref' => 'https://www.google.com/search?q=excel',
        ], ['HTTP_ACCEPT' => 'application/json', 'HTTP_REFERER' => url('/mi-guia/?utm_source=facebook&utm_medium=social&utm_campaign=auto')]);
        $this->assertSame(200, $res->status);
        $row = Subscribers::byEmail($this->email('cap'));
        $this->assertSame('pending', $row['status']);
        $this->assertSame('article', $row['source_type']);
        $this->assertSame('/mi-guia/', $row['source_path']);
        $this->assertSame('Mi guía de Excel', $row['source_title']);
        $this->assertSame('excel', $row['interests']);
        $this->assertSame('facebook', $row['utm_source']);
        $this->assertSame('auto', $row['utm_campaign']);
        $this->assertSame('www.google.com/search', $row['referrer']);
        $this->assertSame(64, strlen((string) $row['ip_hash']));
        $this->assertStringContainsString('/suscripcion/confirmar/' . $row['token'] . '/', end(Mailer::$sent)['html']);

        // Datos inválidos: tipo desconocido → other; ruta externa → nula. Una sola fila por correo (suma intereses).
        $this->post('/suscripcion/', ['email' => strtoupper($this->email('cap')), 'source_type' => 'hack', 'source_path' => '//evil.com/x', 'interests' => ['concurso']], ['HTTP_ACCEPT' => 'application/json']);
        $this->assertSame(1, (int) DB::value('SELECT COUNT(*) FROM subscribers WHERE email = :e', ['e' => $this->email('cap')]));
        $this->assertSame('excel,concurso', Subscribers::byEmail($this->email('cap'))['interests']);
        Subscribers::add($this->email('bad'), 'es', ['source_type' => 'hack', 'source_path' => '//evil.com/x']);
        $bad = Subscribers::byEmail($this->email('bad'));
        $this->assertSame('other', $bad['source_type']);
        $this->assertNull($bad['source_path']);
    }

    public function testArticleFormCarriesContextAndDefaultInterests(): void
    {
        $slug = DB::value("SELECT p.slug FROM posts p JOIN hubs h ON h.id = p.hub_id WHERE h.`key` = 'excel' AND p.locale = 'es' AND p.type = 'post' AND p.status = 'published' LIMIT 1");
        if ($slug === null) {
            $this->markTestSkipped('Sin artículos del hub de Excel');
        }
        $body = App::handle(Request::create('GET', "/$slug/"))->body;
        $this->assertStringContainsString('name="source_type" value="article"', $body);
        $this->assertStringContainsString('name="source_type" value="footer"', $body);
        $this->assertStringContainsString('name="source_path" value="/' . $slug . '/"', $body);
        $this->assertMatchesRegularExpression('/name="interests\[\]" value="excel" checked/', $body);
        $this->assertStringContainsString('<input type="hidden" name="interests[]" value="excel">', $body); // pie de página
    }

    public function testConfirmationShowsInterestsAndSavesChoice(): void
    {
        $row = Subscribers::add($this->email('conf'), 'es', ['source_type' => 'hub', 'interests' => ['excel']]);
        $page = App::handle(Request::create('GET', "/suscripcion/confirmar/{$row['token']}/"));
        $this->assertSame(200, $page->status);
        $this->assertMatchesRegularExpression('/value="excel" checked/', $page->body);
        $this->assertDoesNotMatchRegularExpression('/value="concurso" checked/', $page->body);
        $this->assertNull(Subscribers::byEmail($this->email('conf'))['confirmed_at']);

        $this->post("/suscripcion/confirmar/{$row['token']}/", ['interests_sent' => '1', 'interests' => ['docentes', 'tecnologia']]);
        $row = Subscribers::byEmail($this->email('conf'));
        $this->assertSame('active', $row['status']);
        $this->assertSame('docentes,tecnologia', $row['interests']);
        $this->assertNotNull($row['confirmed_at']);
        $this->assertNotNull($row['confirmed_ip_hash']);
    }

    public function testSpamCannotConfirmOrReceive(): void
    {
        $spam = $this->subscriber('spam', 'spam');
        $this->assertSame(404, App::handle(Request::create('GET', "/suscripcion/confirmar/{$spam['token']}/"))->status);
        $this->post("/suscripcion/confirmar/{$spam['token']}/", ['interests_sent' => '1']);
        $this->assertSame('spam', Subscribers::byId((int) $spam['id'])['status']);
        // Volver a suscribirlo desde un formulario no lo reactiva ni le manda correo.
        Mailer::$sent = [];
        $this->post('/suscripcion/', ['email' => $spam['email']], ['HTTP_ACCEPT' => 'application/json']);
        $this->assertSame('spam', Subscribers::byId((int) $spam['id'])['status']);
        $this->assertSame([], Mailer::$sent);
    }

    public function testPreferenceCenterAndUnsubscribe(): void
    {
        $s = $this->subscriber('pref', 'active', 'excel');
        $url = "/suscripcion/preferencias/{$s['token']}/";
        $page = App::handle(Request::create('GET', $url));
        $this->assertSame(200, $page->status);
        $this->assertStringContainsString($s['email'], $page->body);
        $this->assertSame(200, $this->post($url, ['interests' => ['concurso', 'docentes'], 'locale' => 'en', 'pause' => '1m'])->status);
        $row = Subscribers::byId((int) $s['id']);
        $this->assertSame('docentes,concurso', $row['interests']);
        $this->assertSame('en', $row['locale']);
        $this->assertNotNull($row['paused_until']);

        // Baja con motivo (formulario, con CSRF); GET solo muestra el botón.
        App::handle(Request::create('GET', "/suscripcion/baja/{$s['token']}/"));
        $this->assertSame('active', Subscribers::byId((int) $s['id'])['status']);
        $this->post("/suscripcion/baja/{$s['token']}/", ['reason' => 'too_many', 'reason_text' => 'muchos']);
        $row = Subscribers::byId((int) $s['id']);
        $this->assertSame('unsubscribed', $row['status']);
        $this->assertStringContainsString('demasiados', (string) $row['unsubscribed_reason']);
        // Sin CSRF (y sin One-Click) no da de baja.
        $this->assertSame(419, $this->post("/suscripcion/baja/{$s['token']}/", ['_csrf' => 'x'], [], false)->status);
        // Volver desde el centro de preferencias.
        $this->post($url, ['interests' => ['excel']]);
        $this->assertSame('active', Subscribers::byId((int) $s['id'])['status']);
        $this->assertNull(Subscribers::byId((int) $s['id'])['paused_until']);
    }

    public function testOneClickUnsubscribeWithoutCsrf(): void
    {
        $s = $this->subscriber('oneclick');
        $issue = $this->createIssue(gmdate('Y-m-d H:i:s', time() + 3 * 86400), false);
        DB::insert('newsletter_sends', ['issue_id' => (int) $issue['id'], 'subscriber_id' => (int) $s['id'], 'email' => $s['email'], 'status' => 'sent']);
        $sendId = (int) DB::value('SELECT id FROM newsletter_sends WHERE subscriber_id = :s', ['s' => (int) $s['id']]);
        // Gmail/Yahoo: POST sin cookies ni CSRF, cuerpo List-Unsubscribe=One-Click (RFC 8058).
        $res = App::handle(Request::create('POST', "/suscripcion/baja/{$s['token']}/?n=$sendId", ['List-Unsubscribe' => 'One-Click']));
        $this->assertSame(200, $res->status);
        $this->assertSame('unsubscribed', Subscribers::byId((int) $s['id'])['status']);
        $this->assertNotNull(DB::value('SELECT unsubscribed_at FROM newsletter_sends WHERE id = :id', ['id' => $sendId]));
        $this->assertSame(1, (int) Sender::stats((int) $issue['id'])['unsubscribed']);
    }

    // ------------------------------------------------------------------ armado y correo

    public function testBuilderPersonalizesByInterests(): void
    {
        $issue = $this->fakeIssue();
        $pool = $issue['content']['es']['posts'];
        $this->assertSame(['post:1', 'post:2', 'post:3'], array_column(Builder::pickPosts($pool, [], 5), 'key'));
        // Solo concurso: el nuevo y, como hay menos de 3, el más reciente del tema (nunca Excel).
        $this->assertSame(['post:2', 'post:4'], array_column(Builder::pickPosts($pool, ['concurso'], 5), 'key'));
        $this->assertSame(['post:3'], array_column(Builder::pickPosts($pool, ['tecnologia'], 5), 'key'));
        $offers = Builder::pickOffers($issue['content']['es']['offers'], ['concurso'], 3, 'seed');
        $this->assertEqualsCanonicalizing(['product:2', 'tool:fundales'], array_column($offers, 'key'));
        $this->assertSame('tool', end($offers)['kind'], 'La herramienta gratis va al final');
        $personal = Builder::personalize($issue, 'es', ['excel']);
        $this->assertSame('Lo nuevo en edwinortiz.net: Fórmulas de Excel', $personal['subject']);
        $this->assertSame(['excel'], array_values(array_unique(array_merge(...array_column($personal['offers'], 'interests')))));
        // Clasificación de artículos y productos.
        $this->assertSame(['tecnologia', 'excel'], Interests::forPost('excel', 'Copilot y agentes en Excel'));
        $this->assertSame(['docentes'], Interests::forPost('ia-para-docentes', 'Proyecto de vida en el colegio'));
        $this->assertSame(['docentes', 'tecnologia'], Interests::forProduct(['sku' => 'PIAR-5', 'audience' => 'docente']));
        $this->assertSame(['excel'], Interests::forProduct(['sku' => 'X', 'audience' => 'oficina']));
    }

    public function testRenderedEmailHasHeadersTrackingAndUtm(): void
    {
        $s = $this->subscriber('render', 'active', 'excel');
        $issue = $this->fakeIssue();
        $mail = Renderer::render($issue, Builder::personalize($issue, 'es', ['excel']), $s, 4242);
        $this->assertMatchesRegularExpression('#^<https?://[^>]+/suscripcion/baja/' . $s['token'] . '/\?n=4242>, <mailto:[^>]+>$#', $mail['headers']['List-Unsubscribe']);
        $this->assertSame('List-Unsubscribe=One-Click', $mail['headers']['List-Unsubscribe-Post']);
        $this->assertStringContainsString('/n/c/4242/', $mail['html']);
        $this->assertStringContainsString(Tracking::openUrl(4242), $mail['html']);
        $this->assertStringContainsString(url("/suscripcion/preferencias/{$s['token']}/"), $mail['html']);
        $this->assertStringContainsString(rawurlencode('utm_source=newsletter&utm_medium=email&utm_campaign=' . $issue['issue_key']), $mail['html']);
        $this->assertStringContainsString('Fórmulas de Excel', $mail['text']);
        $this->assertStringNotContainsString('Concurso Docente', $mail['html']);
        // El Mailer pasa las cabeceras seguras y descarta las peligrosas.
        Mailer::$sent = [];
        Mailer::send('a@test.local', 's', '<p>x</p>', 'x', null, $mail['headers'] + ['X-Evil' => "a\r\nBcc: x@y.z", 'From' => 'x@y.z']);
        $sent = end(Mailer::$sent)['headers'];
        $this->assertArrayHasKey('List-Unsubscribe-Post', $sent);
        $this->assertArrayNotHasKey('X-Evil', $sent);
        $this->assertArrayNotHasKey('From', $sent);
    }

    public function testRealContentBuildsAndRendersBothLocales(): void
    {
        $content = Builder::content(gmdate('Y-m-d H:i:s', time() - 30 * 86400));
        $this->assertArrayHasKey('es', $content);
        foreach ($content['es']['posts'] as $p) {
            $this->assertTrue($p['image'] === null || preg_match('#^https?://.+\.(jpe?g|png|gif)$#i', $p['image']) === 1, 'Imágenes absolutas y sin WebP');
        }
        $issue = ['issue_key' => 'boletin-x', 'scheduled_for' => DB::now(), 'subject' => null, 'subject_manual' => 0, 'intro_es' => 'Hola', 'intro_en' => 'Hi', 'content' => $content];
        foreach (['es', 'en'] as $locale) {
            $mail = Renderer::render($issue, Builder::personalize($issue, $locale, []));
            $this->assertStringContainsString('<table role="presentation"', $mail['html']);
            $this->assertNotSame('', $mail['text']);
        }
    }

    // ------------------------------------------------------------------ envío

    public function testSenderBatchesAndNeverSendsTwice(): void
    {
        if (Sender::openIssue() !== null) {
            $this->markTestSkipped('Hay una edición abierta en la base de datos');
        }
        Setting::set('newsletter.batch', '5');
        Setting::clear();
        $active = [];
        for ($i = 0; $i < 7; $i++) {
            $active[] = $this->subscriber("act$i", 'active', $i % 2 ? 'excel' : 'concurso');
        }
        $spam = $this->subscriber('spm', 'spam');
        $pending = $this->subscriber('pen', 'pending');
        $paused = $this->subscriber('pau');
        DB::run('UPDATE subscribers SET paused_until = DATE_ADD(UTC_TIMESTAMP(), INTERVAL 10 DAY) WHERE id = :id', ['id' => (int) $paused['id']]);
        $issue = $this->createIssue(gmdate('Y-m-d H:i:s', time() - 60));
        $others = (int) DB::value('SELECT COUNT(*) FROM subscribers WHERE ' . Subscribers::RECEIVES . ' AND email NOT LIKE :e', ['e' => "%{$this->run}@test.local"]);

        Mailer::$sent = [];
        Sender::run();
        $this->assertSame('sending', DB::value('SELECT status FROM newsletter_issues WHERE id = :id', ['id' => (int) $issue['id']]));
        $this->assertSame(7 + $others, (int) DB::value('SELECT COUNT(*) FROM newsletter_sends WHERE issue_id = :i', ['i' => (int) $issue['id']]));
        $this->assertCount(5, Mailer::$sent, 'Un lote por ejecución');
        foreach ([$spam, $pending, $paused] as $excluded) {
            $this->assertNull(DB::value('SELECT id FROM newsletter_sends WHERE subscriber_id = :s', ['s' => (int) $excluded['id']]));
        }
        for ($i = 0; $i < 4 && DB::value('SELECT status FROM newsletter_issues WHERE id = :id', ['id' => (int) $issue['id']]) === 'sending'; $i++) {
            Sender::run();
        }
        Sender::run();
        Sender::start((int) $issue['id']); // un segundo inicio no vuelve a encolar
        Sender::run();
        $this->assertSame('sent', DB::value('SELECT status FROM newsletter_issues WHERE id = :id', ['id' => (int) $issue['id']]));
        $counts = array_count_values(array_column(Mailer::$sent, 'to'));
        foreach ($active as $s) {
            $this->assertSame(1, $counts[$s['email']] ?? 0, "Exactamente un correo a {$s['email']}");
            $this->assertSame(1, (int) Subscribers::byId((int) $s['id'])['sends_count']);
        }
        $first = Mailer::$sent[0];
        $this->assertArrayHasKey('List-Unsubscribe', $first['headers']);
        $this->assertStringContainsString('/n/o/', $first['html']);
    }

    public function testFailedSendsAreRetriedAndStaleOnesNotDuplicated(): void
    {
        if (Sender::openIssue() !== null) {
            $this->markTestSkipped('Hay una edición abierta en la base de datos');
        }
        $s = $this->subscriber('retry');
        $issue = $this->createIssue(gmdate('Y-m-d H:i:s', time() - 60));
        // SMTP inalcanzable: el envío falla y queda en cola para reintentar más tarde.
        Config::set('MAIL_DRIVER', 'smtp');
        Config::set('MAIL_HOST', '127.0.0.1');
        Config::set('MAIL_PORT', '1');
        Config::set('MAIL_ENCRYPTION', 'none');
        try {
            Sender::run();
        } finally {
            Config::set('MAIL_DRIVER', 'array');
        }
        $send = DB::one('SELECT * FROM newsletter_sends WHERE subscriber_id = :s', ['s' => (int) $s['id']]);
        $this->assertSame('queued', $send['status']);
        $this->assertSame(1, (int) $send['attempts']);
        $this->assertNotNull($send['next_attempt_at']);
        $this->assertNotNull($send['error']);
        // Antes de la hora del reintento no se toca.
        Mailer::$sent = [];
        Sender::run();
        $this->assertSame([], array_values(array_filter(Mailer::$sent, fn ($m) => $m['to'] === $s['email'])));
        // Un envío que quedó "sending" (proceso caído) pasa a fallido sin reintento.
        DB::run("UPDATE newsletter_sends SET status = 'sending', locked_at = DATE_SUB(UTC_TIMESTAMP(), INTERVAL 2 HOUR) WHERE id = :id", ['id' => (int) $send['id']]);
        Sender::run();
        $this->assertSame('failed', DB::value('SELECT status FROM newsletter_sends WHERE id = :id', ['id' => (int) $send['id']]));
        DB::run("UPDATE newsletter_issues SET status = 'cancelled' WHERE id = :id", ['id' => (int) $issue['id']]);
    }

    public function testTrackingRedirectsAreSigned(): void
    {
        $s = $this->subscriber('track');
        $issue = $this->createIssue(gmdate('Y-m-d H:i:s', time() + 3 * 86400), false);
        $sendId = DB::insert('newsletter_sends', ['issue_id' => (int) $issue['id'], 'subscriber_id' => (int) $s['id'], 'email' => $s['email'], 'status' => 'sent']);
        $target = url('/blog/?utm_source=newsletter');
        $click = Tracking::clickUrl($sendId, $target);
        $res = App::handle(Request::create('GET', (string) parse_url($click, PHP_URL_PATH) . '?' . parse_url($click, PHP_URL_QUERY)));
        $this->assertSame(302, $res->status);
        $this->assertSame($target, $res->headers['Location']);
        $row = DB::one('SELECT * FROM newsletter_sends WHERE id = :id', ['id' => $sendId]);
        $this->assertSame(1, (int) $row['clicks']);
        $this->assertNotNull($row['opened_at'], 'Un clic cuenta como apertura');
        $this->assertSame(1, (int) Subscribers::byId((int) $s['id'])['clicks_count']);
        $this->assertSame(1, (int) DB::value('SELECT COUNT(*) FROM newsletter_clicks WHERE send_id = :id', ['id' => $sendId]));

        // Firma inválida: nunca redirige fuera del sitio (no es una redirección abierta).
        $bad = '/n/c/' . $sendId . '/' . str_repeat('0', 32) . '/?u=' . rawurlencode('https://evil.example/');
        $this->assertSame(404, App::handle(Request::create('GET', $bad))->status);
        $badInternal = '/n/c/' . $sendId . '/' . str_repeat('0', 32) . '/?u=' . rawurlencode(url('/tienda/'));
        $this->assertSame(302, App::handle(Request::create('GET', $badInternal))->status);
        $this->assertSame(1, (int) DB::value('SELECT clicks FROM newsletter_sends WHERE id = :id', ['id' => $sendId]));

        $open = App::handle(Request::create('GET', (string) parse_url(Tracking::openUrl($sendId), PHP_URL_PATH)));
        $this->assertSame(200, $open->status);
        $this->assertSame('image/gif', $open->headers['Content-Type']);
        $this->assertSame(2, (int) DB::value('SELECT opens FROM newsletter_sends WHERE id = :id', ['id' => $sendId]));
        $this->assertSame(200, App::handle(Request::create('GET', "/n/o/$sendId/" . str_repeat('a', 32) . '/'))->status);
        $this->assertSame(2, (int) DB::value('SELECT opens FROM newsletter_sends WHERE id = :id', ['id' => $sendId]));
    }

    public function testScheduleEveryFifteenDaysOnTuesdayMorning(): void
    {
        $s = ['every_days' => 15, 'weekday' => 2, 'time' => '07:00'] + NewsletterSettings::all();
        $tz = new \DateTimeZone(NewsletterSettings::TZ);
        $now = (new \DateTimeImmutable('2026-10-08 10:00', $tz))->getTimestamp(); // jueves
        $first = (new \DateTimeImmutable('@' . NewsletterSettings::nextDue($s, null, $now)))->setTimezone($tz);
        $this->assertSame('2026-10-13 07:00 2', $first->format('Y-m-d H:i N'));
        $next = (new \DateTimeImmutable('@' . NewsletterSettings::nextDue($s, '2026-10-13 12:00:00', $now)))->setTimezone($tz);
        $this->assertSame('2026-10-27 07:00 2', $next->format('Y-m-d H:i N'), 'Martes + 15 días → el martes más cercano (cada dos semanas)');
        $exact = (new \DateTimeImmutable('@' . NewsletterSettings::nextDue(['weekday' => 0] + $s, '2026-10-13 12:00:00', $now)))->setTimezone($tz);
        $this->assertSame('2026-10-28 07:00', $exact->format('Y-m-d H:i'));
        // Calendario vencido: el siguiente horario con al menos 22 h para revisar la vista previa.
        $late = NewsletterSettings::nextDue($s, '2026-08-01 12:00:00', $now);
        $this->assertGreaterThanOrEqual($now + 22 * 3600, $late);
    }

    public function testTurnstileOnlyWhenConfigured(): void
    {
        $this->assertStringNotContainsString('challenges.cloudflare.com', \App\Services\Seo\SecurityHeaders::csp());
        Config::set('TURNSTILE_SITE_KEY', '0x4AAAAAAAtestsitekey');
        Config::set('TURNSTILE_SECRET', '0x4AAAAAAAtestsecret');
        $http = (new \Tests\Support\FakeHttpClient())
            ->on('POST', '#turnstile/v0/siteverify#', 200, fn ($url, $body) => ['success' => str_contains((string) $body, 'response=ok-token')]);
        \App\Services\Turnstile::http($http);
        try {
            $this->assertStringContainsString('challenges.cloudflare.com', \App\Services\Seo\SecurityHeaders::csp());
            $this->assertStringContainsString('cf-turnstile', App::handle(Request::create('GET', '/contacto/'))->body);
            $json = ['HTTP_ACCEPT' => 'application/json'];
            $this->assertSame(422, $this->post('/suscripcion/', ['email' => $this->email('ts')], $json)->status);
            $this->assertSame(422, $this->post('/suscripcion/', ['email' => $this->email('ts'), 'cf-turnstile-response' => 'bad'], $json)->status);
            $this->assertNull(Subscribers::byEmail($this->email('ts')));
            $this->assertSame(200, $this->post('/suscripcion/', ['email' => $this->email('ts'), 'cf-turnstile-response' => 'ok-token'], $json)->status);
            $this->assertNotNull(Subscribers::byEmail($this->email('ts')));
        } finally {
            Config::set('TURNSTILE_SITE_KEY', '');
            Config::set('TURNSTILE_SECRET', '');
            \App\Services\Turnstile::http(null);
        }
    }

    // ------------------------------------------------------------------ panel

    private function loginAdmin(): void
    {
        DB::insert('admin_users', ['email' => $this->email('admin'), 'name' => 'Admin', 'password_hash' => password_hash('clave-segura-123', PASSWORD_ARGON2ID)]);
        $res = $this->post('/admin/acceso/', ['email' => $this->email('admin'), 'password' => 'clave-segura-123']);
        $this->assertSame(303, $res->status);
    }

    public function testAdminFiltersBulkActionsExportAndNewsletterPages(): void
    {
        $this->loginAdmin();
        $excel = $this->subscriber('adm-excel', 'active', 'excel');
        $conc = $this->subscriber('adm-conc', 'active', 'concurso');
        DB::update('subscribers', ['source_title' => '=HYPERLINK("x")'], ['id' => (int) $conc['id']]);
        $page = App::handle(Request::create('GET', '/admin/suscriptores/?estado=active&tema=excel&q=' . $this->run));
        $this->assertSame(200, $page->status);
        $this->assertStringContainsString($excel['email'], $page->body);
        $this->assertStringNotContainsString($conc['email'], $page->body);
        $this->assertSame(200, App::handle(Request::create('GET', '/admin/suscriptores/?origen=home&estado=paused'))->status);

        $csv = App::handle(Request::create('GET', '/admin/suscriptores/exportar/?q=' . $this->run));
        $this->assertStringContainsString('text/csv', $csv->headers['Content-Type']);
        $this->assertStringContainsString('intereses', $csv->body);
        $this->assertStringContainsString("'=HYPERLINK", $csv->body);

        $this->post('/admin/suscriptores/acciones/', ['action' => 'interests', 'ids' => [(int) $excel['id']], 'interests' => ['docentes', 'excel']]);
        $this->assertSame('docentes,excel', Subscribers::byId((int) $excel['id'])['interests']);
        $this->post('/admin/suscriptores/acciones/', ['action' => 'spam', 'ids' => [(int) $conc['id']]]);
        $this->assertSame('spam', Subscribers::byId((int) $conc['id'])['status']);
        $pending = $this->subscriber('adm-pen', 'pending');
        Mailer::$sent = [];
        $this->post('/admin/suscriptores/acciones/', ['action' => 'resend', 'ids' => [(int) $pending['id'], (int) $excel['id']]]);
        $this->assertSame([$pending['email']], array_column(Mailer::$sent, 'to'), 'Solo a los pendientes');
        $this->post('/admin/suscriptores/acciones/', ['action' => 'delete', 'ids' => [(int) $conc['id']]]);
        $this->assertNull(Subscribers::byId((int) $conc['id']));

        foreach (['/admin/boletin/', '/admin/boletin/?perfil[]=excel&ancho=390', '/admin/boletin/historial/', '/admin/boletin/ajustes/', '/admin/boletin/vista-previa/?perfil=concurso'] as $path) {
            $this->assertSame(200, App::handle(Request::create('GET', $path))->status, $path);
        }
        $preview = App::handle(Request::create('GET', '/admin/boletin/vista-previa/?idioma=en'));
        $this->assertStringContainsString('edwinortiz.net', $preview->body);
        Mailer::$sent = [];
        $this->post('/admin/boletin/prueba/', ['interests' => ['excel']]);
        $this->assertSame($this->email('admin'), end(Mailer::$sent)['to']);
        $this->assertStringStartsWith('[Prueba]', end(Mailer::$sent)['subject']);
        // Ajustes.
        $this->post('/admin/boletin/ajustes/', ['enabled' => '1', 'every_days' => '15', 'weekday' => '2', 'time' => '07:00', 'mode' => 'approval', 'articles' => '4', 'products' => '2', 'batch' => '40', 'address' => 'Barranquilla']);
        Setting::clear();
        $this->assertSame('approval', NewsletterSettings::all()['mode']);
        $this->assertSame(4, NewsletterSettings::all()['articles']);
        // Preparar, posponer y cancelar (si no hay otra abierta).
        if (Sender::openIssue() === null) {
            $this->post('/admin/boletin/preparar/', []);
            $open = Sender::openIssue();
            $this->assertNotNull($open);
            $this->issues[] = (int) $open['id'];
            $this->post('/admin/boletin/' . $open['id'] . '/', ['do' => 'postpone', 'days' => '7']);
            $this->assertSame(strtotime($open['scheduled_for'] . ' UTC') + 7 * 86400, strtotime(DB::value('SELECT scheduled_for FROM newsletter_issues WHERE id = :id', ['id' => (int) $open['id']]) . ' UTC'));
            $this->post('/admin/boletin/' . $open['id'] . '/', ['do' => 'save', 'subject' => 'Asunto a mano', 'intro_es' => 'Intro a mano', 'intro_en' => 'Manual intro']);
            $saved = Builder::issue((int) $open['id']);
            $this->assertSame(1, (int) $saved['subject_manual']);
            $this->assertSame('manual', $saved['intro_source']);
            $this->post('/admin/boletin/' . $open['id'] . '/', ['do' => 'cancel']);
            $this->assertSame('cancelled', DB::value('SELECT status FROM newsletter_issues WHERE id = :id', ['id' => (int) $open['id']]));
        }
    }
}
