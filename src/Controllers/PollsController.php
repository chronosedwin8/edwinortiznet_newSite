<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\RateLimiter;
use App\Core\Request;
use App\Core\Response;
use App\Services\Polls;
use App\Services\Reactions;

/**
 * API de las encuestas de los artículos. Las páginas están en la caché de página completa, así que los resultados y
 * "tus respuestas" se piden aquí desde JS.
 *
 * GET  /api/encuestas/{key}  → {people, questions:[{total, counts}], mine:{pregunta: opción}}
 * POST /api/encuestas/{key}  answers={"0":2,"1":0,…} (JSON, o formulario a[0]=2). CSRF por cabecera X-CSRF-Token o campo _csrf.
 */
final class PollsController extends Controller
{
    public function show(Request $request, string $key): Response
    {
        if (Polls::definition($key, 'es') === null) {
            return Response::json(['error' => 'not_found'], 404);
        }
        return Response::json($this->payload($key, $this->hash($request, $key)));
    }

    public function vote(Request $request, string $key): Response
    {
        $json = str_contains((string) $request->header('Content-Type'), 'application/json');
        $data = $json ? $request->json() : $request->post;
        $wantsJson = $json || $request->wantsJson();

        if (!Csrf::check($request)) {
            return Response::json(['error' => 'csrf'], 419);
        }
        if (!RateLimiter::hit('poll', $request->ip(), 20, 600)) {
            return Response::json(['error' => 'rate_limited'], 429);
        }
        if (Polls::definition($key, 'es') === null) {
            return Response::json(['error' => 'not_found'], 404);
        }
        $answers = $data['answers'] ?? $data['a'] ?? [];
        $answers = is_array($answers) ? array_slice($answers, 0, Polls::MAX_QUESTIONS, true) : [];

        $visitor = Polls::visitorId($request);
        $setCookie = false;
        if ($visitor === null) {
            $visitor = Reactions::newVisitorId();
            $setCookie = true;
        }
        $hash = Polls::visitorHash($visitor, $key);
        $locale = ($data['locale'] ?? '') === 'en' ? 'en' : 'es';
        if (Polls::record($key, $hash, $answers, $locale) === 0) {
            return Response::json(['error' => 'invalid_answers'], 422);
        }

        if ($wantsJson) {
            $response = Response::json(['ok' => true] + $this->payload($key, $hash));
        } else {
            // Solo la ruta del Referer (nunca otro dominio) para volver al artículo.
            $path = (string) parse_url((string) $request->header('Referer'), PHP_URL_PATH);
            $response = Response::redirect(($path !== '' && str_starts_with($path, '/') && !str_starts_with($path, '//') ? $path : '/') . '#encuesta', 303);
        }
        if ($setCookie) {
            $response->headers['Set-Cookie'][] = Reactions::cookieHeader($visitor, $request);
        }
        return $response;
    }

    private function hash(Request $request, string $key): ?string
    {
        $visitor = Polls::visitorId($request);
        return $visitor !== null ? Polls::visitorHash($visitor, $key) : null;
    }

    private function payload(string $key, ?string $hash): array
    {
        return Polls::results($key) + ['mine' => (object) ($hash !== null ? Polls::mine($key, $hash) : [])];
    }
}
