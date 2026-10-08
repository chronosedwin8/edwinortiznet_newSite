<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Mailer;
use App\Core\RateLimiter;
use App\Core\Request;
use App\Core\Response;
use App\Services\I18n\I18n;
use App\Services\Mail\MailTemplates;
use App\Services\Subscribers;

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
        $subscriber = Subscribers::add($email, $locale, $request->str('source', 'web'), $request->str('tag', 'general'));
        // Tope global de correos de confirmación: protege la reputación del remitente (Amazon SES)
        // si un ataque registra correos ajenos. La respuesta es la misma para no dar pistas.
        $mailAllowed = RateLimiter::hit('subscribe-mail', 'global', 15, 3600) && RateLimiter::hit('subscribe-mail-day', 'global', 60, 86400);
        if (!$mailAllowed) {
            \App\Core\Logger::warning('Tope de correos de confirmación de suscripción alcanzado', ['source' => $request->str('source', 'web')]);
        }
        if ($subscriber['confirmed_at'] === null && $mailAllowed) {
            $mail = MailTemplates::render('subscribe-confirm', $locale, [
                'confirmUrl' => url(route('subscribe.confirm', ['token' => $subscriber['token']])),
            ]);
            Mailer::send($email, $mail['subject'], $mail['html'], $mail['text']);
        }
        return $this->reply($request, true, t('subscribe.check_email'), 200);
    }

    /**
     * GET muestra un botón y solo el POST confirma: los filtros de seguridad del correo
     * (Safe Links y similares) abren los enlaces automáticamente y confirmaban solos.
     */
    public function confirm(Request $request, string $token): Response
    {
        $row = Subscribers::find($token);
        if ($row === null) {
            return $this->message('subscribe.invalid_link', 404);
        }
        if ($request->method === 'POST') {
            $this->requireCsrf($request);
            Subscribers::confirm($token);
            return $this->message('subscribe.confirmed', 200);
        }
        if ($row['confirmed_at'] !== null && $row['unsubscribed_at'] === null) {
            return $this->message('subscribe.confirmed', 200);
        }
        $response = $this->page('pages/subscribe-confirm', ['token' => $token], [
            'title' => t('subscribe.confirm.title'),
            'noindex' => true,
        ]);
        return $response->header('Cache-Control', 'private, no-store');
    }

    public function unsubscribe(Request $request, string $token): Response
    {
        $row = Subscribers::unsubscribe($token);
        return $this->message($row !== null ? 'subscribe.unsubscribed' : 'subscribe.invalid_link', $row !== null ? 200 : 404);
    }

    private function message(string $key, int $status): Response
    {
        $response = $this->page('pages/message', ['title' => t("$key.title"), 'text' => t("$key.text")], [
            'title' => t("$key.title"),
            'noindex' => true,
        ]);
        $response->status = $status;
        return $response;
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
