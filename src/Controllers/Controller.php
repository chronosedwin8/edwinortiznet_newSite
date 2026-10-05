<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\HttpException;
use App\Core\Request;
use App\Core\Response;
use App\Core\View;
use App\Services\Content\AntiSpam;
use App\Services\I18n\I18n;
use App\Services\Seo\Meta;

abstract class Controller
{
    /**
     * Renderiza una página pública. $meta se completa con valores por defecto (canonical, hreflang, OG…).
     */
    protected function page(string $template, array $data, array $meta): Response
    {
        $meta = Meta::complete($meta);
        View::share('meta', $meta);
        $html = View::page($template, $data, $meta);
        return Response::html($html)->header('Content-Language', I18n::meta('html'));
    }

    protected function notFound(): never
    {
        throw HttpException::notFound();
    }

    protected function redirect(string $url, int $status = 303): Response
    {
        return Response::redirect($url, $status);
    }

    protected function requireCsrf(Request $request): void
    {
        if (!Csrf::check($request)) {
            throw new HttpException(419, 'CSRF');
        }
    }

    /** CSRF + honeypot + tiempo mínimo para formularios públicos. */
    protected function requireHuman(Request $request): void
    {
        $this->requireCsrf($request);
        if (!AntiSpam::passes($request)) {
            throw new HttpException(422, 'spam');
        }
    }

    protected function back(Request $request, string $fallback): string
    {
        $ref = (string) $request->header('Referer');
        $host = parse_url(\App\Core\Config::appUrl(), PHP_URL_HOST);
        if ($ref !== '' && parse_url($ref, PHP_URL_HOST) === $host) {
            return (string) preg_replace('#[?#].*$#', '', $ref);
        }
        return $fallback;
    }
}
