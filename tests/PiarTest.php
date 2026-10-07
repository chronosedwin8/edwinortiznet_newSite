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
use App\Services\Ai\Gemini;
use App\Services\Orders\OrderService;
use App\Services\Payments\Status;
use App\Services\Piar\PiarCredits;
use App\Services\Piar\PiarPlans;
use App\Services\Piar\PiarProfile;
use PHPUnit\Framework\TestCase;

/**
 * PIAR con IA: acceso por enlace, prueba gratis (2, sin guardar), créditos por pedido aprobado (idempotente),
 * consumo y devolución, propiedad de los PIAR, PDF y estado. Gemini se simula.
 */
final class PiarTest extends TestCase
{
    private const DOMAIN = '@piartest.local';
    private string $csrf;
    private string $ip;
    private int $geminiCalls = 0;
    private int $geminiStatus = 200;
    private array $salesBefore = [];

    protected function setUp(): void
    {
        try {
            DB::value('SELECT COUNT(*) FROM piar_plans');
        } catch (\Throwable) {
            $this->markTestSkipped('Base de datos o migración 010 no disponibles');
        }
        if (DB::value('SELECT id FROM products WHERE sku = "PIAR-5"') === null) {
            DB::transaction(fn () => (require dirname(__DIR__) . '/database/seeds/11_piar.php')());
        }
        foreach (['MAIL_DRIVER' => 'array', 'PAGE_CACHE' => 'false', 'GEMINI_API_KEY' => 'test-key', 'GEMINI_MODEL' => 'gemini-2.5-pro', 'STORAGE_DISK' => 'local'] as $k => $v) {
            Config::set($k, $v);
        }
        RateLimiter::disable();
        Session::fake();
        Mailer::$sent = [];
        Csrf::reset();
        $this->csrf = Csrf::token(Request::create('GET', '/'));
        $this->ip = '10.' . random_int(1, 250) . '.' . random_int(1, 250) . '.' . random_int(1, 250);
        foreach (DB::all('SELECT id, sales_count FROM products WHERE sku LIKE "PIAR-%"') as $p) {
            $this->salesBefore[(int) $p['id']] = (int) $p['sales_count'];
        }
        $this->geminiCalls = 0;
        $this->geminiStatus = 200;
        Gemini::fake(function (string $url, array $headers, array $body): array {
            $this->geminiCalls++;
            // La clave va en la cabecera, nunca en la URL.
            $this->assertStringNotContainsString('test-key', $url);
            $this->assertContains('x-goog-api-key: test-key', $headers);
            $this->assertSame('application/json', $body['generationConfig']['responseMimeType']);
            if ($this->geminiStatus !== 200) {
                return ['status' => $this->geminiStatus, 'body' => '{"error":{"status":"UNAVAILABLE"}}'];
            }
            return ['status' => 200, 'body' => (string) json_encode([
                'candidates' => [['content' => ['parts' => [['text' => json_encode(self::sampleOutput(), JSON_UNESCAPED_UNICODE)]]], 'finishReason' => 'STOP']],
                'usageMetadata' => ['promptTokenCount' => 1200, 'candidatesTokenCount' => 3400],
                'modelVersion' => 'gemini-2.5-pro',
            ])];
        });
    }

    protected function tearDown(): void
    {
        if (!isset($this->csrf)) {
            return;
        }
        Gemini::fake(null);
        DB::run('DELETE FROM orders WHERE email LIKE :e', ['e' => '%' . self::DOMAIN]);
        DB::run('DELETE FROM customers WHERE email LIKE :e', ['e' => '%' . self::DOMAIN]);
        foreach ($this->salesBefore as $id => $count) {
            DB::run('UPDATE products SET sales_count = :s WHERE id = :id', ['s' => $count, 'id' => $id]);
        }
        RateLimiter::disable(false);
    }

    // ------------------------------------------------------------------ ayudas

    private static function sampleOutput(): array
    {
        return [
            'resumen' => 'S. es una estudiante curiosa que aprende mejor con apoyos visuales. RESUMEN-DE-PRUEBA',
            'contexto' => ['familiar' => 'Vive con su madre.', 'social' => 'Practica natación.', 'escolar' => 'Grupo de 36 estudiantes.'],
            'valoracion_pedagogica' => ['cognitiva' => 'Lee oraciones cortas.', 'comunicativa' => 'Frases completas.', 'socioafectiva' => 'Busca a la docente.', 'corporal' => 'Buena motricidad gruesa.', 'participacion' => 'Participa con apoyos visuales.'],
            'fortalezas' => ['Memoria visual', 'Puntualidad'],
            'intereses' => ['Dinosaurios', 'Mapas'],
            'barreras' => [['tipo' => 'Comunicativa', 'descripcion' => 'Instrucciones solo orales.']],
            'objetivos' => [['area' => 'Matemáticas', 'objetivo' => 'Resolver problemas aditivos.', 'meta' => 'Resuelve 3 de 4 problemas.', 'indicador' => 'Usa material concreto.']],
            'ajustes' => [['area' => 'Transversal', 'categoria' => 'comunicacion', 'ajuste' => 'Instrucciones visuales (a validar por el equipo)', 'estrategias' => ['Agenda visual', 'Anticipar cambios'], 'responsable' => 'Docente de aula', 'frecuencia' => 'Diaria']],
            'evaluacion' => [['aspecto' => 'Tiempo', 'ajuste' => 'Tiempo adicional.']],
            'recursos' => ['humanos' => ['Orientadora'], 'fisicos' => ['Rincón tranquilo'], 'tecnologicos' => ['Tableta'], 'materiales' => ['Pictogramas']],
            'proyectos' => ['Proyecto de aula sobre dinosaurios'],
            'compromisos' => ['docentes' => ['Usar agenda visual'], 'familia' => ['Leer 15 minutos diarios'], 'directivos' => ['Gestionar apoyo'], 'estudiante' => ['Pedir ayuda']],
            'aula_inclusiva' => ['Trabajo en parejas'],
            'seguimiento' => ['periodicidad' => 'Cada periodo', 'indicadores' => ['Participación'], 'momentos' => ['Cierre de periodo']],
            'observaciones' => 'Validar con la familia.',
        ];
    }

    private static function input(): array
    {
        return [
            'estudiante' => ['nombre' => 'S. M. R.', 'edad' => '9', 'grado' => '3', 'sede' => 'Principal', 'jornada' => 'Mañana'],
            'institucion' => 'IE de prueba', 'docente' => 'Docente', 'anio' => '2026', 'periodo' => 'anual',
            'condiciones' => ['tea', 'no-existe'], 'soporte_clinico' => '1', 'nivel_apoyo' => 'limitado',
            'areas' => ['lenguaje', 'matematicas'], 'prioridades' => ['comunicacion'],
            'contexto_familiar' => 'Vive con su madre.', 'barreras' => 'Instrucciones solo orales.',
            'valoracion' => ['cognitiva' => 'Lee oraciones cortas.'],
            'autorizacion' => '1',
        ];
    }

    private function request(string $method, string $uri, array $post = []): Response
    {
        if ($method === 'POST') {
            $post['_csrf'] = $this->csrf;
        }
        return App::handle(Request::create($method, $uri, $post, ['REMOTE_ADDR' => $this->ip], [Csrf::COOKIE => $this->csrf]));
    }

    /** Crea la cuenta, acepta términos y deja la sesión iniciada. */
    private function login(string $name = 'Docente'): int
    {
        $id = PiarCredits::customerFor(strtolower($name) . '-' . bin2hex(random_bytes(3)) . self::DOMAIN, $name);
        PiarProfile::acceptTerms($id);
        Session::set('customer_id', $id);
        return $id;
    }

    private function generate(): Response
    {
        return $this->request('POST', '/piar/nuevo/', self::input());
    }

    private function uuidFrom(Response $response): string
    {
        $this->assertSame(303, $response->status);
        $this->assertMatchesRegularExpression('#^/piar/([a-f0-9]{32})/$#', $response->headers['Location'] ?? '');
        preg_match('#^/piar/([a-f0-9]{32})/$#', $response->headers['Location'], $m);
        return $m[1];
    }

    // ------------------------------------------------------------------ pruebas

    public function testMagicLinkCreatesAccountRecordsTermsAndLogsIn(): void
    {
        $email = 'nueva-' . bin2hex(random_bytes(3)) . self::DOMAIN;

        // Sin aceptar términos no se crea nada.
        $this->request('POST', '/piar/acceso/', ['name' => 'Ana', 'email' => $email]);
        $this->assertNull(DB::value('SELECT id FROM customers WHERE email = :e', ['e' => $email]));
        $this->assertSame([], Mailer::$sent);

        $response = $this->request('POST', '/piar/acceso/', ['name' => 'Ana Pérez', 'email' => strtoupper($email), 'terms' => '1']);
        $this->assertSame(303, $response->status);
        $customer = DB::one('SELECT * FROM customers WHERE email = :e', ['e' => $email]);
        $this->assertNotNull($customer, 'El acceso del PIAR crea la cuenta');
        $this->assertSame('Ana Pérez', $customer['name']);
        $this->assertNotNull(PiarProfile::get((int) $customer['id'])['terms_accepted_at']);

        $mail = end(Mailer::$sent);
        $this->assertSame($email, $mail['to']);
        $this->assertMatchesRegularExpression('#/piar/acceso/([a-f0-9]{64})/#', $mail['html']);
        preg_match('#/piar/acceso/([a-f0-9]{64})/#', $mail['html'], $m);

        $login = $this->request('GET', "/piar/acceso/{$m[1]}/");
        $this->assertSame(303, $login->status);
        $this->assertSame('/piar/', $login->headers['Location']);
        $this->assertSame((int) $customer['id'], Session::get('customer_id'));
        $page = $this->request('GET', '/piar/');
        $this->assertSame(200, $page->status);
        $this->assertStringContainsString('Ana', $page->body);
        $this->assertStringContainsString('noindex', $page->body);
        $this->assertSame('private, no-store', $page->headers['Cache-Control']);

        // Un solo uso.
        Session::forget('customer_id');
        $this->request('GET', "/piar/acceso/{$m[1]}/");
        $this->assertNull(Session::get('customer_id'));
    }

    public function testTrialIsLimitedToTwoAndItsContentIsEphemeral(): void
    {
        $id = $this->login();
        $first = $this->uuidFrom($this->generate());
        $this->assertSame(1, $this->geminiCalls);

        $view = $this->request('GET', "/piar/$first/");
        $this->assertSame(200, $view->status);
        $this->assertStringContainsString('RESUMEN-DE-PRUEBA', $view->body);
        $this->assertStringContainsString('Versión de prueba', $view->body);
        $this->assertStringNotContainsString("/piar/$first/pdf/", $view->body);

        // Sin PDF ni edición en la prueba.
        $pdf = $this->request('GET', "/piar/$first/pdf/");
        $this->assertContains($pdf->status, [303, 403]);
        $this->assertNotSame('application/pdf', $pdf->headers['Content-Type'] ?? null);
        $this->assertSame(303, $this->request('GET', "/piar/$first/editar/")->status);

        $second = $this->uuidFrom($this->generate());
        $third = $this->generate();
        $this->assertSame(303, $third->status);
        $this->assertSame('/piar/planes/', $third->headers['Location']);
        $this->assertSame(2, (int) DB::value('SELECT COUNT(*) FROM piar_plans WHERE customer_id = :c', ['c' => $id]));
        $this->assertSame(2, $this->geminiCalls);

        // Las pruebas no aparecen en el historial.
        $this->assertSame([], PiarPlans::history($id));

        // Otra sesión de la misma cuenta no la ve.
        Session::forget('piar_trials');
        $this->assertSame(410, $this->request('GET', "/piar/$second/")->status);
        $this->assertSame(404, $this->request('GET', "/piar/$second/estado/")->status);

        // Purga a las 2 horas: el contenido se borra, el contador no se reinicia.
        DB::run('UPDATE piar_plans SET purge_after = :p WHERE customer_id = :c', ['p' => gmdate('Y-m-d H:i:s', time() - 60), 'c' => $id]);
        $this->assertGreaterThanOrEqual(2, PiarPlans::purgeTrials());
        $rows = DB::all('SELECT output_json, input_json, student_alias, purged_at FROM piar_plans WHERE customer_id = :c', ['c' => $id]);
        foreach ($rows as $row) {
            $this->assertNull($row['output_json']);
            $this->assertNull($row['input_json']);
            $this->assertNull($row['student_alias']);
            $this->assertNotNull($row['purged_at']);
        }
        $this->assertSame(2, PiarCredits::trialUsed($id));
        Session::set('piar_trials', [$first]);
        $this->assertSame(410, $this->request('GET', "/piar/$first/")->status);
    }

    public function testTrialIsThrottledPerIp(): void
    {
        $other = $this->login('Otro');
        $hash = hash('sha256', 'piar|' . $this->ip);
        for ($i = 0; $i < 8; $i++) {
            DB::insert('piar_plans', ['uuid' => bin2hex(random_bytes(16)), 'customer_id' => $other, 'is_trial' => 1, 'status' => 'done', 'ip_hash' => $hash]);
        }
        $this->login('Nuevo');
        $response = $this->generate();
        $this->assertSame('/piar/nuevo/', $response->headers['Location']);
        $this->assertSame(0, $this->geminiCalls);
    }

    public function testApprovedOrderGrantsCreditsOnceAndGenerationConsumesThem(): void
    {
        $email = 'compra-' . bin2hex(random_bytes(3)) . self::DOMAIN;
        $productId = (int) DB::value('SELECT id FROM products WHERE sku = "PIAR-5"');
        $order = OrderService::create('es', [$productId], ['name' => 'Luz Docente', 'email' => $email], 'wompi', $this->ip);
        $status = new Status(Status::APPROVED, 'tx-piar-' . bin2hex(random_bytes(3)), (float) $order['total'], 'COP', $order['reference'], 'APPROVED');
        OrderService::apply('wompi', $status);
        OrderService::apply('wompi', $status);
        PiarCredits::grantForOrder((int) $order['id']);

        $packages = PiarCredits::forOrder((int) $order['id']);
        $this->assertCount(1, $packages, 'Un solo paquete por ítem aunque el pago se aplique varias veces');
        $this->assertSame(5, (int) $packages[0]['credits']);
        $days = (strtotime($packages[0]['expires_at']) - strtotime($packages[0]['starts_at'])) / 86400;
        $this->assertEqualsWithDelta(30, $days, 0.01);
        $credits = array_values(array_filter(Mailer::$sent, fn ($m) => str_contains($m['subject'], 'paquete de 5 PIAR')));
        $this->assertCount(1, $credits);
        $approved = array_values(array_filter(Mailer::$sent, fn ($m) => str_starts_with($m['subject'], 'Pago aprobado')));
        $this->assertStringContainsString('/piar/', $approved[0]['html']);
        $this->assertStringNotContainsString('coordinar el acceso', $approved[0]['html']);

        // Generar con el paquete: se guarda y consume un crédito.
        $customerId = (int) DB::value('SELECT id FROM customers WHERE email = :e', ['e' => $email]);
        PiarProfile::acceptTerms($customerId);
        Session::set('customer_id', $customerId);
        $uuid = $this->uuidFrom($this->generate());
        $plan = PiarPlans::find($uuid, $customerId);
        $this->assertSame(0, (int) $plan['is_trial']);
        $this->assertSame('done', $plan['status']);
        $this->assertSame(1, (int) DB::value('SELECT used FROM piar_packages WHERE id = :id', ['id' => (int) $packages[0]['id']]));
        $this->assertCount(1, PiarPlans::history($customerId));
        // El catálogo filtra claves desconocidas.
        $this->assertSame(['tea'], PiarPlans::input($plan)['condiciones']);

        $view = $this->request('GET', "/piar/$uuid/");
        $this->assertStringNotContainsString('Versión de prueba', $view->body);
        $this->assertStringContainsString("/piar/$uuid/pdf/", $view->body);

        $pdf = $this->request('GET', "/piar/$uuid/pdf/");
        $this->assertSame(200, $pdf->status);
        $this->assertSame('application/pdf', $pdf->headers['Content-Type']);
        $this->assertStringStartsWith('%PDF', $pdf->body);
        $this->assertStringContainsString('PIAR-S-M-R-', $pdf->headers['Content-Disposition']);

        // Edición: listas una por línea, elementos vacíos se descartan.
        $edit = $this->request('POST', "/piar/$uuid/editar/", [
            'resumen' => 'Resumen editado',
            'fortalezas' => "Primera\n- Segunda\n\n",
            'objetivos' => [['area' => 'Lenguaje', 'objetivo' => 'Leer', 'meta' => 'Lee', 'indicador' => 'Lee en voz alta'], ['area' => '', 'objetivo' => '', 'meta' => '', 'indicador' => '']],
        ]);
        $this->assertSame(303, $edit->status);
        $output = PiarPlans::output(PiarPlans::find($uuid, $customerId));
        $this->assertSame('Resumen editado', $output['resumen']);
        $this->assertSame(['Primera', 'Segunda'], $output['fortalezas']);
        $this->assertCount(1, $output['objetivos']);

        // Si la IA falla, el crédito no se consume.
        $this->geminiStatus = 503;
        $failed = $this->uuidFrom($this->generate());
        $this->assertSame('error', PiarPlans::find($failed, $customerId)['status']);
        $this->assertSame(1, (int) DB::value('SELECT used FROM piar_packages WHERE id = :id', ['id' => (int) $packages[0]['id']]));
        $this->assertStringContainsString('No pudimos generar', $this->request('GET', "/piar/$failed/")->body);

        // No hay forma de borrar un PIAR.
        $this->assertSame(405, $this->request('POST', "/piar/$uuid/")->status);

        // Reembolso: los créditos sin usar se anulan; los PIAR generados se conservan.
        OrderService::apply('wompi', new Status(Status::REFUNDED, $status->gatewayId, null, null, $order['reference'], 'REFUNDED'));
        $this->assertSame([], PiarCredits::active($customerId));
        $this->assertSame(200, $this->request('GET', "/piar/$uuid/")->status);
    }

    public function testGenerationIsRefusedWithoutCredits(): void
    {
        $id = $this->login();
        $package = PiarCredits::grantManual($id, 1, 30);
        DB::run('UPDATE piar_packages SET used = 1 WHERE id = :id', ['id' => $package]);
        $response = $this->generate();
        $this->assertSame(303, $response->status);
        $this->assertSame('/piar/planes/', $response->headers['Location']);
        $this->assertSame(0, (int) DB::value('SELECT COUNT(*) FROM piar_plans WHERE customer_id = :c', ['c' => $id]));
        $this->assertSame(0, $this->geminiCalls);

        // El asistente muestra el estado bloqueado con el enlace a los planes.
        $page = $this->request('GET', '/piar/nuevo/');
        $this->assertStringContainsString('/piar/planes/', $page->body);
        $this->assertStringNotContainsString('data-piar-form', $page->body);

        // Sin consentimiento de la familia no se genera.
        PiarCredits::grantManual($id, 2, 30);
        $input = self::input();
        unset($input['autorizacion']);
        $this->request('POST', '/piar/nuevo/', $input);
        $this->assertSame(0, $this->geminiCalls);
    }

    public function testOthersPlansReturn404(): void
    {
        $owner = $this->login('Dueña');
        PiarCredits::grantManual($owner, 3, 30);
        $uuid = $this->uuidFrom($this->generate());

        $this->login('Intrusa');
        Session::set('piar_trials', [$uuid]);
        foreach (["/piar/$uuid/", "/piar/$uuid/pdf/", "/piar/$uuid/editar/"] as $path) {
            $this->assertSame(404, $this->request('GET', $path)->status, $path);
        }
        $this->assertSame(404, $this->request('GET', "/piar/$uuid/estado/")->status);
        $this->assertSame(404, $this->request('POST', "/piar/$uuid/editar/", ['resumen' => 'x'])->status);
        $this->assertSame(404, $this->request('GET', '/piar/' . str_repeat('a', 32) . '/')->status);

        // Sin sesión, al acceso.
        Session::forget('customer_id');
        $this->assertSame('/piar/', $this->request('GET', "/piar/$uuid/")->headers['Location'] ?? null);
    }

    public function testStatusEndpointAndStalePendingReleasesCredit(): void
    {
        $id = $this->login();
        $package = PiarCredits::grantManual($id, 2, 30);
        DB::run('UPDATE piar_packages SET used = 1 WHERE id = :id', ['id' => $package]);
        $uuid = bin2hex(random_bytes(16));
        DB::insert('piar_plans', [
            'uuid' => $uuid, 'customer_id' => $id, 'package_id' => $package, 'is_trial' => 0, 'status' => 'pending',
            'input_json' => '{}', 'created_at' => gmdate('Y-m-d H:i:s', time() - 600),
        ]);
        $res = $this->request('GET', "/piar/$uuid/estado/");
        $this->assertSame(200, $res->status);
        $data = json_decode($res->body, true);
        $this->assertSame('error', $data['status']);
        $this->assertSame("/piar/$uuid/", $data['url']);
        $this->assertSame(0, (int) DB::value('SELECT used FROM piar_packages WHERE id = :id', ['id' => $package]));
        // La transición es única: no devuelve el crédito dos veces.
        PiarPlans::expireStale();
        $this->assertSame(0, (int) DB::value('SELECT used FROM piar_packages WHERE id = :id', ['id' => $package]));
    }

    public function testAdminGrantsManualPackage(): void
    {
        $adminId = DB::value('SELECT id FROM admin_users ORDER BY id LIMIT 1');
        if ($adminId === null) {
            $this->markTestSkipped('Sin usuario del panel');
        }
        Session::set('admin_id', (int) $adminId);
        $email = 'soporte-' . bin2hex(random_bytes(3)) . self::DOMAIN;
        $res = $this->request('POST', '/admin/piar/', ['email' => $email, 'name' => 'Soporte', 'credits' => '7', 'days' => '15']);
        $this->assertSame(303, $res->status);
        $customerId = (int) DB::value('SELECT id FROM customers WHERE email = :e', ['e' => $email]);
        $summary = PiarCredits::summary($customerId);
        $this->assertSame(7, $summary['remaining']);
        $page = $this->request('GET', '/admin/piar/?q=' . rawurlencode($email));
        $this->assertSame(200, $page->status);
        $this->assertStringContainsString($email, $page->body);
        Session::forget('admin_id');
    }

    public function testLandingAndPlansPages(): void
    {
        $landing = $this->request('GET', '/herramientas/piar/');
        $this->assertSame(200, $landing->status);
        $this->assertStringContainsString('"@type":"SoftwareApplication"', $landing->body);
        $this->assertStringContainsString('index, follow', $landing->body);
        $this->assertStringContainsString('/assets/css/piar.css', $landing->body);

        $tools = $this->request('GET', '/herramientas/');
        $this->assertStringContainsString('/herramientas/piar/', $tools->body);
        $this->assertStringContainsString('Con IA', $tools->body);

        $plans = $this->request('GET', '/piar/planes/');
        $this->assertSame(200, $plans->status);
        $productId = (int) DB::value('SELECT id FROM products WHERE sku = "PIAR-10"');
        $this->assertStringContainsString('/finalizar-compra/?items=' . $productId, $plans->body);
        $this->assertStringContainsString('noindex', $plans->body);
    }
}
