<?php

declare(strict_types=1);

namespace App\Admin;

use App\Core\Csrf;
use App\Core\DB;
use App\Core\HttpException;
use App\Core\Logger;
use App\Core\RateLimiter;
use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Services\I18n\I18n;

/**
 * Acceso al panel: Argon2id, límite de intentos por IP y bloqueo por cuenta (5 fallos → 15 minutos).
 */
final class AuthController extends AdminBase
{
    private const MAX_FAILS = 5;
    private const LOCK_MINUTES = 15;

    public function form(Request $request, ?string $error = null): Response
    {
        I18n::setLocale('es');
        Session::start($request);
        if (is_int(Session::get('admin_id'))) {
            return Response::redirect('/admin/', 303);
        }
        $html = View::page('admin/login', ['error' => $error], [], 'admin/layout-bare');
        $response = Response::html($html, $error ? 401 : 200)->header('Cache-Control', 'private, no-store')->header('X-Robots-Tag', 'noindex, nofollow');
        return $response;
    }

    public function login(Request $request): Response
    {
        I18n::setLocale('es');
        Session::start($request);
        if (!Csrf::check($request)) {
            throw new HttpException(419);
        }
        if (!RateLimiter::hit('admin-login', $request->ip(), 10, 900)) {
            return $this->form($request, t('admin.login.rate'));
        }
        $email = strtolower(trim((string) ($request->post['email'] ?? '')));
        $password = (string) ($request->post['password'] ?? '');
        $user = DB::one('SELECT * FROM admin_users WHERE email = :e', ['e' => $email]);
        if ($user !== null && $user['locked_until'] !== null && strtotime($user['locked_until'] . ' UTC') > time()) {
            return $this->form($request, t('admin.login.locked'));
        }
        if ($user === null || !password_verify($password, (string) $user['password_hash'])) {
            if ($user !== null) {
                $fails = (int) $user['failed_attempts'] + 1;
                DB::update('admin_users', [
                    'failed_attempts' => $fails >= self::MAX_FAILS ? 0 : $fails,
                    'locked_until' => $fails >= self::MAX_FAILS ? gmdate('Y-m-d H:i:s', time() + self::LOCK_MINUTES * 60) : null,
                ], ['id' => (int) $user['id']]);
            }
            Logger::warning('Acceso fallido al panel', ['ip' => $request->ip()]);
            return $this->form($request, t('admin.login.invalid'));
        }
        if (password_needs_rehash((string) $user['password_hash'], PASSWORD_ARGON2ID)) {
            DB::update('admin_users', ['password_hash' => password_hash($password, PASSWORD_ARGON2ID)], ['id' => (int) $user['id']]);
        }
        DB::update('admin_users', ['failed_attempts' => 0, 'locked_until' => null, 'last_login_at' => DB::now()], ['id' => (int) $user['id']]);
        Session::regenerate();
        Session::set('admin_id', (int) $user['id']);
        return Response::redirect('/admin/', 303);
    }

    public function logout(Request $request): Response
    {
        $this->requireAdmin($request);
        Session::forget('admin_id');
        Session::regenerate();
        return Response::redirect('/admin/acceso/', 303);
    }
}
