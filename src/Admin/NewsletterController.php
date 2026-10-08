<?php

declare(strict_types=1);

namespace App\Admin;

use App\Core\Config;
use App\Core\DB;
use App\Core\RateLimiter;
use App\Core\Request;
use App\Core\Response;
use App\Services\Newsletter\Builder;
use App\Services\Newsletter\Interests;
use App\Services\Newsletter\NewsletterSettings;
use App\Services\Newsletter\Renderer;
use App\Services\Newsletter\Sender;
use App\Services\Subscribers;

/**
 * Boletín: próxima edición (vista previa por perfil, prueba, aprobar, posponer, cancelar, enviar ahora),
 * historial con aperturas, clics y bajas, y ajustes del calendario.
 */
final class NewsletterController extends AdminBase
{
    private const BASE = '/admin/boletin/';

    public function index(Request $request): Response
    {
        $this->requireAdmin($request);
        $settings = NewsletterSettings::all();
        $open = Sender::openIssue();
        $profile = Interests::normalize(is_array($request->query['perfil'] ?? null) ? $request->query['perfil'] : (string) ($request->query['perfil'] ?? ''));
        $locale = ($request->query['idioma'] ?? '') === 'en' ? 'en' : 'es';
        $width = ($request->query['ancho'] ?? '') === '390' ? 390 : 640;
        $due = $open === null ? Sender::nextDue($settings, time()) : null;
        $previewQuery = array_filter(['perfil' => implode(',', $profile), 'idioma' => $locale === 'en' ? 'en' : null, 'edicion' => $open['id'] ?? null]);
        return $this->view('newsletter/index', [
            'settings' => $settings,
            'open' => $open,
            'stats' => $open !== null && $open['status'] === 'sending' ? Sender::stats((int) $open['id']) : null,
            'due' => $due,
            'recipients' => (int) DB::value('SELECT COUNT(*) FROM subscribers WHERE ' . Subscribers::RECEIVES),
            'byLocale' => DB::all('SELECT locale, COUNT(*) AS n FROM subscribers WHERE ' . Subscribers::RECEIVES . ' GROUP BY locale'),
            'profile' => $profile,
            'locale' => $locale,
            'width' => $width,
            'previewUrl' => route('admin.newsletter.preview') . ($previewQuery ? '?' . http_build_query($previewQuery) : ''),
            'newPosts' => $open !== null ? count(array_filter($open['content']['es']['posts'] ?? [], fn ($p) => $p['new'])) : null,
            'adminEmail' => (string) ($this->admin['email'] ?? ''),
        ], t('admin.newsletter'));
    }

    public function history(Request $request): Response
    {
        $this->requireAdmin($request);
        $issues = DB::all("SELECT * FROM newsletter_issues WHERE status IN ('sent','sending','cancelled','failed') ORDER BY scheduled_for DESC LIMIT 60");
        $rows = [];
        foreach ($issues as $issue) {
            $issue['stats'] = Sender::stats((int) $issue['id']);
            $issue['links'] = DB::all(
                'SELECT c.url, COUNT(*) AS n FROM newsletter_clicks c JOIN newsletter_sends s ON s.id = c.send_id WHERE s.issue_id = :i GROUP BY c.url ORDER BY n DESC LIMIT 6',
                ['i' => (int) $issue['id']]
            );
            $rows[] = $issue;
        }
        return $this->view('newsletter/history', ['issues' => $rows], t('admin.newsletter.history'));
    }

    public function settings(Request $request): Response
    {
        $this->requireAdmin($request);
        $settings = NewsletterSettings::all();
        return $this->view('newsletter/settings', [
            'settings' => $settings,
            'due' => Sender::openIssue()['scheduled_for'] ?? gmdate('Y-m-d H:i:s', Sender::nextDue($settings, time())),
            'adminEmailSet' => filter_var((string) Config::get('ADMIN_EMAIL', ''), FILTER_VALIDATE_EMAIL) !== false,
            'gemini' => \App\Services\Ai\Gemini::configured(),
        ], t('admin.newsletter.settings'));
    }

    public function saveSettings(Request $request): Response
    {
        $this->requireAdmin($request);
        NewsletterSettings::save($request->post);
        \App\Models\Setting::clear();
        return $this->back(self::BASE . 'ajustes/', t('admin.saved'));
    }

    /** HTML del correo para el iframe de vista previa (perfil e idioma por parámetro). */
    public function preview(Request $request): Response
    {
        $this->requireAdmin($request);
        $issue = isset($request->query['edicion']) ? Builder::issue((int) $request->query['edicion']) : null;
        $issue ??= Sender::openIssue() ?? $this->draftIssue();
        $locale = ($request->query['idioma'] ?? '') === 'en' ? 'en' : 'es';
        $profile = Interests::normalize((string) ($request->query['perfil'] ?? ''));
        $mail = Renderer::render($issue, Builder::personalize($issue, $locale, $profile));
        return Response::html($mail['html'])
            ->header('Cache-Control', 'private, no-store')
            ->header('X-Robots-Tag', 'noindex, nofollow');
    }

    /** Edición provisional (sin guardar ni IA) para ver cómo saldría si no hay una preparada. */
    private function draftIssue(): array
    {
        $settings = NewsletterSettings::all();
        $last = DB::value("SELECT COALESCE(started_at, scheduled_for) FROM newsletter_issues WHERE status = 'sent' ORDER BY scheduled_for DESC LIMIT 1");
        $since = $last !== null ? (string) $last : gmdate('Y-m-d H:i:s', time() - $settings['every_days'] * 86400);
        $content = Builder::content($since);
        [$es, $en] = Builder::intro($content, false);
        $due = gmdate('Y-m-d H:i:s', Sender::nextDue($settings, time()));
        return [
            'id' => 0, 'issue_key' => 'boletin-' . NewsletterSettings::local($due, 'Y-m-d'), 'status' => 'draft', 'scheduled_for' => $due,
            'subject' => Builder::defaultSubject($content['es']['posts'][0]['title'] ?? null, 'es'), 'subject_manual' => 0,
            'intro_es' => $es, 'intro_en' => $en, 'content' => $content,
        ];
    }

    /** Prepara ya la próxima edición (con su fecha del calendario) para revisarla con calma. */
    public function prepare(Request $request): Response
    {
        $this->requireAdmin($request);
        if (Sender::openIssue() !== null) {
            return $this->fail(self::BASE, t('admin.nl.already_open'));
        }
        $due = Sender::nextDue(NewsletterSettings::all(), time());
        $issue = Builder::createIssue(gmdate('Y-m-d H:i:s', $due), 'admin');
        return $this->back(self::BASE, t('admin.nl.prepared', ['date' => NewsletterSettings::local($issue['scheduled_for'])]));
    }

    public function test(Request $request): Response
    {
        $this->requireAdmin($request);
        $to = (string) ($this->admin['email'] ?? '');
        if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
            return $this->fail(self::BASE, t('admin.nl.no_email'));
        }
        if (!RateLimiter::hit('newsletter-test', 'admin-' . (int) $this->admin['id'], 10, 3600)) {
            return $this->fail(self::BASE, t('form.rate_limited'));
        }
        $issue = Sender::openIssue() ?? $this->draftIssue();
        $profile = Interests::normalize($request->post['interests'] ?? []);
        $locale = ($request->post['locale'] ?? '') === 'en' ? 'en' : 'es';
        $ok = Sender::sendTest($issue, $to, $profile, $locale);
        return $ok ? $this->back(self::BASE, t('admin.nl.test_sent', ['email' => $to])) : $this->fail(self::BASE, t('admin.nl.test_failed'));
    }

    /** Envía ya: la edición abierta (o una nueva con lo más reciente) sale en la próxima ejecución del cron. */
    public function sendNow(Request $request): Response
    {
        $this->requireAdmin($request);
        $open = Sender::openIssue();
        if ($open !== null && $open['status'] === 'sending') {
            return $this->fail(self::BASE, t('admin.nl.already_sending'));
        }
        if ((int) DB::value('SELECT COUNT(*) FROM subscribers WHERE ' . Subscribers::RECEIVES) === 0) {
            return $this->fail(self::BASE, t('admin.nl.no_recipients'));
        }
        $now = gmdate('Y-m-d H:i:s');
        $issue = $open ?? Builder::createIssue($now, 'admin');
        DB::run(
            'UPDATE newsletter_issues SET scheduled_for = :n, approved_at = UTC_TIMESTAMP(), preview_sent_at = COALESCE(preview_sent_at, UTC_TIMESTAMP()) WHERE id = :id',
            ['n' => $now, 'id' => (int) $issue['id']]
        );
        return $this->back(self::BASE, t('admin.nl.send_now_ok'));
    }

    /** Acciones sobre una edición: aprobar, posponer, reprogramar, cancelar, detener, regenerar y guardar textos. */
    public function action(Request $request, string $id): Response
    {
        $this->requireAdmin($request);
        $issue = Builder::issue((int) $id);
        if ($issue === null) {
            return $this->fail(self::BASE, t('admin.nl.not_found'));
        }
        $do = (string) ($request->post['do'] ?? '');
        $scheduled = $issue['status'] === 'scheduled';
        switch ($do) {
            case 'approve':
                if (!$scheduled) {
                    break;
                }
                DB::run('UPDATE newsletter_issues SET approved_at = UTC_TIMESTAMP() WHERE id = :id', ['id' => (int) $id]);
                return $this->back(self::BASE, t('admin.nl.approved'));
            case 'postpone':
                if (!$scheduled) {
                    break;
                }
                $days = (int) ($request->post['days'] ?? 1) === 7 ? 7 : 1;
                DB::run('UPDATE newsletter_issues SET scheduled_for = DATE_ADD(scheduled_for, INTERVAL ' . $days . ' DAY), preview_sent_at = NULL WHERE id = :id', ['id' => (int) $id]);
                return $this->back(self::BASE, t('admin.nl.postponed', ['date' => NewsletterSettings::local((string) DB::value('SELECT scheduled_for FROM newsletter_issues WHERE id = :id', ['id' => (int) $id]))]));
            case 'reschedule':
                $when = NewsletterSettings::toUtc((string) ($request->post['when'] ?? ''));
                if (!$scheduled || $when === null || strtotime($when . ' UTC') < time() + 300) {
                    return $this->fail(self::BASE, t('admin.nl.bad_date'));
                }
                DB::run('UPDATE newsletter_issues SET scheduled_for = :w, preview_sent_at = NULL WHERE id = :id', ['w' => $when, 'id' => (int) $id]);
                return $this->back(self::BASE, t('admin.nl.postponed', ['date' => NewsletterSettings::local($when)]));
            case 'cancel':
                if (!$scheduled) {
                    break;
                }
                DB::run("UPDATE newsletter_issues SET status = 'cancelled', note = 'Cancelada en el panel' WHERE id = :id AND status = 'scheduled'", ['id' => (int) $id]);
                return $this->back(self::BASE, t('admin.nl.cancelled'));
            case 'stop':
                if ($issue['status'] !== 'sending') {
                    break;
                }
                DB::run("UPDATE newsletter_sends SET status = 'skipped', error = 'Envío detenido en el panel' WHERE issue_id = :id AND status = 'queued'", ['id' => (int) $id]);
                DB::run("UPDATE newsletter_issues SET status = 'cancelled', finished_at = UTC_TIMESTAMP(), note = 'Detenida en el panel' WHERE id = :id", ['id' => (int) $id]);
                return $this->back(self::BASE . 'historial/', t('admin.nl.stopped'));
            case 'rebuild':
                if (!$scheduled) {
                    break;
                }
                Builder::rebuild((int) $id);
                return $this->back(self::BASE, t('admin.nl.rebuilt'));
            case 'save':
                if (!$scheduled) {
                    break;
                }
                $subject = self::str($request, 'subject', 200);
                $introEs = self::str($request, 'intro_es', 800);
                $introEn = self::str($request, 'intro_en', 800);
                // Asunto vacío o igual al automático = automático (cada persona ve el título de su primer artículo).
                $auto = Builder::defaultSubject($issue['content']['es']['posts'][0]['title'] ?? null, 'es');
                $manual = $subject !== null && $subject !== $auto;
                $data = ['subject' => $manual ? $subject : $auto, 'subject_manual' => $manual ? 1 : 0];
                if ($introEs !== null && ($introEs !== $issue['intro_es'] || $introEn !== $issue['intro_en'])) {
                    $data += ['intro_es' => $introEs, 'intro_en' => $introEn ?? $issue['intro_en'], 'intro_source' => 'manual'];
                }
                DB::update('newsletter_issues', $data, ['id' => (int) $id]);
                return $this->back(self::BASE, t('admin.saved'));
        }
        return $this->fail(self::BASE, t('admin.nl.bad_action'));
    }
}
