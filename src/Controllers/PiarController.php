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
use App\Services\I18n\I18n;
use App\Services\Mail\MailTemplates;
use App\Services\Piar\PiarAssist;
use App\Services\Piar\PiarCatalog;
use App\Services\Piar\PiarCredits;
use App\Services\Piar\PiarPdf;
use App\Services\Piar\PiarPlans;
use App\Services\Piar\PiarProfile;
use App\Services\Piar\PiarPrompt;
use App\Services\Seo\Meta;

/**
 * PIAR con IA (/piar/): acceso por enlace mágico (misma cuenta que la tienda), asistente, generación
 * asíncrona con Gemini, historial, edición, PDF y perfil con logo. Solo en español.
 * La página de presentación vive en /herramientas/piar/ (landing()).
 */
final class PiarController extends Controller
{
    private ?array $customer = null;
    private ?array $profile = null;

    // ------------------------------------------------------------------ utilidades

    private function customer(Request $request): ?array
    {
        Session::start($request);
        $id = Session::get('customer_id');
        $this->customer = is_int($id) ? DB::one('SELECT id, email, name FROM customers WHERE id = :id', ['id' => $id]) : null;
        $this->profile = $this->customer ? PiarProfile::get((int) $this->customer['id']) : null;
        return $this->customer;
    }

    /** Cuenta con sesión y términos aceptados; si no, null (el panel muestra el acceso o los términos). */
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
        $response = $this->page('pages/piar/' . $template, $data + [
            'customer' => $this->customer,
            'profile' => $this->profile,
            'notice' => Session::flash('piar'),
            'error' => Session::flash('piar_error'),
        ], [
            'title' => $title,
            'noindex' => true,
            'body_class' => 'page-piar page-piar--' . $template,
            'styles' => ['css/piar.css'],
            'scripts' => ['js/piar.js'],
        ]);
        $response->status = $status;
        return $response->header('Cache-Control', 'private, no-store')->header('X-Robots-Tag', 'noindex');
    }

    private function home(?string $error = null, ?string $notice = null): Response
    {
        if ($error !== null) {
            Session::flash('piar_error', $error);
        }
        if ($notice !== null) {
            Session::flash('piar', $notice);
        }
        return $this->redirect(route('piar'));
    }

    private function plan(Request $request, string $uuid, int $customerId): array
    {
        $plan = PiarPlans::find($uuid, $customerId);
        if ($plan === null) {
            $this->notFound();
        }
        // Un "pending" que lleva demasiado se da por fallido (y devuelve el crédito).
        if ($plan['status'] === 'pending' && strtotime($plan['created_at'] . ' UTC') < time() - PiarPlans::STALE_SECONDS) {
            PiarPlans::fail($plan, 'Tiempo de espera agotado.');
            $plan = PiarPlans::find($uuid, $customerId) ?? $plan;
        }
        return $plan;
    }

    private static function sessionTrials(): array
    {
        $trials = Session::get('piar_trials', []);
        return is_array($trials) ? array_values(array_filter($trials, 'is_string')) : [];
    }

    // ------------------------------------------------------------------ presentación (/herramientas/piar/)

    public function landing(string $slug): Response
    {
        $path = route('tool', ['slug' => $slug]);
        $crumbs = [[t('nav.home'), route('home')], [t('nav.tools'), route('tools')], [t('tool.piar.name'), $path]];
        $faqs = [];
        for ($i = 1; I18n::has("piar.faq{$i}_q"); $i++) {
            $faqs[] = ['q' => t("piar.faq{$i}_q"), 'a' => t("piar.faq{$i}_a")];
        }
        $offers = PiarCredits::offers();
        return $this->page('pages/piar/landing', [
            'crumbs' => $crumbs,
            'faqs' => $faqs,
            'offers' => $offers,
        ], [
            'title' => t('piar.seo_title'),
            'title_full' => true,
            'description' => t('piar.seo_description'),
            'breadcrumbs' => $crumbs,
            'styles' => ['css/piar.css'],
            'body_class' => 'page-piar page-piar--landing',
            'jsonld' => [[
                '@context' => 'https://schema.org',
                '@type' => 'SoftwareApplication',
                'name' => t('piar.brand'),
                'url' => url($path),
                'applicationCategory' => 'EducationalApplication',
                'operatingSystem' => 'Any',
                'inLanguage' => 'es-CO',
                'description' => t('piar.seo_description'),
                'creator' => Meta::person(),
                'offers' => array_merge(
                    [['@type' => 'Offer', 'name' => t('piar.price.trial_name'), 'price' => '0', 'priceCurrency' => 'COP', 'url' => url(route('piar'))]],
                    array_map(fn (array $o) => [
                        '@type' => 'Offer',
                        'name' => t('piar.price.package', ['n' => $o['credits']]),
                        'price' => (string) $o['price_cop'],
                        'priceCurrency' => 'COP',
                        'url' => url(route('piar.plans')),
                    ], $offers)
                ),
            ], Meta::faqPage($faqs)],
        ]);
    }

    // ------------------------------------------------------------------ acceso

    public function dashboard(Request $request): Response
    {
        $customer = $this->customer($request);
        if ($customer === null) {
            $old = Session::get('piar_old');
            Session::forget('piar_old');
            return $this->view('access', ['old' => is_array($old) ? $old : [], 'admin' => self::admin()], t('piar.access.title'));
        }
        $id = (int) $customer['id'];
        if (empty($this->profile['terms_accepted_at'])) {
            return $this->view('terms', [], t('piar.terms.title'));
        }
        PiarPlans::housekeeping();
        return $this->view('dashboard', [
            'summary' => PiarCredits::summary($id),
            'history' => PiarPlans::history($id),
            'pending' => PiarPlans::pending($id),
            'grades' => PiarCatalog::grades(),
        ], t('piar.dash.title'));
    }

    /** Administrador con sesión en el panel (para entrar sin enlace mágico). */
    private static function admin(): ?array
    {
        return AdminAccess::sessionAdmin();
    }

    /** Atajo para el administrador: entra con la cuenta PIAR de su mismo correo (la crea si no existe). */
    public function adminLogin(Request $request): Response
    {
        $this->requireCsrf($request);
        Session::start($request);
        $admin = self::admin();
        if ($admin === null) {
            return $this->redirect(route('piar'));
        }
        PiarProfile::acceptTerms(AdminAccess::enterAsCustomer($admin));
        return $this->redirect(route('piar'));
    }

    public function requestLink(Request $request): Response
    {
        $this->requireCsrf($request);
        Session::start($request);
        $email = strtolower($request->str('email'));
        $name = mb_substr($request->str('name'), 0, 120);
        Session::set('piar_old', ['email' => mb_substr($email, 0, 190), 'name' => $name]);
        if (!RateLimiter::hit('piar-link', $request->ip(), 8, 3600) || !RateLimiter::hit('piar-link-mail', $email, 4, 900)) {
            return $this->home(t('form.rate_limited'));
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 190) {
            return $this->home(t('piar.access.bad_email'));
        }
        if (mb_strlen($name) < 2) {
            return $this->home(t('piar.access.bad_name'));
        }
        if ($request->str('terms') !== '1') {
            return $this->home(t('piar.access.need_terms'));
        }
        // A diferencia de Mi cuenta, aquí el acceso crea la cuenta si no existe.
        $customerId = PiarCredits::customerFor($email, $name);
        PiarProfile::acceptTerms($customerId);
        $token = bin2hex(random_bytes(32));
        DB::insert('login_tokens', [
            'customer_id' => $customerId,
            'token_hash' => hash('sha256', $token),
            'expires_at' => gmdate('Y-m-d H:i:s', time() + 900),
        ]);
        $mail = MailTemplates::render('piar-login', 'es', ['loginUrl' => url(route('piar.login', ['token' => $token])), 'name' => $name]);
        Mailer::send($email, $mail['subject'], $mail['html'], $mail['text']);
        Session::forget('piar_old');
        Session::set('piar_sent', $email);
        return $this->home(null, t('piar.access.sent', ['email' => $email]));
    }

    public function login(Request $request, string $token): Response
    {
        Session::start($request);
        $row = DB::one(
            'SELECT * FROM login_tokens WHERE token_hash = :h AND used_at IS NULL AND expires_at > :now',
            ['h' => hash('sha256', $token), 'now' => DB::now()]
        );
        if ($row === null) {
            return $this->home(t('piar.access.link_invalid'));
        }
        DB::run('UPDATE login_tokens SET used_at = :now WHERE id = :id', ['now' => DB::now(), 'id' => (int) $row['id']]);
        Session::regenerate();
        Session::set('customer_id', (int) $row['customer_id']);
        Session::forget('piar_sent');
        return $this->redirect(route('piar'));
    }

    public function logout(Request $request): Response
    {
        $this->requireCsrf($request);
        Session::start($request);
        Session::forget('customer_id');
        Session::forget('piar_trials');
        Session::regenerate();
        return $this->redirect(route('piar'));
    }

    /** Cuenta que ya existía (p. ej., de la tienda) y entra por primera vez al PIAR. */
    public function acceptTerms(Request $request): Response
    {
        $this->requireCsrf($request);
        $customer = $this->customer($request);
        if ($customer === null) {
            return $this->redirect(route('piar'));
        }
        if ($request->str('terms') !== '1') {
            return $this->home(t('piar.access.need_terms'));
        }
        PiarProfile::acceptTerms((int) $customer['id']);
        return $this->redirect(route('piar'));
    }

    // ------------------------------------------------------------------ asistente y generación

    public function create(Request $request): Response
    {
        $id = $this->member($request);
        if ($id === null) {
            return $this->redirect(route('piar'));
        }
        $summary = PiarCredits::summary($id);
        $canCreate = $summary['remaining'] > 0 || (!$summary['has_active'] && $summary['trial_left'] > 0);
        return $this->view('wizard', [
            'summary' => $summary,
            'canCreate' => $canCreate,
            'isTrial' => $summary['remaining'] === 0,
            'conditions' => PiarCatalog::conditions(),
            'groupNotes' => PiarCatalog::groupNotes(),
            'grades' => PiarCatalog::grades(),
            'areas' => PiarCatalog::areas(),
            'levels' => PiarCatalog::supportLevels(),
            'dimensions' => PiarCatalog::dimensions(),
            'dimensionHints' => PiarCatalog::dimensionHints(),
            'priorities' => PiarCatalog::priorities(),
            'periods' => PiarCatalog::periods(),
            'help' => PiarCatalog::formHelp(),
            'example' => PiarCatalog::examples(),
            'aiReady' => Gemini::configured(),
        ], t('piar.new.title'));
    }

    public function store(Request $request): Response
    {
        $this->requireCsrf($request);
        $id = $this->member($request);
        if ($id === null) {
            return $this->redirect(route('piar'));
        }
        $back = route('piar.new');
        $fail = function (string $message, ?string $to = null) use ($back): Response {
            Session::flash('piar_error', $message);
            return $this->redirect($to ?? $back);
        };
        if ($request->str('autorizacion') !== '1') {
            return $fail(t('piar.error.consent'));
        }
        if (!RateLimiter::hit('piar-gen', $request->ip(), 20, 3600) || !RateLimiter::hit('piar-gen-c', 'c' . $id, 10, 3600)) {
            return $fail(t('form.rate_limited'));
        }
        $input = PiarPlans::sanitizeInput($request->post);
        $invalid = PiarPlans::validate($input);
        if ($invalid !== null) {
            return $fail(t('piar.error.' . $invalid));
        }
        if (!Gemini::configured()) {
            return $fail(t('piar.error.unavailable'));
        }
        $result = PiarPlans::create($id, $input, $request->ip());
        if ($result['error'] !== null) {
            $toPlans = in_array($result['error'], ['no_credits', 'trial_exhausted'], true);
            return $fail(t('piar.error.' . $result['error']), $toPlans ? route('piar.plans') : null);
        }
        $plan = $result['plan'];
        if ((int) $plan['is_trial'] === 1) {
            Session::set('piar_trials', array_slice([...self::sessionTrials(), $plan['uuid']], -10));
        }
        self::dispatchGeneration((int) $plan['id']);
        return $this->redirect(route('piar.show', ['uuid' => $plan['uuid']]));
    }

    /**
     * Con PHP-FPM la generación sigue después de enviar la respuesta (fastcgi_finish_request), así ningún
     * proxy corta la espera; la página consulta /estado/. Sin FPM (Apache mod_php, pruebas) se genera aquí mismo.
     */
    private static function dispatchGeneration(int $planId): void
    {
        $work = static function () use ($planId): void {
            ignore_user_abort(true);
            set_time_limit(300);
            PiarPlans::generate($planId);
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
            return $this->redirect(route('piar'));
        }
        PiarPlans::housekeeping();
        $plan = $this->plan($request, $uuid, $id);
        $isTrial = (int) $plan['is_trial'] === 1;
        if ($isTrial && !PiarPlans::trialVisible($plan, self::sessionTrials())) {
            return $this->view('expired', ['summary' => PiarCredits::summary($id)], t('piar.expired.title'), 410);
        }
        return $this->view('plan', [
            'plan' => $plan,
            'isTrial' => $isTrial,
            'input' => PiarPlans::input($plan),
            'output' => $plan['status'] === 'done' ? PiarPlans::output($plan) : [],
            'sections' => PiarPrompt::sections(),
            'summary' => PiarCredits::summary($id),
        ], $plan['status'] === 'done' ? t('piar.plan.title_for', ['alias' => $plan['student_alias'] ?: t('piar.plan.student')]) : t('piar.progress.title'));
    }

    public function status(Request $request, string $uuid): Response
    {
        $id = $this->member($request);
        $plan = $id !== null ? PiarPlans::find($uuid, $id) : null;
        if ($plan === null || ((int) $plan['is_trial'] === 1 && !PiarPlans::trialVisible($plan, self::sessionTrials()))) {
            return Response::json(['status' => 'missing'], 404);
        }
        $plan = $this->plan($request, $uuid, (int) $id);
        $response = Response::json([
            'status' => $plan['status'],
            'url' => route('piar.show', ['uuid' => $plan['uuid']]),
            'message' => $plan['status'] === 'error' ? t('piar.progress.failed') : null,
        ]);
        return $response->header('Cache-Control', 'private, no-store');
    }

    // ------------------------------------------------------------------ edición y PDF (solo pagados)

    private function paidPlan(Request $request, string $uuid): array|Response
    {
        $id = $this->member($request);
        if ($id === null) {
            return $this->redirect(route('piar'));
        }
        $plan = $this->plan($request, $uuid, $id);
        if ((int) $plan['is_trial'] === 1) {
            Session::flash('piar_error', t('piar.error.trial_locked'));
            return $this->redirect(route('piar.plans'));
        }
        if ($plan['status'] !== 'done') {
            return $this->redirect(route('piar.show', ['uuid' => $plan['uuid']]));
        }
        return $plan;
    }

    public function edit(Request $request, string $uuid): Response
    {
        $plan = $this->paidPlan($request, $uuid);
        if ($plan instanceof Response) {
            return $plan;
        }
        return $this->view('edit', [
            'plan' => $plan,
            'assistQuota' => PiarAssist::quota((int) $plan['customer_id']),
            'output' => PiarPlans::output($plan),
            'sections' => PiarPrompt::sections(),
        ], t('piar.edit.title'));
    }

    public function update(Request $request, string $uuid): Response
    {
        $this->requireCsrf($request);
        $plan = $this->paidPlan($request, $uuid);
        if ($plan instanceof Response) {
            return $plan;
        }
        PiarPlans::saveEdit($plan, $request->post);
        Session::flash('piar', t('piar.edit.saved'));
        return $this->redirect(route('piar.show', ['uuid' => $plan['uuid']]));
    }

    /** "Redactar con IA" en un campo del editor (JSON). No descuenta créditos; tiene límite por hora y día. */
    public function assist(Request $request, string $uuid): Response
    {
        $this->requireCsrf($request);
        $json = static fn (array $data, int $status = 200): Response => Response::json($data, $status)->header('Cache-Control', 'private, no-store');
        $id = $this->member($request);
        $plan = $id !== null ? PiarPlans::find($uuid, $id) : null;
        if ($plan === null || (int) $plan['is_trial'] === 1 || $plan['status'] !== 'done') {
            return $json(['ok' => false, 'error' => t('piar.assist.forbidden')], 403);
        }
        $blocked = PiarAssist::blocked((int) $id);
        // Administrador: sin cupo de paquete (left = null deja el aviso de acceso de administrador), con el límite por hora.
        $left = static fn (): ?int => ($q = PiarAssist::quota((int) $id))['admin'] ? null : $q['left'];
        if ($blocked !== null || !RateLimiter::hit('piar-assist', $request->ip(), 20, 3600)) {
            $message = $blocked === 'quota' ? t('piar.assist.quota_out') : t('piar.assist.limit', ['hour' => PiarAssist::PER_HOUR]);
            return $json(['ok' => false, 'error' => $message, 'left' => $left()], 429);
        }
        @set_time_limit(120);
        try {
            $result = PiarAssist::draft($plan, (int) $id, $request->post);
        } catch (\RuntimeException $e) {
            return $json(['ok' => false, 'error' => $e->getMessage()], 422);
        }
        return $json(['ok' => true, 'left' => $left()] + $result);
    }

    public function pdf(Request $request, string $uuid): Response
    {
        $plan = $this->paidPlan($request, $uuid);
        if ($plan instanceof Response) {
            return $plan;
        }
        $pdf = PiarPdf::render($plan, $this->profile);
        $name = PiarPlans::fileName($plan);
        return new Response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $name . '"',
            'Cache-Control' => 'private, no-store',
            'X-Robots-Tag' => 'noindex',
        ]);
    }

    // ------------------------------------------------------------------ planes y perfil

    public function plans(Request $request): Response
    {
        $customer = $this->customer($request);
        $summary = $customer !== null ? PiarCredits::summary((int) $customer['id']) : null;
        return $this->view('plans', [
            'offers' => PiarCredits::offers(),
            'summary' => $summary,
        ], t('piar.plans.title'));
    }

    public function profile(Request $request): Response
    {
        $id = $this->member($request);
        if ($id === null) {
            return $this->redirect(route('piar'));
        }
        return $this->view('profile', ['summary' => PiarCredits::summary($id)], t('piar.profile.title'));
    }

    public function saveProfile(Request $request): Response
    {
        $this->requireCsrf($request);
        $id = $this->member($request);
        if ($id === null) {
            return $this->redirect(route('piar'));
        }
        $back = route('piar.profile');
        if (!PiarCredits::summary($id)['has_active']) {
            Session::flash('piar_error', t('piar.profile.locked'));
            return $this->redirect($back);
        }
        PiarProfile::save($id, mb_substr($request->str('institution'), 0, 190), mb_substr($request->str('city'), 0, 120));
        if ($request->str('remove_logo') === '1') {
            PiarProfile::removeLogo($id);
        }
        $file = $request->files['logo'] ?? null;
        if (is_array($file) && (int) ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
            if (!RateLimiter::hit('piar-logo', 'c' . $id, 20, 3600)) {
                Session::flash('piar_error', t('form.rate_limited'));
                return $this->redirect($back);
            }
            $error = PiarProfile::saveLogo($id, $file);
            if ($error !== null) {
                Session::flash('piar_error', t('piar.profile.' . $error));
                return $this->redirect($back);
            }
        }
        Session::flash('piar', t('piar.profile.saved'));
        return $this->redirect($back);
    }

    public function logo(Request $request): Response
    {
        $id = $this->member($request);
        $data = $id !== null ? PiarProfile::logoData($this->profile) : null;
        if ($data === null) {
            $this->notFound();
        }
        return new Response($data, 200, ['Content-Type' => 'image/png', 'Cache-Control' => 'private, max-age=300']);
    }
}
