<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\DB;
use App\Core\Mailer;
use App\Core\RateLimiter;
use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Services\Downloads\DownloadService;
use App\Services\I18n\I18n;
use App\Services\Mail\MailTemplates;

/**
 * Mi cuenta: acceso por enlace mágico (un solo uso, 15 minutos). Lista pedidos y regenera descargas.
 */
final class AccountController extends Controller
{
    private function customerId(Request $request): ?int
    {
        Session::start($request);
        $id = Session::get('customer_id');
        return is_int($id) ? $id : null;
    }

    public function index(Request $request): Response
    {
        $customerId = $this->customerId($request);
        $customer = $customerId ? DB::one('SELECT * FROM customers WHERE id = :id', ['id' => $customerId]) : null;
        $orders = $customer ? DB::all(
            'SELECT * FROM orders WHERE email = :e AND locale = :l ORDER BY created_at DESC LIMIT 100',
            ['e' => $customer['email'], 'l' => I18n::locale()]
        ) : [];
        foreach ($orders as &$order) {
            $order['downloads'] = $order['status'] === 'approved' ? DownloadService::forOrder((int) $order['id']) : [];
        }
        unset($order);
        $crumbs = [[t('nav.home'), route('home')], [t('account.title'), route('account')]];
        return $this->page('pages/account', [
            'customer' => $customer,
            'orders' => $orders,
            'notice' => Session::flash('account'),
            'crumbs' => $crumbs,
        ], [
            'title' => t('account.seo_title'),
            'noindex' => true,
            'alternates' => ['es' => route('account', [], 'es'), 'en' => route('account', [], 'en')],
            'breadcrumbs' => $crumbs,
            'body_class' => 'page-account',
        ])->header('Cache-Control', 'private, no-store');
    }

    public function requestLink(Request $request): Response
    {
        $this->requireCsrf($request);
        Session::start($request);
        $email = strtolower($request->str('email'));
        if (!RateLimiter::hit('magic-link', $request->ip(), 6, 3600)) {
            Session::flash('account', t('form.rate_limited'));
            return $this->redirect(route('account'));
        }
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $customer = DB::one('SELECT * FROM customers WHERE email = :e', ['e' => $email]);
            if ($customer !== null) {
                $token = bin2hex(random_bytes(32));
                DB::insert('login_tokens', [
                    'customer_id' => (int) $customer['id'],
                    'token_hash' => hash('sha256', $token),
                    'expires_at' => gmdate('Y-m-d H:i:s', time() + 900),
                ]);
                $mail = MailTemplates::render('login-link', I18n::locale(), ['loginUrl' => url(route('account.login', ['token' => $token]))]);
                Mailer::send($email, $mail['subject'], $mail['html'], $mail['text']);
            }
        }
        // Mismo mensaje exista o no el correo (no se revela quién compró).
        Session::flash('account', t('account.link_sent'));
        return $this->redirect(route('account'));
    }

    public function login(Request $request, string $token): Response
    {
        Session::start($request);
        $row = DB::one(
            'SELECT * FROM login_tokens WHERE token_hash = :h AND used_at IS NULL AND expires_at > UTC_TIMESTAMP()',
            ['h' => hash('sha256', $token)]
        );
        if ($row === null) {
            Session::flash('account', t('account.link_invalid'));
            return $this->redirect(route('account'));
        }
        DB::run('UPDATE login_tokens SET used_at = UTC_TIMESTAMP() WHERE id = :id', ['id' => (int) $row['id']]);
        Session::regenerate();
        Session::set('customer_id', (int) $row['customer_id']);
        return $this->redirect(route('account'));
    }

    public function logout(Request $request): Response
    {
        $this->requireCsrf($request);
        Session::start($request);
        Session::forget('customer_id');
        Session::regenerate();
        return $this->redirect(route('account'));
    }

    public function regenerate(Request $request, string $id): Response
    {
        $this->requireCsrf($request);
        $customerId = $this->customerId($request);
        if ($customerId === null) {
            return $this->redirect(route('account'));
        }
        $order = DB::one(
            'SELECT o.* FROM orders o JOIN customers c ON c.email = o.email WHERE o.id = :o AND c.id = :c AND o.status = "approved"',
            ['o' => (int) $id, 'c' => $customerId]
        );
        if ($order !== null) {
            DownloadService::createGrants((int) $order['id'], true);
            Session::flash('account', t('account.regenerated'));
        }
        return $this->redirect(route('account'));
    }
}
