<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\DB;
use App\Core\Mailer;
use App\Core\RateLimiter;
use App\Core\Request;
use App\Core\Response;
use App\Models\Hub;
use App\Models\Product;
use App\Services\I18n\I18n;
use App\Services\Mail\MailTemplates;
use App\Services\Seo\Meta;
use App\Services\Subscribers;
use App\Services\Tools\ToolRegistry;

/**
 * Herramientas gratuitas: funcionan en el navegador, sin enviar datos al servidor.
 */
final class ToolsController extends Controller
{
    public function index(Request $request): Response
    {
        $locale = I18n::locale();
        $hub = Hub::byKey('herramientas', $locale);
        $faqs = $hub ? Hub::faqs($hub) : [];
        $crumbs = [[t('nav.home'), route('home')], [t('nav.tools'), route('tools')]];
        return $this->page('pages/tools', [
            'hub' => $hub,
            'tools' => ToolRegistry::forLocale($locale),
            'faqs' => $faqs,
            'crumbs' => $crumbs,
        ], [
            'title' => $hub['seo_title'] ?? t('tools.title'),
            'title_full' => !empty($hub['seo_title']),
            'description' => $hub['seo_description'] ?? t('tools.lead'),
            'alternates' => ['es' => route('tools', [], 'es'), 'en' => route('tools', [], 'en')],
            'breadcrumbs' => $crumbs,
            'jsonld' => [Meta::faqPage($faqs)],
            'body_class' => 'page-tools',
        ]);
    }

    public function show(Request $request, string $slug): Response
    {
        $locale = I18n::locale();
        $tool = ToolRegistry::bySlug($locale, $slug);
        if ($tool === null) {
            $this->notFound();
        }
        $key = $tool['key'];
        $product = null;
        if (!empty($tool['product_wp_id'])) {
            $product = Product::byWpId((int) $tool['product_wp_id'], $locale);
        } elseif (!empty($tool['product_key'])) {
            $id = DB::value('SELECT id FROM products WHERE sku = :s', ['s' => 'EO-KIT-CONC27']);
            $product = $id !== null ? Product::find((int) $id, $locale) : null;
        }
        $faqs = [];
        for ($i = 1; I18n::has("tool.$key.faq{$i}_q"); $i++) {
            $faqs[] = ['q' => t("tool.$key.faq{$i}_q"), 'a' => t("tool.$key.faq{$i}_a")];
        }
        $questions = [];
        if ($key === 'quiz') {
            foreach (DB::all('SELECT id, area, question, options_json, correct_index, explanation, is_demo FROM quiz_questions WHERE active = 1 ORDER BY id') as $q) {
                $questions[] = [
                    'id' => (int) $q['id'],
                    'area' => $q['area'],
                    'q' => $q['question'],
                    'o' => json_decode($q['options_json'], true) ?: [],
                    'c' => (int) $q['correct_index'],
                    'e' => (string) $q['explanation'],
                    'demo' => (bool) $q['is_demo'],
                ];
            }
        }
        $path = route('tool', ['slug' => $slug]);
        $crumbs = [[t('nav.home'), route('home')], [t('nav.tools'), route('tools')], [t("tool.$key.name"), $path]];
        return $this->page('pages/tool', [
            'tool' => $tool,
            'key' => $key,
            'product' => $product,
            'faqs' => $faqs,
            'questions' => $questions,
            'crumbs' => $crumbs,
            'sent' => isset($request->query['enviado']),
        ], [
            'title' => t("tool.$key.seo_title"),
            'title_full' => true,
            'description' => t("tool.$key.seo_description"),
            'alternates' => ToolRegistry::alternates($key),
            'breadcrumbs' => $crumbs,
            'scripts' => [$tool['script']],
            'jsonld' => [[
                '@context' => 'https://schema.org',
                '@type' => 'WebApplication',
                'name' => t("tool.$key.name"),
                'url' => url($path),
                'applicationCategory' => 'UtilitiesApplication',
                'operatingSystem' => 'Any',
                'browserRequirements' => 'Requires JavaScript',
                'inLanguage' => I18n::meta('html'),
                'offers' => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => I18n::currency()],
            ], Meta::faqPage($faqs)],
            'body_class' => 'page-tool page-tool--' . $key,
        ]);
    }

    /** Resultado del simulacro por correo + suscripción con etiqueta "concurso" (doble opt-in). */
    public function quizResult(Request $request): Response
    {
        $this->requireHuman($request);
        $back = route('tool', ['slug' => 'simulacro-concurso-docente']);
        if (!RateLimiter::hit('quiz-mail', $request->ip(), 5, 3600)) {
            return $request->wantsJson() ? Response::json(['ok' => false, 'message' => t('form.rate_limited')], 429) : $this->redirect($back);
        }
        $email = strtolower($request->str('email'));
        $total = max(1, min(50, (int) $request->input('total', 10)));
        $score = max(0, min($total, (int) $request->input('score', 0)));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $request->wantsJson() ? Response::json(['ok' => false, 'message' => t('form.invalid_email')], 422) : $this->redirect($back);
        }
        $subscriber = Subscribers::add($email, 'es', 'simulacro', 'concurso');
        $mail = MailTemplates::render('quiz-result', 'es', [
            'score' => $score,
            'total' => $total,
            'percent' => (int) round($score * 100 / $total),
            'confirmUrl' => $subscriber['confirmed_at'] ? null : url(route('subscribe.confirm', ['token' => $subscriber['token']], 'es')),
            'unsubscribeUrl' => url(route('subscribe.unsubscribe', ['token' => $subscriber['token']], 'es')),
            'toolUrl' => url($back),
        ]);
        Mailer::send($email, $mail['subject'], $mail['html'], $mail['text']);
        if ($request->wantsJson()) {
            return Response::json(['ok' => true, 'message' => t('quiz.sent')]);
        }
        return $this->redirect($back . '?enviado=1');
    }
}
