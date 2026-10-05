<?php

declare(strict_types=1);

namespace App\Services\Mail;

use App\Core\Config;

/**
 * Correos: templates/emails/{es,en}/{nombre}.php define $subject e imprime el cuerpo HTML.
 * Se envuelven en templates/emails/layout.php y la versión de texto se genera del HTML.
 */
final class MailTemplates
{
    /** @return array{subject:string, html:string, text:string} */
    public static function render(string $name, string $locale, array $data = []): array
    {
        $file = Config::root("templates/emails/$locale/$name.php");
        if (!is_file($file)) {
            $file = Config::root("templates/emails/es/$name.php");
        }
        [$subject, $body] = (static function (string $__file, array $__data): array {
            extract($__data, EXTR_SKIP);
            $subject = '';
            ob_start();
            include $__file;
            return [$subject, (string) ob_get_clean()];
        })($file, $data);
        $html = (static function (string $__file, array $__data): string {
            extract($__data, EXTR_SKIP);
            ob_start();
            include $__file;
            return (string) ob_get_clean();
        })(Config::root('templates/emails/layout.php'), ['subject' => $subject, 'body' => $body, 'locale' => $locale]);
        return ['subject' => $subject, 'html' => $html, 'text' => self::toText($body)];
    }

    public static function toText(string $html): string
    {
        $html = preg_replace('#<a\b[^>]*href="([^"]+)"[^>]*>(.*?)</a>#is', '$2: $1', $html) ?? $html;
        $html = preg_replace('#<(br|/p|/h[1-6]|/li|/tr)\b[^>]*>#i', "\n", $html) ?? $html;
        $html = preg_replace('#<li\b[^>]*>#i', '- ', $html) ?? $html;
        $text = html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = preg_replace("/[ \t]+/", ' ', $text) ?? $text;
        $text = preg_replace("/\n\s*\n\s*\n+/", "\n\n", $text) ?? $text;
        return trim(implode("\n", array_map('trim', explode("\n", $text))));
    }
}
