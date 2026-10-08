<?php

declare(strict_types=1);

use App\Core\DB;

/*
 * Política de privacidad (ES/EN): boletín personalizado por temas con medición de aperturas y clics,
 * herramientas con IA (Google Gemini) y verificación anti-bots (Cloudflare Turnstile).
 * Idempotente: cada cambio se aplica solo si el texto anterior sigue presente; las ediciones hechas
 * en el panel se conservan. Los mismos textos están en 06_pages.php y en/data/pages.php.
 */
return static function (): string {
    $changes = [
        'privacidad' => [
            '<li><strong>Suscripción y lista de espera:</strong> correo electrónico, idioma y el formulario desde el que te suscribiste.</li>'
                => '<li><strong>Suscripción y lista de espera:</strong> correo electrónico, idioma, los temas que elijas (docentes, tecnología e IA, Excel y oficina, Concurso Docente), la página o el formulario desde el que te suscribiste y un código cifrado de tu dirección IP (no la IP) para prevenir abusos.</li>'
                . "\n" . '<li><strong>Boletín:</strong> cada boletín incluye una imagen de 1×1 píxel y enlaces con seguimiento que permiten saber si se abrió y en qué enlaces se hizo clic. Esa información se usa solo para mejorar el contenido y no se comparte.</li>'
                . "\n" . '<li><strong>Herramientas con inteligencia artificial (PIAR con IA y Generador de exámenes con IA):</strong> lo que escribes en ellas se envía a la API de Google Gemini para generar el documento. Te recomiendo usar iniciales y no incluir datos que identifiquen a estudiantes.</li>',
            '<li>Enviarte, solo si te suscribiste y confirmaste, el boletín con nuevos tutoriales, herramientas y productos.</li>'
                => '<li>Enviarte, solo si te suscribiste y confirmaste, el boletín con nuevos tutoriales, herramientas y productos, personalizado según los temas que elegiste, y medir sus aperturas y clics para mejorarlo. Puedes cambiar tus temas, pausar el boletín o darte de baja en cualquier momento con los enlaces del pie de cada correo.</li>',
            'el proveedor de alojamiento web, el servicio de envío de correo, las pasarelas de pago'
                => 'el proveedor de alojamiento web y de envío de correo (Amazon Web Services), el servicio de inteligencia artificial de Google (API de Gemini) para las herramientas PIAR con IA y Generador de exámenes con IA, Cloudflare (verificación anti-bots Turnstile en los formularios), las pasarelas de pago',
            'Última actualización: 5 de octubre de 2026.' => 'Última actualización: 8 de octubre de 2026.',
        ],
        'privacy' => [
            '<li><strong>Newsletter and waiting list:</strong> email address, language and the form you subscribed from.</li>'
                => '<li><strong>Newsletter and waiting list:</strong> email address, language, the topics you choose (teachers, technology and AI, Excel and office work, Concurso Docente), the page or form you subscribed from and an encrypted code of your IP address (not the IP itself) to prevent abuse.</li>'
                . "\n" . '<li><strong>Newsletter:</strong> each issue includes a 1×1 pixel image and tracked links that show whether it was opened and which links were clicked. This information is used only to improve the content and is not shared.</li>'
                . "\n" . '<li><strong>AI tools (PIAR con IA and the AI Exam Generator):</strong> what you type in them is sent to the Google Gemini API to generate the document. I recommend using initials and not including data that identifies students.</li>',
            '<li>Sending you the newsletter with new tutorials, tools and products, only if you subscribed and confirmed.</li>'
                => '<li>Sending you the newsletter with new tutorials, tools and products, only if you subscribed and confirmed, personalized to the topics you chose, and measuring opens and clicks to improve it. You can change your topics, pause the newsletter or unsubscribe at any time with the links at the bottom of every email.</li>',
            'the web hosting provider, the email delivery service, the payment gateways'
                => 'the web hosting and email delivery provider (Amazon Web Services), Google’s artificial intelligence service (Gemini API) for the PIAR con IA and AI Exam Generator tools, Cloudflare (Turnstile anti-bot check on forms), the payment gateways',
            'Last updated: October 5, 2026.' => 'Last updated: October 8, 2026.',
        ],
    ];
    $applied = 0;
    foreach ($changes as $slug => $pairs) {
        $post = DB::one('SELECT id, content_html FROM posts WHERE type = "policy" AND slug = :s', ['s' => $slug]);
        if ($post === null) {
            continue;
        }
        $html = (string) $post['content_html'];
        foreach ($pairs as $old => $new) {
            if (str_contains($html, $old)) {
                $html = str_replace($old, $new, $html);
                $applied++;
            }
        }
        if ($html !== $post['content_html']) {
            DB::update('posts', [
                'content_html' => $html,
                'content_text' => \App\Services\Importer\HtmlCleaner::toText($html),
                'updated_at' => gmdate('Y-m-d H:i:s'),
            ], ['id' => (int) $post['id']]);
        }
    }
    return "$applied cambio(s) en la política de privacidad";
};
