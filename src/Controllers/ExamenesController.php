<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\DB;
use App\Core\Mailer;
use App\Core\RateLimiter;
use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Services\AdminAccess;
use App\Services\Ai\Gemini;
use App\Services\Examenes\ExamCatalog;
use App\Services\Examenes\ExamContent;
use App\Services\Examenes\ExamCredits;
use App\Services\Examenes\ExamDemo;
use App\Services\Examenes\ExamPdf;
use App\Services\Examenes\ExamProfile;
use App\Services\Examenes\Exams;
use App\Services\Examenes\ExamView;
use App\Services\Examenes\Tex;
use App\Services\I18n\I18n;
use App\Services\Mail\MailTemplates;
use App\Services\Seo\Meta;

/**
 * Generador de exámenes con IA (/examenes/): acceso por enlace mágico (misma cuenta que la tienda y PIAR),
 * asistente, generación asíncrona, vista previa por versión, editor (manual y con IA), PDF y simulador sin IA.
 * Solo en español. La presentación vive en /herramientas/generador-de-examenes/ (landing()).
 */
final class ExamenesController extends Controller
{
    private ?array $customer = null;
    private ?array $profile = null;

    // ------------------------------------------------------------------ utilidades

    private function customer(Request $request): ?array
    {
        Session::start($request);
        $id = Session::get('customer_id');
        $this->customer = is_int($id) ? DB::one('SELECT id, email, name FROM customers WHERE id = :id', ['id' => $id]) : null;
        $this->profile = $this->customer ? ExamProfile::get((int) $this->customer['id']) : null;
        return $this->customer;
    }

    private function member(Request $request): ?int
    {
        $customer = $this->customer($request);
        if ($customer === null || empty($this->profile['terms_accepted_at'])) {
            return null;
        }
        return (int) $customer['id'];
    }

    private function view(string $template, array $data, string $title, int $status = 200): Response
    {
        $response = $this->page('pages/examenes/' . $template, $data + [
            'customer' => $this->customer,
            'profile' => $this->profile,
            'notice' => Session::flash('examenes'),
            'error' => Session::flash('examenes_error'),
        ], [
            'title' => $title,
            'noindex' => true,
            'body_class' => 'page-examenes page-examenes--' . $template,
            'styles' => ['css/examenes.css'],
            'scripts' => ['js/examenes.js'],
        ]);
        $response->status = $status;
        return $response->header('Cache-Control', 'private, no-store')->header('X-Robots-Tag', 'noindex');
    }

    private function home(?string $error = null, ?string $notice = null, ?string $to = null): Response
    {
        if ($error !== null) {
            Session::flash('examenes_error', $error);
        }
        if ($notice !== null) {
            Session::flash('examenes', $notice);
        }
        return $this->redirect($to ?? route('examenes'));
    }

    private function exam(string $uuid, int $customerId): array
    {
        $exam = Exams::find($uuid, $customerId);
        if ($exam === null) {
            $this->notFound();
        }
        if ($exam['status'] === 'pending' && strtotime($exam['created_at'] . ' UTC') < time() - Exams::STALE_SECONDS) {
            Exams::fail($exam, 'Tiempo de espera agotado.');
            $exam = Exams::find($uuid, $customerId) ?? $exam;
        }
        return $exam;
    }

    private static function json(array $data, int $status = 200): Response
    {
        return Response::json($data, $status)->header('Cache-Control', 'private, no-store');
    }

    /** Opciones de los formularios (asistente, simulador y editor). */
    private static function catalogs(): array
    {
        return [
            'subjects' => ExamCatalog::subjects(),
            'grades' => ExamCatalog::grades(),
            'difficulties' => ExamCatalog::difficulties(),
            'styles' => ExamCatalog::styles(),
            'scopes' => ExamCatalog::scopes(),
            'purposes' => ExamCatalog::purposes(),
            'types' => ExamCatalog::types(),
            'typeHints' => ExamCatalog::typeHints(),
            'papers' => ExamCatalog::papers(),
        ];
    }

    // ------------------------------------------------------------------ presentación

    public function landing(string $slug): Response
    {
        $path = route('tool', ['slug' => $slug]);
        $crumbs = [[t('nav.home'), route('home')], [t('nav.tools'), route('tools')], [t('tool.examenes.name'), $path]];
        $faqs = [];
        for ($i = 1; I18n::has("examenes.faq{$i}_q"); $i++) {
            $faqs[] = ['q' => t("examenes.faq{$i}_q"), 'a' => t("examenes.faq{$i}_a")];
        }
        $offers = ExamCredits::offers();
        Tex::prepare([t('examenes.latex.sample'), t('examenes.latex.sample2'), t('examenes.mock.q1'), t('examenes.mock.q2')]);
        return $this->page('pages/examenes/landing', [
            'crumbs' => $crumbs,
            'faqs' => $faqs,
            'offers' => $offers,
            'types' => ExamCatalog::types(),
        ], [
            'title' => t('examenes.seo_title'),
            'title_full' => true,
            'description' => t('examenes.seo_description'),
            'breadcrumbs' => $crumbs,
            'styles' => ['css/examenes.css'],
            'body_class' => 'page-examenes page-examenes--landing',
            'jsonld' => [[
                '@context' => 'https://schema.org',
                '@type' => 'SoftwareApplication',
                'name' => t('examenes.brand'),
                'url' => url($path),
                'applicationCategory' => 'EducationalApplication',
                'operatingSystem' => 'Any',
                'inLanguage' => 'es-CO',
                'description' => t('examenes.seo_description'),
                'creator' => Meta::person(),
                'featureList' => array_values(ExamCatalog::types()),
                'offers' => array_map(fn (array $o) => [
                    '@type' => 'Offer',
                    'name' => t('examenes.price.plan_' . strtolower(str_replace('-', '_', $o['sku']))),
                    'price' => (string) $o['price_cop'],
                    'priceCurrency' => 'COP',
                    'url' => url(route('examenes.plans')),
                    'description' => t('examenes.price.offer_desc', ['exams' => $o['exams'], 'versions' => $o['versions'], 'questions' => $o['questions']]),
                ], $offers),
            ], Meta::faqPage($faqs)],
        ]);
    }

    // ------------------------------------------------------------------ acceso

    /** Administrador con sesión en el panel (para entrar sin enlace mágico). */
    private static function admin(): ?array
    {
        return AdminAccess::sessionAdmin();
    }

    public function dashboard(Request $request): Response
    {
        $customer = $this->customer($request);
        if ($customer === null) {
            $old = Session::get('examenes_old');
            Session::forget('examenes_old');
            return $this->view('access', ['old' => is_array($old) ? $old : [], 'admin' => self::admin()], t('examenes.access.title'));
        }
        $id = (int) $customer['id'];
        if (empty($this->profile['terms_accepted_at'])) {
            return $this->view('terms', [], t('examenes.terms.title'));
        }
        Exams::housekeeping();
        return $this->view('dashboard', [
            'summary' => ExamCredits::summary($id),
            'history' => Exams::history($id),
            'pending' => Exams::pending($id),
            'subjects' => ExamCatalog::subjects(),
            'grades' => ExamCatalog::grades(),
        ], t('examenes.dash.title'));
    }

    public function adminLogin(Request $request): Response
    {
        $this->requireCsrf($request);
        Session::start($request);
        $admin = self::admin();
        if ($admin === null) {
            return $this->redirect(route('examenes'));
        }
        ExamProfile::acceptTerms(AdminAccess::enterAsCustomer($admin));
        return $this->redirect(route('examenes'));
    }

    public function requestLink(Request $request): Response
    {
        $this->requireCsrf($request);
        Session::start($request);
        $email = strtolower($request->str('email'));
        $name = mb_substr($request->str('name'), 0, 120);
        Session::set('examenes_old', ['email' => mb_substr($email, 0, 190), 'name' => $name]);
        if (!RateLimiter::hit('examenes-link', $request->ip(), 8, 3600) || !RateLimiter::hit('examenes-link-mail', $email, 4, 900)) {
            return $this->home(t('form.rate_limited'));
        }
        if (!\App\Services\Turnstile::passes($request)) {
            return $this->home(t('form.captcha_failed'));
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 190) {
            return $this->home(t('examenes.access.bad_email'));
        }
        if (mb_strlen($name) < 2) {
            return $this->home(t('examenes.access.bad_name'));
        }
        if ($request->str('terms') !== '1') {
            return $this->home(t('examenes.access.need_terms'));
        }
        $customerId = ExamCredits::customerFor($email, $name);
        ExamProfile::acceptTerms($customerId);
        $token = bin2hex(random_bytes(32));
        DB::insert('login_tokens', [
            'customer_id' => $customerId,
            'token_hash' => hash('sha256', $token),
            'expires_at' => gmdate('Y-m-d H:i:s', time() + 900),
        ]);
        $mail = MailTemplates::render('examenes-login', 'es', ['loginUrl' => url(route('examenes.login', ['token' => $token])), 'name' => $name]);
        Mailer::send($email, $mail['subject'], $mail['html'], $mail['text']);
        Session::forget('examenes_old');
        Session::set('examenes_sent', $email);
        return $this->home(null, t('examenes.access.sent', ['email' => $email]));
    }

    public function login(Request $request, string $token): Response
    {
        Session::start($request);
        $row = DB::one(
            'SELECT * FROM login_tokens WHERE token_hash = :h AND used_at IS NULL AND expires_at > :now',
            ['h' => hash('sha256', $token), 'now' => DB::now()]
        );
        if ($row === null) {
            return $this->home(t('examenes.access.link_invalid'));
        }
        DB::run('UPDATE login_tokens SET used_at = :now WHERE id = :id', ['now' => DB::now(), 'id' => (int) $row['id']]);
        Session::regenerate();
        Session::set('customer_id', (int) $row['customer_id']);
        Session::forget('examenes_sent');
        return $this->redirect(route('examenes'));
    }

    public function logout(Request $request): Response
    {
        $this->requireCsrf($request);
        Session::start($request);
        Session::forget('customer_id');
        Session::regenerate();
        return $this->redirect(route('examenes'));
    }

    public function acceptTerms(Request $request): Response
    {
        $this->requireCsrf($request);
        $customer = $this->customer($request);
        if ($customer === null) {
            return $this->redirect(route('examenes'));
        }
        if ($request->str('terms') !== '1') {
            return $this->home(t('examenes.access.need_terms'));
        }
        ExamProfile::acceptTerms((int) $customer['id']);
        return $this->redirect(route('examenes'));
    }

    // ------------------------------------------------------------------ asistente y generación

    public function create(Request $request): Response
    {
        $id = $this->member($request);
        if ($id === null) {
            return $this->redirect(route('examenes'));
        }
        $summary = ExamCredits::summary($id);
        // «Duplicar» o «volver a intentar»: parte de otro examen de la cuenta.
        $from = is_string($request->query['desde'] ?? null) ? Exams::find((string) $request->query['desde'], $id) : null;
        $input = $from ? Exams::input($from) : [];
        $header = $from ? (json_decode((string) $from['header_json'], true) ?: []) : [];
        $header += [
            'institucion' => (string) ($this->profile['institution'] ?? ''),
            'docente' => (string) (($this->profile['teacher'] ?? '') ?: ($this->customer['name'] ?? '')),
            'logo' => !empty($this->profile['logo_key']),
            'hoja' => true,
            'puntaje' => true,
        ];
        return $this->view('wizard', self::catalogs() + [
            'summary' => $summary,
            'canCreate' => $summary['remaining'] > 0,
            'input' => $input,
            'header' => $header + Exams::sanitizeHeader([]),
            'aiReady' => Gemini::configured(),
            'examples' => self::examples(),
            'hasLogo' => !empty($this->profile['logo_key']),
        ], t('examenes.new.title'));
    }

    /** Ejemplos de tema y contexto por materia (marcadores de posición del asistente). */
    private static function examples(): array
    {
        $out = [];
        foreach (array_keys(ExamCatalog::SUBJECTS) as $k) {
            $out[$k] = [t("examenes.example.$k.topic"), t("examenes.example.$k.context")];
        }
        return $out;
    }

    public function store(Request $request): Response
    {
        $this->requireCsrf($request);
        $id = $this->member($request);
        if ($id === null) {
            return $this->redirect(route('examenes'));
        }
        $back = route('examenes.new');
        $fail = function (string $message, ?string $to = null) use ($back): Response {
            Session::flash('examenes_error', $message);
            return $this->redirect($to ?? $back);
        };
        if (!RateLimiter::hit('examenes-gen', $request->ip(), 20, 3600) || !RateLimiter::hit('examenes-gen-c', 'c' . $id, 12, 3600)) {
            return $fail(t('form.rate_limited'));
        }
        $input = Exams::sanitizeInput($request->post);
        $header = Exams::sanitizeHeader($request->post);
        $summary = ExamCredits::summary($id);
        if ($summary['remaining'] === 0) {
            return $fail(t($summary['has_active'] ? 'examenes.error.no_credits' : 'examenes.error.no_plan'), route('examenes.plans'));
        }
        $invalid = Exams::validate($input, $summary);
        if ($invalid !== null) {
            return $fail(t('examenes.error.' . $invalid, ['versions' => $summary['max_versions'], 'questions' => $summary['max_questions']]));
        }
        if (!Gemini::configured()) {
            return $fail(t('examenes.error.unavailable'));
        }
        if ($header['logo'] && empty($this->profile['logo_key'])) {
            $header['logo'] = false;
        }
        $result = Exams::create($id, $input, $header);
        if ($result['error'] !== null) {
            return $fail(t('examenes.error.' . $result['error'], ['versions' => $summary['max_versions'], 'questions' => $summary['max_questions']]), $result['error'] === 'limits' ? null : route('examenes.plans'));
        }
        self::dispatch((int) $result['exam']['id']);
        return $this->redirect(route('examenes.show', ['uuid' => $result['exam']['uuid']]));
    }

    /** Igual que PIAR: con PHP-FPM la generación sigue tras enviar la respuesta; sin FPM se genera aquí mismo. */
    private static function dispatch(int $examId): void
    {
        $work = static function () use ($examId): void {
            ignore_user_abort(true);
            set_time_limit(900);
            Exams::generate($examId);
        };
        if (PHP_SAPI !== 'cli' && function_exists('fastcgi_finish_request')) {
            register_shutdown_function(static function () use ($work): void {
                if (session_status() === PHP_SESSION_ACTIVE) {
                    session_write_close();
                }
                fastcgi_finish_request();
                $work();
            });
            return;
        }
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_write_close();
        }
        $work();
    }

    public function show(Request $request, string $uuid): Response
    {
        $id = $this->member($request);
        if ($id === null) {
            return $this->redirect(route('examenes'));
        }
        Exams::housekeeping();
        $exam = $this->exam($uuid, $id);
        if ($exam['status'] !== 'done') {
            return $this->view('progress', ['exam' => $exam, 'summary' => ExamCredits::summary($id)], t($exam['status'] === 'error' ? 'examenes.progress.failed_title' : 'examenes.progress.title'));
        }
        return $this->view('exam', $this->previewData($exam, Exams::input($exam), Exams::versions($exam), Exams::headerOf($exam), (string) ($request->query['v'] ?? 'A')) + [
            'summary' => ExamCredits::summary($id),
            'quota' => Exams::aiQuota($exam),
        ], $exam['title'] ?: t('examenes.exam.title'));
    }

    /** Datos de la vista previa: versión elegida (A, B…) o el solucionario («key»). */
    private function previewData(array $exam, array $input, array $versions, array $header, string $tab): array
    {
        $labels = array_column($versions, 'label');
        $tab = $tab === 'key' ? 'key' : (in_array($tab, $labels, true) ? $tab : $labels[0]);
        $current = null;
        foreach ($versions as $v) {
            if ($v['label'] === ($tab === 'key' ? $labels[0] : $tab)) {
                $current = $v;
            }
        }
        $show = $tab === 'key' ? $versions : [$current];
        Tex::prepare(array_merge(ExamContent::texts($show), [$header['instrucciones']]));
        $keys = [];
        foreach ($versions as $v) {
            $keys[$v['label']] = ExamContent::answerKey($v);
        }
        return [
            'exam' => $exam,
            'input' => $input,
            'header' => $header,
            'versions' => $versions,
            'version' => $current,
            'tab' => $tab,
            'keys' => $keys,
            'types' => ExamCatalog::types(),
            'texAvailable' => Tex::available(),
        ];
    }

    public function status(Request $request, string $uuid): Response
    {
        $id = $this->member($request);
        $exam = $id !== null ? Exams::find($uuid, $id) : null;
        if ($exam === null) {
            return self::json(['status' => 'missing'], 404);
        }
        $exam = $this->exam($uuid, (int) $id);
        return self::json([
            'status' => $exam['status'],
            'progress' => (int) $exam['progress'],
            'url' => route('examenes.show', ['uuid' => $exam['uuid']]),
        ]);
    }

    // ------------------------------------------------------------------ editor

    private function doneExam(Request $request, string $uuid): array|Response
    {
        $id = $this->member($request);
        if ($id === null) {
            return $this->redirect(route('examenes'));
        }
        $exam = $this->exam($uuid, $id);
        if ($exam['status'] !== 'done') {
            return $this->redirect(route('examenes.show', ['uuid' => $exam['uuid']]));
        }
        return $exam;
    }

    public function edit(Request $request, string $uuid): Response
    {
        $exam = $this->doneExam($request, $uuid);
        if ($exam instanceof Response) {
            return $exam;
        }
        $content = Exams::content($exam);
        $slots = ExamContent::sorted($content['slots']);
        $texts = [];
        foreach ($slots as $slot) {
            foreach ($slot['variants'] as $variant) {
                $texts[] = (string) ($variant['stem'] ?? '');
            }
        }
        Tex::prepare($texts);
        return $this->view('edit', self::catalogs() + [
            'exam' => $exam,
            'input' => Exams::input($exam),
            'header' => Exams::headerOf($exam),
            'slots' => $slots,
            'quota' => Exams::aiQuota($exam),
            'hasLogo' => !empty($this->profile['logo_key']),
            'aiReady' => Gemini::configured(),
        ], t('examenes.edit.title'));
    }

    public function update(Request $request, string $uuid): Response
    {
        $this->requireCsrf($request);
        $exam = $this->doneExam($request, $uuid);
        if ($exam instanceof Response) {
            return $exam;
        }
        $result = Exams::saveEdit($exam, $request->post);
        $anchor = is_string($request->post['anchor'] ?? null) && preg_match('/^[a-z0-9-]{1,40}$/', $request->post['anchor']) ? '#' . $request->post['anchor'] : '';
        if ($result['errors'] > 0) {
            Session::flash('examenes_error', t('examenes.edit.invalid'));
        } else {
            Session::flash('examenes', t('examenes.edit.saved'));
        }
        return $this->redirect(route('examenes.edit', ['uuid' => $exam['uuid']]) . $anchor);
    }

    /** Preguntas adicionales o reemplazo con IA (JSON). Cuenta contra el cupo del examen. */
    public function ai(Request $request, string $uuid): Response
    {
        $this->requireCsrf($request);
        $id = $this->member($request);
        $exam = $id !== null ? Exams::find($uuid, $id) : null;
        if ($exam === null || $exam['status'] !== 'done') {
            return self::json(['ok' => false, 'error' => t('examenes.ai.forbidden')], 403);
        }
        if (!RateLimiter::hit('examenes-ai', $request->ip(), 30, 3600) || !RateLimiter::hit('examenes-ai-c', 'c' . $id, 20, 3600)) {
            return self::json(['ok' => false, 'error' => t('form.rate_limited')], 429);
        }
        @set_time_limit(240);
        $req = Exams::sanitizeAiRequest($request->post, Exams::input($exam));
        $slot = is_string($request->post['slot'] ?? null) && preg_match('/^[a-z0-9]{2,20}$/', $request->post['slot']) ? $request->post['slot'] : null;
        $result = Exams::aiEdit($exam, $req, $slot);
        if ($result['error'] !== null) {
            $code = in_array($result['error'], ['quota', 'requests', 'unique', 'type_max'], true) ? 429 : ($result['error'] === 'ai' ? 502 : 422);
            return self::json(['ok' => false, 'error' => t('examenes.ai.error_' . $result['error'], ['max' => ExamCatalog::TYPES[$req['type']]['max']])], $code);
        }
        $fresh = Exams::find($uuid, (int) $id) ?? $exam;
        Session::flash('examenes', t($slot === null ? 'examenes.ai.added' : 'examenes.ai.replaced', ['n' => $result['added']]));
        return self::json(['ok' => true, 'added' => $result['added'], 'quota' => Exams::aiQuota($fresh), 'url' => route('examenes.edit', ['uuid' => $uuid])]);
    }

    /** Vista previa de un texto con fórmulas mientras se edita (JSON). */
    public function render(Request $request): Response
    {
        $this->requireCsrf($request);
        if ($this->member($request) === null && !$this->isDemoRequest($request)) {
            return self::json(['ok' => false], 403);
        }
        if (!RateLimiter::hit('examenes-render', $request->ip(), 240, 3600)) {
            return self::json(['ok' => false], 429);
        }
        $text = Exams::free($request->post['text'] ?? '', 4000);
        return self::json(['ok' => true, 'html' => ExamView::text(ExamContent::text($text), 'screen')]);
    }

    private function isDemoRequest(Request $request): bool
    {
        return ($request->post['demo'] ?? '') === '1';
    }

    public function pdf(Request $request, string $uuid): Response
    {
        $exam = $this->doneExam($request, $uuid);
        if ($exam instanceof Response) {
            return $exam;
        }
        if (!RateLimiter::hit('examenes-pdf', 'c' . $exam['customer_id'], 60, 3600)) {
            return $this->home(t('form.rate_limited'), null, route('examenes.show', ['uuid' => $uuid]));
        }
        $header = Exams::headerOf($exam);
        $logo = !empty($header['logo']) ? ExamProfile::logoData($this->profile) : null;
        $out = ExamPdf::render([
            'exam' => $exam,
            'header' => $header,
            'input' => Exams::input($exam),
            'versions' => Exams::versions($exam),
            'logo' => $logo !== null ? 'data:image/png;base64,' . base64_encode($logo) : null,
        ]);
        return new Response($out['pdf'], 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . Exams::fileName($exam) . '"',
            'Cache-Control' => 'private, no-store',
            'X-Robots-Tag' => 'noindex',
        ]);
    }

    public function destroy(Request $request, string $uuid): Response
    {
        $this->requireCsrf($request);
        $id = $this->member($request);
        if ($id === null) {
            return $this->redirect(route('examenes'));
        }
        $exam = $this->exam($uuid, $id);
        if ($exam['status'] === 'pending') {
            return $this->home(t('examenes.exam.cant_delete_pending'));
        }
        Exams::delete($exam);
        return $this->home(null, t('examenes.exam.deleted'));
    }

    // ------------------------------------------------------------------ simulador sin IA

    public function demo(Request $request): Response
    {
        Session::start($request);
        $this->customer($request);
        $posted = $request->isPost();
        if ($posted) {
            $this->requireCsrf($request);
            if (!RateLimiter::hit('examenes-demo', $request->ip(), 60, 3600)) {
                Session::flash('examenes_error', t('form.rate_limited'));
                return $this->redirect(route('examenes.demo'));
            }
        }
        $input = $posted ? Exams::sanitizeInput($request->post) : ExamDemo::defaults();
        $header = $posted ? Exams::sanitizeHeader($request->post) : ExamDemo::defaultHeader();
        $header['logo'] = false;
        $demo = ExamDemo::build($input);
        $tab = (string) ($request->post['v'] ?? $request->query['v'] ?? 'A');
        return $this->view('demo', self::catalogs() + $this->previewData($demo['exam'], $demo['input'], $demo['versions'], Exams::header($header, $demo['input']), $tab) + [
            'formInput' => $demo['input'],
            'formHeader' => $header,
            'clamped' => $demo['clamped'],
            'available' => ExamDemo::available($demo['input']['materia']),
            'examples' => self::examples(),
            'posted' => $posted,
        ], t('examenes.demo.title'));
    }

    public function demoPdf(Request $request): Response
    {
        $this->requireCsrf($request);
        Session::start($request);
        // El PDF consume CPU: límite por conexión.
        if (!RateLimiter::hit('examenes-demo-pdf', $request->ip(), 10, 3600)) {
            Session::flash('examenes_error', t('form.rate_limited'));
            return $this->redirect(route('examenes.demo'));
        }
        $demo = ExamDemo::build(Exams::sanitizeInput($request->post));
        $header = Exams::sanitizeHeader($request->post);
        $header['logo'] = false;
        $out = ExamPdf::render([
            'exam' => $demo['exam'],
            'header' => Exams::header($header, $demo['input']),
            'input' => $demo['input'],
            'versions' => $demo['versions'],
            'logo' => null,
            'demo' => true,
        ]);
        return new Response($out['pdf'], 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="Examen-DEMO-edwinortiz.pdf"',
            'Cache-Control' => 'private, no-store',
            'X-Robots-Tag' => 'noindex',
        ]);
    }

    // ------------------------------------------------------------------ planes y perfil

    public function plans(Request $request): Response
    {
        $customer = $this->customer($request);
        return $this->view('plans', [
            'offers' => ExamCredits::offers(),
            'summary' => $customer !== null ? ExamCredits::summary((int) $customer['id']) : null,
        ], t('examenes.plans.title'));
    }

    public function profile(Request $request): Response
    {
        $id = $this->member($request);
        if ($id === null) {
            return $this->redirect(route('examenes'));
        }
        return $this->view('profile', ['summary' => ExamCredits::summary($id)], t('examenes.profile.title'));
    }

    public function saveProfile(Request $request): Response
    {
        $this->requireCsrf($request);
        $id = $this->member($request);
        if ($id === null) {
            return $this->redirect(route('examenes'));
        }
        $back = route('examenes.profile');
        ExamProfile::save($id, mb_substr($request->str('institution'), 0, 190), mb_substr($request->str('teacher'), 0, 120));
        if ($request->str('remove_logo') === '1') {
            ExamProfile::removeLogo($id);
        }
        $file = $request->files['logo'] ?? null;
        if (is_array($file) && (int) ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
            if (!ExamCredits::summary($id)['ever_paid']) {
                Session::flash('examenes_error', t('examenes.profile.locked'));
                return $this->redirect($back);
            }
            if (!RateLimiter::hit('examenes-logo', 'c' . $id, 20, 3600)) {
                Session::flash('examenes_error', t('form.rate_limited'));
                return $this->redirect($back);
            }
            $error = ExamProfile::saveLogo($id, $file);
            if ($error !== null) {
                Session::flash('examenes_error', t('examenes.profile.' . $error));
                return $this->redirect($back);
            }
        }
        Session::flash('examenes', t('examenes.profile.saved'));
        return $this->redirect($back);
    }

    public function logo(Request $request): Response
    {
        $id = $this->member($request);
        $data = $id !== null ? ExamProfile::logoData($this->profile) : null;
        if ($data === null) {
            $this->notFound();
        }
        return new Response($data, 200, ['Content-Type' => 'image/png', 'Cache-Control' => 'private, max-age=300']);
    }
}
