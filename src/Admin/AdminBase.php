<?php

declare(strict_types=1);

namespace App\Admin;

use App\Core\Cache;
use App\Core\Csrf;
use App\Core\DB;
use App\Core\HttpException;
use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Services\I18n\I18n;

/**
 * Base de los controladores del panel: sesión obligatoria, CSRF en cada POST y caché invalidada al guardar.
 */
abstract class AdminBase
{
    protected ?array $admin = null;

    protected function requireAdmin(Request $request): array
    {
        I18n::setLocale('es');
        Session::start($request);
        $id = Session::get('admin_id');
        $admin = is_int($id) ? DB::one('SELECT id, email, name FROM admin_users WHERE id = :id', ['id' => $id]) : null;
        if ($admin === null) {
            throw new AdminRedirect('/admin/acceso/');
        }
        if ($request->isPost() && !Csrf::check($request)) {
            throw new HttpException(419);
        }
        return $this->admin = $admin;
    }

    protected function view(string $template, array $data = [], string $title = ''): Response
    {
        $data['admin'] = $this->admin;
        $data['flash'] = Session::flash('admin');
        $data['title'] = $title;
        $html = View::page('admin/' . $template, $data, [], 'admin/layout');
        return Response::html($html)
            ->header('Cache-Control', 'private, no-store')
            ->header('X-Robots-Tag', 'noindex, nofollow');
    }

    protected function back(string $url, ?string $message = null): Response
    {
        if ($message !== null) {
            Session::flash('admin', $message);
        }
        return Response::redirect($url, 303);
    }

    /** Toda escritura del panel invalida la caché de página y el sitemap. */
    protected function saved(): void
    {
        Cache::flushPages();
        \App\Services\Seo\Redirects::clear();
        \App\Models\Setting::clear();
    }

    protected static function str(Request $request, string $key, int $max = 65535): ?string
    {
        $value = $request->post[$key] ?? null;
        if (!is_string($value)) {
            return null;
        }
        $value = trim(str_replace("\r\n", "\n", $value));
        return $value === '' ? null : mb_substr($value, 0, $max);
    }
}
