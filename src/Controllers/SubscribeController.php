<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\HttpException;
use App\Core\RateLimiter;
use App\Core\Request;
use App\Core\Response;
use App\Services\I18n\I18n;
use App\Services\Newsletter\Interests;
use App\Services\Subscribers;

/**
 * Suscripción al boletín: alta (doble opt-in), confirmación con botón y temas, centro de preferencias y baja
 * (también "un clic" de Gmail/Yahoo por POST, RFC 8058).
 */
final class SubscribeController extends Controller
{
    public function store(Request $request): Response
    {
        $this->requireHuman($request);
        $locale = I18n::locale();
        // Límites por IP (ataques de "bombardeo de suscripciones" desde centros de datos).
        if (!RateLimiter::hit('subscribe', $request->ip(), 8, 3600) || !RateLimiter::hit('subscribe-day', $request->ip(), 3, 86400)) {
            return $this->reply($request, false, t('form.rate_limited'), 429);
        }
        $email = strtolower($request->str('email'));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 190) {
            return $this->reply($request, false, t('form.invalid_email'), 422);
        }
        $subscriber = Subscribers::add($email, $locale, $this->origin($request));
        // Tope global de correos de confirmación dentro de sendConfirmation(): la respuesta es la misma para no dar pistas.
        if (($subscriber['status'] ?? '') === 'pending') {
            Subscribers::sendConfirmation($subscriber);
        }
        return $this->reply($request, true, t('subscribe.check_email'), 200);
    }

    /** Origen de la suscripción: campos ocultos del formulario (los pone el servidor) + referencia y UTM. */
    private function origin(Request $request): array
    {
        $data = [
            'source' => $request->str('source', 'web'),
            'tag' => $request->str('tag', 'general'),
            'source_type' => $request->str('source_type', 'other'),
            'source_path' => $request->str('source_path'),
            'source_title' => $request->str('source_title'),
            'interests' => is_array($request->post['interests'] ?? null) ? $request->post['interests'] : [],
            'ip' => $request->ip(),
        ];
        // Referencia externa (document.referrer, la llena main.js): solo el sitio y la ruta.
        $ref = $request->str('ref');
        if ($ref !== '' && preg_match('#^https?://#i', $ref)) {
            $host = (string) parse_url($ref, PHP_URL_HOST);
            $own = (string) parse_url(\App\Core\Config::appUrl(), PHP_URL_HOST);
            if ($host !== '' && $host !== $own) {
                $data['referrer'] = $host . (string) parse_url($ref, PHP_URL_PATH);
            }
        }
        // UTM: del formulario (main.js las copia de la URL) o de la página desde la que se envió.
        parse_str((string) parse_url((string) $request->header('Referer'), PHP_URL_QUERY), $pageQuery);
        foreach (['utm_source', 'utm_medium', 'utm_campaign'] as $key) {
            $value = $request->str($key);
            if ($value === '' && is_string($pageQuery[$key] ?? null)) {
                $value = $pageQuery[$key];
            }
            $data[$key] = $value;
        }
        return $data;
    }

    /**
     * GET muestra el botón y los temas; solo el POST confirma: los filtros de seguridad del correo
     * (Safe Links y similares) abren los enlaces automáticamente y confirmaban solos.
     */
    public function confirm(Request $request, string $token): Response
    {
        $row = Subscribers::find($token);
        if ($row === null || in_array($row['status'], ['spam', 'bounced'], true)) {
            return $this->message('subscribe.invalid_link', 404);
        }
        if ($request->method === 'POST') {
            $this->requireCsrf($request);
            $interests = $request->str('interests_sent') === '1' ? Interests::normalize($request->post['interests'] ?? []) : null;
            Subscribers::confirm($token, $interests, $request->ip());
            return $this->message('subscribe.confirmed', 200, route('subscribe.preferences', ['token' => $token]), t('subscribe.prefs.link'));
        }
        if ($row['status'] === 'active') {
            return $this->message('subscribe.confirmed', 200, route('subscribe.preferences', ['token' => $token]), t('subscribe.prefs.link'));
        }
        $response = $this->page('pages/subscribe-confirm', [
            'token' => $token,
            'interests' => Interests::fromSet($row['interests']),
        ], [
            'title' => t('subscribe.confirm.title'),
            'noindex' => true,
        ]);
        return $response->header('Cache-Control', 'private, no-store');
    }

    /** Centro de preferencias: temas, idioma, pausa y baja. */
    public function preferences(Request $request, string $token): Response
    {
        $row = Subscribers::find($token);
        if ($row === null || in_array($row['status'], ['spam', 'bounced'], true)) {
            return $this->message('subscribe.invalid_link', 404);
        }
        $saved = false;
        if ($request->method === 'POST') {
            $this->requireCsrf($request);
            $pause = in_array($request->str('pause'), ['1m', '3m'], true) ? $request->str('pause') : '';
            $locale = $request->str('locale') === 'en' ? 'en' : 'es';
            $row = Subscribers::savePreferences($row, Interests::normalize($request->post['interests'] ?? []), $locale, $pause) ?? $row;
            $saved = true;
        }
        $response = $this->page('pages/subscribe-preferences', [
            'row' => $row,
            'token' => $token,
            'interests' => Interests::fromSet($row['interests']),
            'saved' => $saved,
            'paused' => $row['paused_until'] !== null && strtotime((string) $row['paused_until'] . ' UTC') > time(),
        ], [
            'title' => t('subscribe.prefs.title'),
            'noindex' => true,
        ]);
        return $response->header('Cache-Control', 'private, no-store')->header('Referrer-Policy', 'no-referrer');
    }

    /**
     * Baja. GET muestra un botón (los escáneres de enlaces no dan de baja a nadie); POST la hace.
     * POST con "List-Unsubscribe=One-Click" (Gmail, Yahoo) no lleva CSRF: el token de 64 caracteres es la clave.
     */
    public function unsubscribe(Request $request, string $token): Response
    {
        $row = Subscribers::find($token);
        if ($row === null) {
            return $this->message('subscribe.invalid_link', 404);
        }
        $sendId = (int) ($request->query['n'] ?? $request->post['n'] ?? 0);
        if ($request->method === 'POST') {
            $oneClick = ($request->post['List-Unsubscribe'] ?? null) === 'One-Click';
            if (!$oneClick && !Csrf::check($request)) {
                throw new HttpException(419, 'CSRF');
            }
            $reason = $oneClick ? 'one-click' : $this->reason($request);
            Subscribers::unsubscribe($token, $reason, $sendId ?: null);
            if ($oneClick) {
                return Response::text('OK', 200);
            }
            return $this->message('subscribe.unsubscribed', 200, route('subscribe.preferences', ['token' => $token]), t('subscribe.unsub.resubscribe'));
        }
        if ($row['status'] === 'unsubscribed') {
            return $this->message('subscribe.unsubscribed', 200, route('subscribe.preferences', ['token' => $token]), t('subscribe.unsub.resubscribe'));
        }
        $response = $this->page('pages/subscribe-unsubscribe', ['token' => $token, 'sendId' => $sendId], [
            'title' => t('subscribe.unsub.title'),
            'noindex' => true,
        ]);
        return $response->header('Cache-Control', 'private, no-store')->header('Referrer-Policy', 'no-referrer');
    }

    private function reason(Request $request): ?string
    {
        $key = $request->str('reason');
        $label = in_array($key, ['too_many', 'not_relevant', 'never_signed', 'other'], true) ? t("subscribe.unsub.reason.$key", [], 'es') : null;
        $detail = mb_substr(trim($request->str('reason_text')), 0, 180);
        $out = trim(($label ?? '') . ($detail !== '' ? ($label ? ': ' : '') . $detail : ''));
        return $out === '' ? null : $out;
    }

    private function message(string $key, int $status, ?string $actionUrl = null, ?string $actionLabel = null): Response
    {
        $response = $this->page('pages/message', [
            'title' => t("$key.title"), 'text' => t("$key.text"), 'actionUrl' => $actionUrl, 'actionLabel' => $actionLabel,
        ], [
            'title' => t("$key.title"),
            'noindex' => true,
        ]);
        $response->status = $status;
        return $response->header('Cache-Control', 'private, no-store');
    }

    private function reply(Request $request, bool $ok, string $message, int $status): Response
    {
        if ($request->wantsJson()) {
            return Response::json(['ok' => $ok, 'message' => $message], $status);
        }
        $response = $this->page('pages/message', ['title' => $ok ? t('subscribe.thanks') : t('form.error_title'), 'text' => $message], [
            'title' => $ok ? t('subscribe.thanks') : t('form.error_title'),
            'noindex' => true,
        ]);
        $response->status = $status;
        return $response;
    }
}
