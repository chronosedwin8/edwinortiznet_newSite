<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\DB;
use App\Core\RateLimiter;
use App\Core\Request;
use App\Core\Response;
use App\Services\Downloads\DownloadService;
use App\Services\I18n\I18n;

final class DownloadController extends Controller
{
    public function download(Request $request, string $token): Response
    {
        if (!RateLimiter::hit('download', $request->ip(), 60, 3600)) {
            return (new ErrorController())->error($request, 429);
        }
        // El idioma de los mensajes es el del pedido.
        $locale = DB::value(
            'SELECT o.locale FROM download_grants g JOIN order_items oi ON oi.id = g.order_item_id JOIN orders o ON o.id = oi.order_id WHERE g.token = :t',
            ['t' => $token]
        );
        I18n::setLocale(is_string($locale) ? $locale : 'es');
        $result = DownloadService::serve($token, $request);
        if ($result instanceof Response) {
            return $result;
        }
        if ($result === null) {
            $this->notFound();
        }
        $response = $this->page('pages/message', [
            'title' => t('download.title'),
            'text' => t($result),
            'actionUrl' => route('account'),
            'actionLabel' => t('nav.account'),
        ], ['title' => t('download.title'), 'noindex' => true]);
        $response->status = 410;
        return $response;
    }
}
