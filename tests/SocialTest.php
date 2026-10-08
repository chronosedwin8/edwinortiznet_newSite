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
use App\Core\Session;
use App\Services\Ai\Gemini;
use App\Services\Social\Accounts;
use App\Services\Social\CaptionWriter;
use App\Services\Social\Catalog;
use App\Services\Social\Channels;
use App\Services\Social\Connector;
use App\Services\Social\ImageMaker;
use App\Services\Social\MetaClient;
use App\Services\Social\Planner;
use App\Services\Social\Publisher;
use App\Services\Social\Queue;
use App\Services\Social\TokenVault;
use PHPUnit\Framework\TestCase;

/**
 * Publicación automática en redes (Facebook e Instagram): cifrado de tokens, conexión, planificador,
 * textos, publicador (con la API de Meta simulada) y páginas del panel y de /enlaces/.
 * Nada de esto llama a la red: MetaClient::fake y Gemini::fake sustituyen las API.
 */
final class SocialTest extends TestCase
{
    private string $run;
    private int $adminId = 0;
    private array $calls = [];
    /** @var array<int, array{0:string, 1:string, 2:callable|array}> */
    private array $routes = [];
    private array $config = [];

    protected function setUp(): void
    {
        try {
            DB::value('SELECT COUNT(*) FROM social_channels');
        } catch (\Throwable) {
            $this->markTestSkipped('Base de datos o migración 018 no disponible');
        }
        $this->run = bin2hex(random_bytes(3));
        Config::set('MAIL_DRIVER', 'array');
        Config::set('PAGE_CACHE', 'false');
        foreach (['META_APP_ID', 'META_APP_SECRET', 'ADMIN_EMAIL', 'SOCIAL_CRON_TOKEN'] as $key) {
            $this->config[$key] = Config::get($key);
        }
        Config::set('META_APP_ID', '1234567890');
        Config::set('META_APP_SECRET', 'secreto-de-prueba');
        Config::set('ADMIN_EMAIL', 'admin@test.local');
        RateLimiter::disable();
        Session::fake();
        Csrf::reset();
        Mailer::$sent = [];
        ImageMaker::$disabled = true;
        Publisher::$pollDelay = 0;
        MetaClient::fake(function (string $method, string $url, array $params): array {
            $this->calls[] = [$method, $url, $params];
            foreach ($this->routes as [$m, $pattern, $response]) {
                if ($m === $method && preg_match($pattern, $url)) {
                    $r = is_callable($response) ? $response($params) : $response;
                    return ['status' => $r[0], 'body' => (string) json_encode($r[1])];
                }
            }
            return ['status' => 404, 'body' => '{"error":{"message":"ruta no simulada","code":100}}'];
        });
    }

    protected function tearDown(): void
    {
        MetaClient::fake(null);
        Gemini::fake(null);
        ImageMaker::$disabled = false;
        Publisher::$pollDelay = 3;
        foreach ($this->config as $key => $value) {
            Config::set($key, $value);
        }
        if (!isset($this->run)) {
            return;
        }
        DB::run('DELETE FROM social_channels WHERE `key` LIKE :k', ['k' => "test-{$this->run}%"]);
        DB::run('DELETE FROM social_accounts WHERE external_id LIKE :e', ['e' => "%{$this->run}%"]);
        DB::run('DELETE FROM posts WHERE slug LIKE :s', ['s' => "prueba-redes-{$this->run}%"]);
        if ($this->adminId > 0) {
            DB::run('DELETE FROM admin_users WHERE id = :id', ['id' => $this->adminId]);
        }
        RateLimiter::disable(false);
    }

    private function on(string $method, string $pattern, callable|array $response): void
    {
        array_unshift($this->routes, [$method, $pattern, $response]);
    }

    private function callsTo(string $method, string $pattern): array
    {
        return array_values(array_filter($this->calls, fn ($c) => $c[0] === $method && preg_match($pattern, $c[1])));
    }

    /** @return array{fb:int, ig:int} */
    private function accounts(): array
    {
        return [
            'fb' => Accounts::store('fb', "page-{$this->run}", ['name' => 'Página prueba', 'page_id' => "page-{$this->run}"], "tok-fb-{$this->run}"),
            'ig' => Accounts::store('ig', "ig-{$this->run}", ['name' => 'IG prueba', 'username' => 'prueba', 'page_id' => "page-{$this->run}"], "tok-fb-{$this->run}"),
        ];
    }

    private function channel(array $accounts, array $content, int $autoApprove = 0): array
    {
        $id = DB::insert('social_channels', [
            'key' => "test-{$this->run}-" . bin2hex(random_bytes(2)),
            'name' => 'Canal de prueba',
            'fb_account_id' => $accounts['fb'] ?? null,
            'ig_account_id' => $accounts['ig'] ?? null,
            'schedule_json' => json_encode(['days' => [1, 2, 3, 4, 5, 6, 7], 'time' => '10:00', 'tz' => 'America/Bogota']),
            'content_json' => json_encode($content),
            'auto_approve' => $autoApprove,
            'active' => 0, // inactivo: el planificador real (social:plan) no lo toca
        ]);
        return Channels::find($id);
    }

    private function row(int $channelId, string $network, int $accountId, array $extra = []): int
    {
        return DB::insert('social_posts', $extra + [
            'group_key' => substr(bin2hex(random_bytes(10)), 0, 20),
            'channel_id' => $channelId,
            'network' => $network,
            'account_id' => $accountId,
            'content_type' => 'tool',
            'content_key' => 'tool:qr',
            'title' => 'Generador de código QR',
            'link' => 'https://www.edwinortiz.net/herramientas/generador-qr/?utm_source=' . ($network === 'fb' ? 'facebook' : 'instagram'),
            'caption' => 'Texto de prueba para la publicación.',
            'hashtags' => '#Excel #QR',
            'image_path' => '/social/prueba.jpg',
            'image_url' => 'https://www.edwinortiz.net/social/prueba.jpg',
            'scheduled_at' => gmdate('Y-m-d H:i:s', time() - 60),
            'status' => 'approved',
        ]);
    }

    private function post(int $id): array
    {
        return DB::one('SELECT * FROM social_posts WHERE id = :id', ['id' => $id]);
    }

    public function testTokenVaultRoundtrip(): void
    {
        $a = TokenVault::encrypt('EAAtoken-secreto');
        $b = TokenVault::encrypt('EAAtoken-secreto');
        $this->assertStringStartsWith('v1:', $a);
        $this->assertNotSame($a, $b, 'Cada cifrado usa un nonce nuevo');
        $this->assertStringNotContainsString('secreto', $a);
        $this->assertSame('EAAtoken-secreto', TokenVault::decrypt($a));
        $tampered = substr($a, 0, -4) . (str_ends_with($a, 'AAAA') ? 'BBBB' : 'AAAA');
        $this->assertNull(TokenVault::decrypt($tampered));
        $this->assertNull(TokenVault::decrypt('texto-plano'));
        $this->assertSame('[token]', MetaClient::scrub('EAA' . str_repeat('x', 40)));
    }

    public function testConnectorStoresPagesAndInstagramEncrypted(): void
    {
        $this->on('GET', '#/oauth/access_token$#', fn (array $p) => [200, ['access_token' => "LARGO-{$this->run}-" . str_repeat('a', 30), 'token_type' => 'bearer']]);
        $this->on('GET', '#/debug_token$#', [200, ['data' => ['is_valid' => true, 'expires_at' => 0]]]);
        $this->on('GET', '#/me/accounts$#', [200, ['data' => [
            ['id' => "p1-{$this->run}", 'name' => 'Página uno', 'username' => 'paginauno', 'access_token' => "PAGE1-{$this->run}",
                'instagram_business_account' => ['id' => "i1-{$this->run}", 'username' => 'cuentaig', 'name' => 'Cuenta IG']],
            ['id' => "p2-{$this->run}", 'name' => 'Página dos', 'access_token' => "PAGE2-{$this->run}"],
        ]]]);
        $result = Connector::connectMeta('EAAcorto' . str_repeat('b', 40));
        $this->assertSame(2, $result['pages']);
        $this->assertSame(1, $result['instagram']);
        $this->assertNull($result['user_expires_at'], 'expires_at 0 = no vence');

        // El intercambio usa el secreto de la app; /me/accounts usa el token largo.
        $exchange = $this->callsTo('GET', '#/oauth/access_token$#')[0][2];
        $this->assertSame('fb_exchange_token', $exchange['grant_type']);
        $this->assertSame('secreto-de-prueba', $exchange['client_secret']);
        $this->assertStringStartsWith("LARGO-{$this->run}", $this->callsTo('GET', '#/me/accounts$#')[0][2]['access_token']);

        $fb = DB::one('SELECT * FROM social_accounts WHERE network = "fb" AND external_id = :e', ['e' => "p1-{$this->run}"]);
        $ig = DB::one('SELECT * FROM social_accounts WHERE network = "ig" AND external_id = :e', ['e' => "i1-{$this->run}"]);
        $this->assertNotNull($fb);
        $this->assertNotNull($ig);
        $this->assertStringNotContainsString('PAGE1', (string) $fb['token_enc'], 'El token se guarda cifrado');
        $this->assertSame("PAGE1-{$this->run}", Accounts::token($fb));
        $this->assertSame("PAGE1-{$this->run}", Accounts::token($ig), 'Instagram publica con el token de su página');
        $this->assertSame("p1-{$this->run}", $ig['page_id']);
        $this->assertNull($fb['token_expires_at']);
        $this->assertSame(['never', null, null], Accounts::expiry($fb['token_expires_at']));

        // Volver a conectar actualiza (no duplica) y reactiva una cuenta marcada para reconectar.
        DB::update('social_accounts', ['status' => 'reconnect'], ['id' => (int) $fb['id']]);
        Connector::connectMeta('EAAcorto' . str_repeat('b', 40));
        $this->assertSame(1, (int) DB::value('SELECT COUNT(*) FROM social_accounts WHERE external_id = :e', ['e' => "p1-{$this->run}"]));
        $this->assertSame('active', DB::value('SELECT status FROM social_accounts WHERE id = :id', ['id' => (int) $fb['id']]));
    }

    public function testPlannerRespectsRulesMixAndNoRepeats(): void
    {
        $hub = DB::value("SELECT id FROM hubs WHERE `key` = 'concurso-docente'");
        if ($hub === null) {
            $this->markTestSkipped('Sin el hub concurso-docente');
        }
        // Cuatro entradas nuevas del hub (las más recientes: el planificador las elige primero).
        $mine = [];
        for ($i = 1; $i <= 4; $i++) {
            $id = DB::insert('posts', [
                'type' => 'post', 'locale' => 'es', 'translation_group' => sprintf('%08x-0000-4000-8000-%012x', random_int(0, 0xffffffff), $i),
                'slug' => "prueba-redes-{$this->run}-$i", 'title' => "Entrada de prueba $i", 'excerpt' => 'Resumen de la entrada de prueba.',
                'content_text' => 'Contenido de prueba.', 'hub_id' => (int) $hub, 'status' => 'published',
                'published_at' => gmdate('Y-m-d H:i:s', time() - 60 * $i),
            ]);
            $mine[$i] = 'post:' . $id;
        }
        $accounts = $this->accounts();
        $channel = $this->channel($accounts, ['types' => ['post', 'tool'], 'hubs_include' => ['concurso-docente'], 'tools' => ['fundales']]);

        foreach (Catalog::candidates($channel['content']) as $item) {
            $this->assertContains($item['type'], ['post', 'tool']);
            $item['type'] === 'post' ? $this->assertSame('concurso-docente', $item['hub_key']) : $this->assertSame('tool:fundales', $item['key']);
        }

        $picked = [];
        $base = strtotime('tomorrow 15:00 UTC');
        for ($d = 0; $d < 5; $d++) {
            $slot = gmdate('Y-m-d H:i:s', $base + $d * 86400);
            $item = Planner::pick($channel, $slot);
            $this->assertNotNull($item);
            Queue::createGroup($channel, $item, $slot, Channels::accounts($channel), 'planner', false);
            $picked[] = $item['key'];
        }
        // Lo más reciente primero, el 4.º es la herramienta (mezcla 1 de cada 4) y no se repite nada.
        $this->assertSame([$mine[1], $mine[2], $mine[3], 'tool:fundales', $mine[4]], $picked);
        $this->assertSame(count($picked), count(array_unique($picked)));

        // Cada grupo tiene una fila por red, en borrador, con UTM y texto de plantilla.
        $rows = DB::all('SELECT * FROM social_posts WHERE channel_id = :c ORDER BY scheduled_at, network', ['c' => (int) $channel['id']]);
        $this->assertCount(10, $rows);
        $this->assertSame(['fb', 'ig'], array_column(array_slice($rows, 0, 2), 'network'));
        foreach ($rows as $r) {
            $this->assertSame('draft', $r['status']);
            $this->assertSame('template', $r['caption_source']);
            $this->assertStringContainsString('utm_source=' . ($r['network'] === 'fb' ? 'facebook' : 'instagram') . '&utm_medium=social&utm_campaign=auto', $r['link']);
        }

        // Repetición: nunca dentro de 30 días; sí después de 45, y detrás de lo nunca compartido.
        $soon = array_column(Planner::ranked($channel, gmdate('Y-m-d H:i:s', $base + 20 * 86400)), 'key');
        $this->assertNotContains($mine[1], $soon);
        $later = array_column(Planner::ranked($channel, gmdate('Y-m-d H:i:s', $base + 60 * 86400)), 'key');
        $this->assertContains($mine[1], $later);
        $sharedSeen = false;
        foreach ($later as $key) {
            $shared = in_array($key, $picked, true);
            $this->assertFalse($sharedSeen && !$shared, 'Lo nunca compartido va antes que lo que se repite');
            $sharedSeen = $sharedSeen || $shared;
        }
        // Omitida no cuenta como compartida.
        DB::run("UPDATE social_posts SET status = 'skipped' WHERE channel_id = :c AND content_key = :k", ['c' => (int) $channel['id'], 'k' => $mine[1]]);
        $this->assertContains($mine[1], array_column(Planner::ranked($channel, gmdate('Y-m-d H:i:s', $base + 86400)), 'key'));
    }

    public function testCaptionWriterAiAndFallback(): void
    {
        $item = Catalog::item('tool:qr');
        $this->assertNotNull($item);
        // La IA falla: plantilla determinista.
        Gemini::fake(fn () => ['status' => 500, 'body' => '{"error":{"status":"INTERNAL"}}']);
        $t = CaptionWriter::write($item);
        $this->assertSame('template', $t['source']);
        $this->assertStringContainsString($item['title'], $t['fb']['text']);
        $this->assertStringContainsString('Enlace en la bio', $t['ig']['text']);
        $this->assertGreaterThanOrEqual(3, count($t['fb']['hashtags']));
        $this->assertSame($t, CaptionWriter::write($item, [], false), 'Sin IA, mismo resultado');

        // La IA responde: se limpian URLs y hashtags del texto, se normalizan las etiquetas y se agrega el CTA de Instagram.
        $sent = null;
        Gemini::fake(function (string $url, array $headers, array $body) use (&$sent): array {
            $sent = $body;
            $json = [
                'facebook' => ['text' => "¿Necesitas un QR para tu negocio?\nCréalo gratis en segundos y descárgalo en PNG o SVG. Visita https://edwinortiz.net/x #QR", 'hashtags' => ['#CódigoQR', 'Excel', 'excel', 'Productividad', 'Mi Hashtag']],
                'instagram' => ['text' => str_repeat('Un código QR bien hecho ahorra tiempo en el aula y en la oficina. ', 12), 'hashtags' => ['QR', 'Excel', 'Docentes', 'Productividad', 'Oficina', 'Tecnologia', 'Colombia', 'Tips']],
            ];
            return ['status' => 200, 'body' => (string) json_encode(['candidates' => [['content' => ['parts' => [['text' => json_encode($json)]]], 'finishReason' => 'STOP']], 'usageMetadata' => ['promptTokenCount' => 10, 'candidatesTokenCount' => 10]])];
        });
        $ai = CaptionWriter::write($item, ['¿Necesitas un QR?']);
        $this->assertSame('ai', $ai['source']);
        $this->assertSame(2048, $sent['generationConfig']['maxOutputTokens']);
        $this->assertStringContainsString('¿Necesitas un QR?', $sent['contents'][0]['parts'][0]['text'], 'Pasa las aperturas recientes');
        $this->assertStringNotContainsString('http', $ai['fb']['text']);
        $this->assertStringNotContainsString('#QR', $ai['fb']['text']);
        $this->assertSame(['CódigoQR', 'Excel', 'Productividad', 'MiHashtag'], $ai['fb']['hashtags']);
        $this->assertStringEndsWith('Enlace en la bio 🔗', $ai['ig']['text']);

        $link = 'https://www.edwinortiz.net/herramientas/generador-qr/?utm_source=facebook';
        $fb = CaptionWriter::message('fb', $ai['fb']['text'], CaptionWriter::formatTags($ai['fb']['hashtags']), $link);
        $this->assertStringContainsString("\n\n" . $link . "\n\n#CódigoQR #Excel", $fb);
        $ig = CaptionWriter::message('ig', 'Texto corto.', '#A #B', $link);
        $this->assertStringNotContainsString('utm_source', $ig, 'En Instagram no va el enlace');
        $this->assertStringContainsString('Enlace en la bio', $ig);
    }

    public function testPublisherFacebookAndInstagramWithPolling(): void
    {
        $acc = $this->accounts();
        $channel = $this->channel($acc, ['types' => ['tool'], 'tools' => ['qr']]);
        $group = 'g' . substr(bin2hex(random_bytes(10)), 0, 19);
        $fbRow = $this->row((int) $channel['id'], 'fb', $acc['fb'], ['group_key' => $group]);
        $igRow = $this->row((int) $channel['id'], 'ig', $acc['ig'], ['group_key' => $group]);
        $page = "page-{$this->run}";
        $ig = "ig-{$this->run}";
        $this->on('POST', "#/$page/feed$#", [200, ['id' => "{$page}_111"]]);
        $this->on('GET', "#/{$page}_111$#", [200, ['permalink_url' => 'https://www.facebook.com/prueba/posts/111']]);
        $this->on('POST', "#/$ig/media$#", [200, ['id' => 'contenedor-1']]);
        $polls = 0;
        $this->on('GET', '#/contenedor-1$#', function () use (&$polls): array {
            $polls++;
            return [200, ['status_code' => $polls === 1 ? 'IN_PROGRESS' : 'FINISHED']];
        });
        $this->on('POST', "#/$ig/media_publish$#", [200, ['id' => 'media-9']]);
        $this->on('GET', '#/media-9$#', [200, ['permalink' => 'https://www.instagram.com/p/abc/']]);

        Publisher::publishRow($fbRow);
        $fb = $this->post($fbRow);
        $this->assertSame('published', $fb['status']);
        $this->assertSame("{$page}_111", $fb['external_id']);
        $this->assertSame('https://www.facebook.com/prueba/posts/111', $fb['permalink']);
        $feed = $this->callsTo('POST', "#/$page/feed$#")[0][2];
        $this->assertSame("tok-fb-{$this->run}", $feed['access_token']);
        $this->assertStringContainsString('utm_source=facebook', $feed['message']);
        $this->assertSame($fb['link'], $feed['link']);

        // Instagram: el contenedor sigue en proceso → queda aprobado, con el contenedor guardado y sin gastar intento.
        Publisher::publishRow($igRow);
        $row = $this->post($igRow);
        $this->assertSame('approved', $row['status']);
        $this->assertSame('contenedor-1', $row['container_id']);
        $this->assertSame(0, (int) $row['attempts']);
        $this->assertGreaterThan(gmdate('Y-m-d H:i:s'), $row['next_attempt_at']);
        $media = $this->callsTo('POST', "#/$ig/media$#")[0][2];
        $this->assertSame('https://www.edwinortiz.net/social/prueba.jpg', $media['image_url']);
        $this->assertStringContainsString('Enlace en la bio', $media['caption']);

        // Siguiente ejecución: retoma el mismo contenedor (no crea otro) y publica.
        Publisher::publishRow($igRow);
        $row = $this->post($igRow);
        $this->assertSame('published', $row['status']);
        $this->assertSame('media-9', $row['external_id']);
        $this->assertSame('https://www.instagram.com/p/abc/', $row['permalink']);
        $this->assertNull($row['container_id']);
        $this->assertCount(1, $this->callsTo('POST', "#/$ig/media$#"));
        $this->assertCount(1, $this->callsTo('POST', "#/$ig/media_publish$#"));

        // Idempotente: una fila publicada no se vuelve a tomar.
        Publisher::publishRow($fbRow);
        $this->assertCount(1, $this->callsTo('POST', "#/$page/feed$#"));
        $this->assertSame([], Mailer::$sent);
    }

    public function testPublisherRetriesWithBackoffThenFailsAndEmails(): void
    {
        $acc = $this->accounts();
        $channel = $this->channel($acc, ['types' => ['tool'], 'tools' => ['qr']]);
        $id = $this->row((int) $channel['id'], 'fb', $acc['fb']);
        $this->on('POST', "#/page-{$this->run}/feed$#", [500, ['error' => ['message' => 'An unexpected error has occurred', 'code' => 2, 'is_transient' => true]]]);

        Publisher::publishRow($id);
        $row = $this->post($id);
        $this->assertSame('approved', $row['status']);
        $this->assertSame(1, (int) $row['attempts']);
        $this->assertStringContainsString('unexpected', (string) $row['error']);
        $wait = strtotime($row['next_attempt_at'] . ' UTC') - time();
        $this->assertGreaterThan(4 * 60, $wait);
        $this->assertLessThanOrEqual(5 * 60, $wait);
        // Mientras no llegue la hora del reintento, no está vencida.
        $due = DB::value('SELECT COUNT(*) FROM social_posts WHERE id = :id AND next_attempt_at <= UTC_TIMESTAMP()', ['id' => $id]);
        $this->assertSame(0, (int) $due);

        for ($i = 2; $i <= 3; $i++) {
            DB::update('social_posts', ['next_attempt_at' => null], ['id' => $id]);
            Publisher::publishRow($id);
        }
        $row = $this->post($id);
        $this->assertSame('failed', $row['status']);
        $this->assertSame(3, (int) $row['attempts']);
        $this->assertCount(1, Mailer::$sent);
        $this->assertSame('admin@test.local', Mailer::$sent[0]['to']);
        $this->assertStringContainsString('no se pudo publicar', mb_strtolower(Mailer::$sent[0]['subject']));

        // «Volver a aprobar» desde el historial lo deja listo para otro ciclo de intentos.
        Queue::setStatus($row['group_key'], 'approved');
        $row = $this->post($id);
        $this->assertSame('approved', $row['status']);
        $this->assertSame(0, (int) $row['attempts']);
    }

    public function testTokenErrorMarksAccountForReconnectAndEmailsOnce(): void
    {
        $acc = $this->accounts();
        $channel = $this->channel($acc, ['types' => ['tool'], 'tools' => ['qr']]);
        $first = $this->row((int) $channel['id'], 'fb', $acc['fb']);
        $this->on('POST', "#/page-{$this->run}/feed$#", [400, ['error' => ['message' => 'Error validating access token: Session has expired', 'type' => 'OAuthException', 'code' => 190, 'error_subcode' => 463]]]);

        Publisher::publishRow($first);
        $row = $this->post($first);
        $this->assertSame('failed', $row['status'], 'Con token inválido no se reintenta');
        $this->assertStringContainsString('reconecta', mb_strtolower((string) $row['error']));
        $account = Accounts::find($acc['fb']);
        $this->assertSame('reconnect', $account['status']);
        $this->assertCount(1, Mailer::$sent);
        $this->assertStringContainsString('reconecta', mb_strtolower(Mailer::$sent[0]['subject']));

        // Las demás filas de esa cuenta no llaman a la API y no repiten el correo.
        $second = $this->row((int) $channel['id'], 'fb', $acc['fb']);
        Publisher::publishRow($second);
        $this->assertSame('failed', $this->post($second)['status']);
        $this->assertCount(1, $this->callsTo('POST', "#/page-{$this->run}/feed$#"));
        Accounts::tokenFailed($acc['fb'], 'otra vez');
        $this->assertCount(1, Mailer::$sent, 'Un aviso cada 24 h como máximo');

        // Comprobar la conexión con un token válido la reactiva.
        $this->on('GET', "#/page-{$this->run}$#", [200, ['id' => "page-{$this->run}", 'name' => 'Página prueba']]);
        $this->on('GET', "#/ig-{$this->run}/content_publishing_limit$#", [200, ['data' => [['quota_usage' => 3, 'config' => ['quota_total' => 100]]]]]);
        Connector::check([$acc['fb'], $acc['ig']]);
        $this->assertSame('active', Accounts::find($acc['fb'])['status']);
        $info = Accounts::decodeInfo(Accounts::find($acc['ig']));
        $this->assertSame(3, $info['quota_usage']);
        $this->assertSame(100, $info['quota_total']);
    }

    public function testAdminPagesRequireLoginAndGroupActions(): void
    {
        foreach (['/admin/redes/', '/admin/redes/historial/', '/admin/redes/ajustes/'] as $path) {
            $res = App::handle(Request::create('GET', $path));
            $this->assertSame(303, $res->status, $path);
            $this->assertSame('/admin/acceso/', $res->headers['Location'] ?? null);
        }
        $this->assertSame(303, App::handle(Request::create('POST', '/admin/redes/planificar/'))->status);

        $this->adminId = DB::insert('admin_users', ['email' => "redes-{$this->run}@test.local", 'name' => 'Admin redes', 'password_hash' => password_hash('clave-segura-123', PASSWORD_ARGON2ID)]);
        Session::set('admin_id', $this->adminId);
        $acc = $this->accounts();
        $channel = $this->channel($acc, ['types' => ['tool'], 'tools' => ['qr']]);
        $group = substr(bin2hex(random_bytes(10)), 0, 20);
        $future = gmdate('Y-m-d H:i:s', time() + 86400);
        $this->row((int) $channel['id'], 'fb', $acc['fb'], ['group_key' => $group, 'status' => 'draft', 'scheduled_at' => $future]);
        $this->row((int) $channel['id'], 'ig', $acc['ig'], ['group_key' => $group, 'status' => 'draft', 'scheduled_at' => $future]);

        $queue = App::handle(Request::create('GET', '/admin/redes/'));
        $this->assertSame(200, $queue->status);
        $this->assertStringContainsString('id="g-' . $group . '"', $queue->body);
        $this->assertStringContainsString('Enlace en la bio', $queue->body, 'Vista previa del texto de Instagram');
        $this->assertSame(200, App::handle(Request::create('GET', '/admin/redes/historial/'))->status);
        $settings = App::handle(Request::create('GET', '/admin/redes/ajustes/'));
        $this->assertSame(200, $settings->status);
        $this->assertStringContainsString('Minuevoblog', $settings->body);
        $this->assertStringNotContainsString("tok-fb-{$this->run}", $settings->body, 'El panel nunca muestra tokens');

        $csrf = Csrf::token(Request::create('GET', '/'));
        $post = fn (array $data) => App::handle(Request::create('POST', "/admin/redes/grupo/$group/", $data + ['_csrf' => $csrf], [], [Csrf::COOKIE => $csrf]));
        $res = $post(['action' => 'save_approve', 'caption' => ['fb' => 'Texto editado a mano.', 'ig' => 'Otro texto.'], 'hashtags' => ['fb' => 'Excel, #QR', 'ig' => '#Uno']]);
        $this->assertSame(303, $res->status);
        $rows = Queue::group($group);
        $this->assertSame(['approved', 'approved'], array_column($rows, 'status'));
        $this->assertSame('Texto editado a mano.', $rows[0]['caption']);
        $this->assertSame('#Excel #QR', $rows[0]['hashtags']);
        $this->assertSame('manual', $rows[0]['caption_source']);

        $post(['action' => 'reschedule', 'scheduled_local' => '2099-01-02T18:30']);
        $this->assertSame('2099-01-02 23:30:00', Queue::group($group)[0]['scheduled_at'], 'Hora de Colombia → UTC');
        $post(['action' => 'skip']);
        $this->assertSame(['skipped', 'skipped'], array_column(Queue::group($group), 'status'));
        $post(['action' => 'delete']);
        $this->assertSame([], Queue::group($group));
    }

    public function testLinksPageAndCronEndpoint(): void
    {
        $res = App::handle(Request::create('GET', '/enlaces/'));
        $this->assertSame(200, $res->status);
        $this->assertStringContainsString('noindex', $res->body);
        $this->assertStringContainsString('links__card', $res->body);
        $this->assertStringContainsString('utm_source=instagram', $res->body);

        Config::set('SOCIAL_CRON_TOKEN', '');
        $this->assertSame(404, App::handle(Request::create('GET', '/cron/redes/' . str_repeat('a', 40) . '/'))->status);
        Config::set('SOCIAL_CRON_TOKEN', str_repeat('b', 40));
        $this->assertSame(404, App::handle(Request::create('GET', '/cron/redes/' . str_repeat('a', 40) . '/'))->status);
        $this->assertSame(404, App::handle(Request::create('POST', '/cron/redes/' . str_repeat('c', 40) . '/'))->status);
    }
}
