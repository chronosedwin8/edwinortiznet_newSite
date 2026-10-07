<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\RateLimiter;
use App\Core\Request;
use App\Core\Response;
use App\Models\Post;
use App\Services\Reactions;

/**
 * API de reacciones. Las páginas de artículos están en la caché de página completa, así que los
 * datos de cada visitante (conteos al día y "tu reacción") se piden aquí desde JS.
 *
 * GET  /api/reacciones/{id}  → {total, counts, top, mine}
 * POST /api/reacciones/{id}  reaction=like|insightful|celebrate|love|thoughtful|"" (vacío = quitar)
 *      CSRF por cabecera X-CSRF-Token o campo _csrf. Sin JS (formulario), redirige al artículo.
 */
final class ReactionsController extends Controller
{
    public function show(Request $request, string $id): Response
    {
        $postId = (int) $id;
        if (!Reactions::reactable($postId)) {
            return Response::json(['error' => 'not_found'], 404);
        }
        $visitor = Reactions::visitorId($request);
        return Response::json($this->payload($postId, $visitor !== null ? Reactions::visitorHash($visitor) : null));
    }

    public function update(Request $request, string $id): Response
    {
        $postId = (int) $id;
        $json = str_contains((string) $request->header('Content-Type'), 'application/json');
        $data = $json ? $request->json() : $request->post;
        $wantsJson = $json || $request->wantsJson();

        if (!Csrf::check($request)) {
            return Response::json(['error' => 'csrf'], 419);
        }
        if (!RateLimiter::hit('reaction', $request->ip(), 30, 600)) {
            return Response::json(['error' => 'rate_limited'], 429);
        }
        if (!Reactions::reactable($postId)) {
            return Response::json(['error' => 'not_found'], 404);
        }
        $reaction = $data['reaction'] ?? null;
        $reaction = is_string($reaction) && $reaction !== '' && $reaction !== 'none' ? $reaction : null;
        if ($reaction !== null && !Reactions::isValid($reaction)) {
            return Response::json(['error' => 'invalid_reaction'], 422);
        }

        $visitor = Reactions::visitorId($request);
        $setCookie = false;
        if ($visitor === null) {
            if ($reaction === null) {
                // Quitar sin cookie: no hay nada que quitar ni motivo para crear la cookie.
                return $this->respond($request, $postId, null, $wantsJson);
            }
            $visitor = Reactions::newVisitorId();
            $setCookie = true;
        }
        $hash = Reactions::visitorHash($visitor);
        Reactions::set($postId, $hash, $reaction);

        $response = $this->respond($request, $postId, $hash, $wantsJson);
        if ($setCookie) {
            $response->headers['Set-Cookie'][] = Reactions::cookieHeader($visitor, $request);
        }
        return $response;
    }

    private function respond(Request $request, int $postId, ?string $hash, bool $wantsJson): Response
    {
        if ($wantsJson) {
            return Response::json(['ok' => true] + $this->payload($postId, $hash));
        }
        $post = Post::find($postId);
        return $this->redirect($this->back($request, $post ? post_path($post) : '/') . '#reacciones');
    }

    private function payload(int $postId, ?string $hash): array
    {
        $summary = Reactions::summary($postId);
        return [
            'post' => $postId,
            'total' => $summary['total'],
            'counts' => $summary['counts'],
            'top' => $summary['top'],
            'mine' => $hash !== null ? Reactions::mine($postId, $hash) : null,
        ];
    }
}
