<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Config;
use App\Core\DB;
use App\Core\Mailer;
use App\Core\RateLimiter;
use App\Core\Request;
use App\Core\Response;
use App\Models\Post;
use App\Services\Content\ContentRenderer;
use App\Services\I18n\I18n;
use App\Services\Mail\MailTemplates;
use App\Services\Seo\Meta;

/**
 * Institucionales: sobre mí, contacto y políticas.
 */
final class PageController extends Controller
{
    public function about(Request $request): Response
    {
        $locale = I18n::locale();
        $post = Post::findVisible($locale, $locale === 'es' ? 'sobre-mi' : 'about', ['page']);
        if ($post === null) {
            $this->notFound();
        }
        $path = route('about');
        $crumbs = [[t('nav.home'), route('home')], [$post['title'], $path]];
        $alternates = [];
        foreach (Post::alternates($post) as $lang => $_) {
            $alternates[$lang] = route('about', [], $lang);
        }
        return $this->page('pages/about', [
            'post' => $post,
            'html' => ContentRenderer::render($post)['html'],
            'crumbs' => $crumbs,
        ], [
            'title' => $post['seo_title'] ?: $post['title'],
            'title_full' => (bool) $post['seo_title'],
            'description' => $post['seo_description'] ?: $post['excerpt'],
            'canonical' => $path,
            'alternates' => $alternates,
            'breadcrumbs' => $crumbs,
            'og_type' => 'profile',
            'jsonld' => [['@context' => 'https://schema.org', '@type' => 'ProfilePage', 'mainEntity' => Meta::person(), 'inLanguage' => I18n::meta('html')]],
            'body_class' => 'page-about',
        ]);
    }

    public function policy(Request $request, string $slug): Response
    {
        $locale = I18n::locale();
        $post = Post::findVisible($locale, $slug, ['policy']);
        if ($post === null) {
            $this->notFound();
        }
        $path = route('policy', ['slug' => $slug]);
        $crumbs = [[t('nav.home'), route('home')], [$post['title'], $path]];
        return $this->page('pages/page', [
            'post' => $post,
            'html' => $post['content_html'],
            'crumbs' => $crumbs,
        ], [
            'title' => $post['seo_title'] ?: $post['title'],
            'description' => $post['seo_description'] ?: $post['excerpt'],
            'alternates' => Post::alternates($post),
            'breadcrumbs' => $crumbs,
            'body_class' => 'page-policy',
        ]);
    }

    public function contact(Request $request): Response
    {
        $crumbs = [[t('nav.home'), route('home')], [t('contact.title'), route('contact')]];
        return $this->page('pages/contact', [
            'crumbs' => $crumbs,
            'sent' => isset($request->query['enviado']),
            'error' => $request->query['error'] ?? null,
            'whatsapp' => (string) Config::get('WHATSAPP_NUMBER', '573162830615'),
        ], [
            'title' => t('contact.seo_title'),
            'description' => t('contact.seo_description'),
            'alternates' => ['es' => route('contact', [], 'es'), 'en' => route('contact', [], 'en')],
            'breadcrumbs' => $crumbs,
            'body_class' => 'page-contact',
        ]);
    }

    public function sendContact(Request $request): Response
    {
        $this->requireHuman($request);
        $locale = I18n::locale();
        if (!RateLimiter::hit('contact', $request->ip(), 5, 3600)) {
            return $this->redirect(route('contact', ['error' => 'rate']));
        }
        $name = mb_substr($request->str('name'), 0, 190);
        $email = strtolower(mb_substr($request->str('email'), 0, 190));
        $subject = mb_substr($request->str('subject'), 0, 190);
        $message = mb_substr($request->str('message'), 0, 5000);
        if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($message) < 10) {
            return $this->redirect(route('contact', ['error' => 'invalid']));
        }
        DB::insert('contact_messages', [
            'name' => $name, 'email' => $email, 'subject' => $subject ?: null, 'message' => $message,
            'locale' => $locale, 'ip' => $request->ip(),
        ]);
        $mail = MailTemplates::render('admin-contact', 'es', compact('name', 'email', 'subject', 'message', 'locale'));
        Mailer::send((string) Config::get('ADMIN_EMAIL', ''), $mail['subject'], $mail['html'], $mail['text'], $email);
        return $this->redirect(route('contact', ['enviado' => 1]));
    }
}
