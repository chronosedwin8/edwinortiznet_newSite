<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Config;
use App\Core\Request;
use App\Core\Response;
use App\Services\Newsletter\Tracking;

/**
 * Seguimiento del boletín: píxel de apertura (/n/o/{envío}/{firma}/) y clics (/n/c/{envío}/{firma}/?u=destino).
 */
final class NewsletterController extends Controller
{
    public function open(Request $request, string $id, string $token): Response
    {
        if (Tracking::verify('o', (int) $id, $token) && $request->method === 'GET') {
            try {
                Tracking::recordOpen((int) $id);
            } catch (\Throwable) {
                // El píxel nunca falla para el lector.
            }
        }
        return (new Response(Tracking::GIF, 200, ['Content-Type' => 'image/gif']))
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('X-Robots-Tag', 'noindex');
    }

    public function click(Request $request, string $id, string $token): Response
    {
        $target = is_string($request->query['u'] ?? null) ? (string) $request->query['u'] : '';
        if ($target === '' || !preg_match('#^https?://#i', $target) || preg_match('/[\r\n]/', $target)) {
            $this->notFound();
        }
        if (Tracking::verify('c', (int) $id, $token, $target)) {
            if ($request->method === 'GET') {
                try {
                    Tracking::recordClick((int) $id, $target);
                } catch (\Throwable) {
                }
            }
        } elseif ((string) parse_url($target, PHP_URL_HOST) !== (string) parse_url(Config::appUrl(), PHP_URL_HOST)) {
            // Firma inválida: solo se sigue hacia el propio sitio (nunca una redirección abierta).
            $this->notFound();
        }
        return Response::redirect($target, 302)->header('Cache-Control', 'no-store')->header('X-Robots-Tag', 'noindex');
    }
}
