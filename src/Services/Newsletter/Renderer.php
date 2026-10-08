<?php

declare(strict_types=1);

namespace App\Services\Newsletter;

use App\Core\Config;

/**
 * Correo del boletín (HTML con tablas para Gmail/Outlook, modo oscuro, versión de texto) y sus cabeceras
 * List-Unsubscribe / List-Unsubscribe-Post (reglas de Gmail y Yahoo para envíos masivos).
 */
final class Renderer
{
    private const STRINGS = [
        'es' => [
            'kicker' => 'Boletín de edwinortiz.net',
            'hello' => 'Hola:',
            'sign' => 'Edwin',
            'blog_title' => 'Lo nuevo en el blog',
            'blog_title_recent' => 'Lo más reciente del blog',
            'read' => 'Leer el artículo',
            'read_short' => 'Leer',
            'minutes' => ':n min de lectura',
            'shop_title' => 'De la tienda',
            'shop_lead' => 'Plantillas y herramientas que te pueden ahorrar horas de trabajo.',
            'free' => 'Gratis',
            'see_product' => 'Ver detalles',
            'try_free' => 'Probar gratis',
            'closing' => 'Gracias por leerme. Cuando quieras, date una vuelta: en la tienda hay plantillas de Excel y recursos para docentes listos para usar, en el blog encuentras todas las guías, y las herramientas gratis te resuelven tareas en segundos.',
            'btn_shop' => 'Ir a la tienda',
            'btn_blog' => 'Leer el blog',
            'btn_tools' => 'Herramientas gratis',
            'bye' => 'Un abrazo,',
            'why' => 'Recibes este correo porque te suscribiste al boletín de edwinortiz.net:source.',
            'why_source' => ' desde «:title»',
            'topics' => 'Tus temas: :list.',
            'topics_all' => 'Tus temas: de todo un poco.',
            'prefs' => 'Cambiar temas o pausar',
            'unsubscribe' => 'Darme de baja',
            'test_note' => 'Correo de prueba: los enlaces de preferencias y baja funcionan solo en los envíos reales.',
            'interest' => ['docentes' => 'Docentes', 'tecnologia' => 'Tecnología e IA', 'excel' => 'Excel y oficina', 'concurso' => 'Concurso Docente'],
        ],
        'en' => [
            'kicker' => 'edwinortiz.net newsletter',
            'hello' => 'Hi there,',
            'sign' => 'Edwin',
            'blog_title' => 'New on the blog',
            'blog_title_recent' => 'Latest from the blog',
            'read' => 'Read the article',
            'read_short' => 'Read',
            'minutes' => ':n min read',
            'shop_title' => 'From the shop',
            'shop_lead' => 'Templates and tools that can save you hours of work.',
            'free' => 'Free',
            'see_product' => 'See details',
            'try_free' => 'Try it free',
            'closing' => 'Thanks for reading. Whenever you like, drop by: the shop has ready-to-use Excel templates, the blog has every guide, and the free tools solve everyday tasks in seconds.',
            'btn_shop' => 'Visit the shop',
            'btn_blog' => 'Read the blog',
            'btn_tools' => 'Free tools',
            'bye' => 'Best,',
            'why' => 'You’re getting this email because you subscribed to the edwinortiz.net newsletter:source.',
            'why_source' => ' from “:title”',
            'topics' => 'Your topics: :list.',
            'topics_all' => 'Your topics: a bit of everything.',
            'prefs' => 'Change topics or pause',
            'unsubscribe' => 'Unsubscribe',
            'test_note' => 'Test email: the preferences and unsubscribe links only work in real sends.',
            'interest' => ['docentes' => 'Teaching', 'tecnologia' => 'Technology & AI', 'excel' => 'Excel & office', 'concurso' => 'Teacher exam'],
        ],
    ];

    public static function strings(string $locale): array
    {
        return self::STRINGS[$locale === 'en' ? 'en' : 'es'];
    }

    /**
     * @param array $personal resultado de Builder::personalize()
     * @param array|null $subscriber fila de subscribers (null en pruebas y vistas previas)
     * @param string|null $banner aviso arriba del correo (vista previa para el administrador)
     * @return array{subject:string, html:string, text:string, headers:array<string,string>}
     */
    public static function render(array $issue, array $personal, ?array $subscriber = null, ?int $sendId = null, ?string $banner = null): array
    {
        $locale = $personal['locale'] ?? 'es';
        $s = self::strings($locale);
        $campaign = (string) $issue['issue_key'];
        $link = static function (string $url, ?string $content = null) use ($campaign, $sendId): string {
            $target = Tracking::utm($url, $campaign, $content);
            return $sendId !== null ? Tracking::clickUrl($sendId, $target) : $target;
        };
        $posts = [];
        foreach ($personal['posts'] as $i => $p) {
            $posts[] = $p + ['href' => $link($p['url'], 'articulo-' . ($i + 1))];
        }
        $offers = [];
        foreach ($personal['offers'] as $i => $o) {
            $offers[] = $o + ['href' => $link($o['url'], ($o['kind'] === 'tool' ? 'herramienta-' : 'producto-') . ($i + 1))];
        }
        $home = $locale === 'en' ? '/en/' : '/';
        $buttons = [
            ['label' => $s['btn_shop'], 'href' => $link(url(route('shop', [], $locale)), 'tienda'), 'primary' => true],
            ['label' => $s['btn_blog'], 'href' => $link(url(route('blog', [], $locale)), 'blog'), 'primary' => false],
            ['label' => $s['btn_tools'], 'href' => $link(url(route('tools', [], $locale)), 'herramientas'), 'primary' => false],
        ];
        $prefsUrl = $unsubUrl = null;
        $interests = $subscriber !== null ? Interests::fromSet($subscriber['interests'] ?? '') : [];
        if ($subscriber !== null) {
            $prefsUrl = url(route('subscribe.preferences', ['token' => $subscriber['token']], $subscriber['locale'] === 'en' ? 'en' : 'es'));
            $unsubUrl = url(route('subscribe.unsubscribe', ['token' => $subscriber['token']], $subscriber['locale'] === 'en' ? 'en' : 'es'))
                . ($sendId !== null ? '?n=' . $sendId : '');
        }
        $source = '';
        if ($subscriber !== null && !empty($subscriber['source_title'])) {
            $source = strtr($s['why_source'], [':title' => excerpt_text((string) $subscriber['source_title'], 70)]);
        }
        $topics = $interests === [] ? $s['topics_all'] : strtr($s['topics'], [':list' => implode(', ', array_map(fn ($i) => $s['interest'][$i], $interests))]);
        $settings = NewsletterSettings::all();
        $data = [
            's' => $s,
            'locale' => $locale,
            'subject' => $personal['subject'],
            'preheader' => $personal['preheader'],
            'intro' => $personal['intro'],
            'date' => self::longDate((string) ($issue['scheduled_for'] ?? gmdate('Y-m-d H:i:s')), $locale),
            'posts' => $posts,
            'anyNew' => array_filter($posts, fn ($p) => $p['new']) !== [],
            'offers' => $offers,
            'buttons' => $buttons,
            'homeUrl' => $link(url($home), 'logo'),
            'prefsUrl' => $prefsUrl,
            'unsubUrl' => $unsubUrl,
            'why' => strtr($s['why'], [':source' => $source]),
            'topics' => $subscriber !== null ? $topics : null,
            'address' => $settings['address'],
            'contact' => (string) Config::get('MAIL_FROM_ADDRESS', 'hola@edwinortiz.net'),
            'pixel' => $sendId !== null ? Tracking::openUrl($sendId) : null,
            'banner' => $banner,
            'testNote' => $subscriber === null && $banner === null ? $s['test_note'] : null,
        ];
        $html = (static function (string $__file, array $__data): string {
            extract($__data, EXTR_SKIP);
            ob_start();
            include $__file;
            return (string) ob_get_clean();
        })(Config::root('templates/emails/newsletter.php'), $data);

        $headers = [];
        if ($unsubUrl !== null) {
            $mailto = 'mailto:' . (string) Config::get('NEWSLETTER_UNSUBSCRIBE_MAILTO', Config::get('MAIL_FROM_ADDRESS', 'hola@edwinortiz.net'))
                . '?subject=' . rawurlencode('Baja boletin ' . (string) $subscriber['email']);
            $headers['List-Unsubscribe'] = '<' . $unsubUrl . '>, <' . $mailto . '>';
            $headers['List-Unsubscribe-Post'] = 'List-Unsubscribe=One-Click';
        }
        $headers['List-Id'] = 'Boletin edwinortiz.net <boletin.edwinortiz.net>';
        $headers['Feedback-ID'] = preg_replace('/[^a-z0-9\-]/', '', $campaign) . ':boletin:edwinortiz';

        return ['subject' => $personal['subject'], 'html' => $html, 'text' => self::text($data), 'headers' => $headers];
    }

    private static function text(array $d): string
    {
        $s = $d['s'];
        $out = [];
        if ($d['banner']) {
            $out[] = strip_tags((string) $d['banner']);
            $out[] = str_repeat('=', 40);
        }
        $out[] = $s['kicker'] . ' — ' . $d['date'];
        $out[] = '';
        $out[] = $s['hello'];
        $out[] = $d['intro'];
        $out[] = '';
        $out[] = mb_strtoupper($d['anyNew'] ? $s['blog_title'] : $s['blog_title_recent']);
        foreach ($d['posts'] as $p) {
            $out[] = '';
            $out[] = '• ' . $p['title'];
            $out[] = '  ' . $p['summary'];
            $out[] = '  ' . $p['href'];
        }
        if ($d['offers']) {
            $out[] = '';
            $out[] = mb_strtoupper($s['shop_title']);
            foreach ($d['offers'] as $o) {
                $out[] = '';
                $out[] = '• ' . $o['title'] . ' (' . ($o['price'] ?? $s['free']) . ')';
                $out[] = '  ' . $o['summary'];
                $out[] = '  ' . $o['href'];
            }
        }
        $out[] = '';
        $out[] = $s['closing'];
        foreach ($d['buttons'] as $b) {
            $out[] = $b['label'] . ': ' . $b['href'];
        }
        $out[] = '';
        $out[] = $s['bye'];
        $out[] = $s['sign'];
        $out[] = '';
        $out[] = '—';
        $out[] = $d['why'];
        if ($d['topics']) {
            $out[] = $d['topics'];
        }
        if ($d['prefsUrl']) {
            $out[] = $s['prefs'] . ': ' . $d['prefsUrl'];
            $out[] = $s['unsubscribe'] . ': ' . $d['unsubUrl'];
        }
        $out[] = 'Edwin Ortiz Herazo · edwinortiz.net · ' . $d['address'] . ' · ' . $d['contact'];
        return implode("\n", $out);
    }

    public static function longDate(string $utc, string $locale): string
    {
        $d = (new \DateTimeImmutable($utc, new \DateTimeZone('UTC')))->setTimezone(new \DateTimeZone(NewsletterSettings::TZ));
        if (class_exists(\IntlDateFormatter::class)) {
            $f = new \IntlDateFormatter($locale === 'en' ? 'en_US' : 'es_CO', \IntlDateFormatter::LONG, \IntlDateFormatter::NONE, NewsletterSettings::TZ);
            return (string) $f->format($d);
        }
        return $d->format('Y-m-d');
    }
}
