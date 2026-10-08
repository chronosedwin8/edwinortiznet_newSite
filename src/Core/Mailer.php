<?php

declare(strict_types=1);

namespace App\Core;

use PHPMailer\PHPMailer\PHPMailer;

/**
 * Envío de correo con PHPMailer (SMTP). Con MAIL_DRIVER=log los correos se guardan en storage/logs/mail/.
 *
 * $headers admite cabeceras adicionales (p. ej. List-Unsubscribe del boletín): solo nombres seguros, sin saltos
 * de línea en el valor y nunca las cabeceras que arma PHPMailer (From, To, Subject…).
 * keepAlive(true) reutiliza la conexión SMTP entre envíos (lotes del boletín); close() la cierra.
 */
final class Mailer
{
    /** @var array<int, array> Correos enviados en esta ejecución (útil en pruebas). */
    public static array $sent = [];

    /** Último error de envío (sin datos sensibles). */
    public static ?string $lastError = null;

    private const RESERVED = ['from', 'to', 'cc', 'bcc', 'subject', 'reply-to', 'sender', 'return-path', 'date', 'message-id',
        'mime-version', 'content-type', 'content-transfer-encoding'];

    private static bool $keepAlive = false;
    private static ?PHPMailer $smtp = null;

    public static function keepAlive(bool $on = true): void
    {
        self::$keepAlive = $on;
        if (!$on) {
            self::close();
        }
    }

    public static function close(): void
    {
        if (self::$smtp !== null) {
            try {
                self::$smtp->smtpClose();
            } catch (\Throwable) {
            }
            self::$smtp = null;
        }
    }

    /** @param array<string, string> $headers */
    public static function send(string $to, string $subject, string $html, string $text, ?string $replyTo = null, array $headers = []): bool
    {
        $headers = self::safeHeaders($headers);
        $driver = (string) Config::get('MAIL_DRIVER', 'smtp');
        self::$lastError = null;
        self::$sent[] = compact('to', 'subject', 'html', 'text', 'headers');
        if ($driver === 'log' || $driver === 'array') {
            if ($driver === 'log') {
                $dir = Config::storage('logs/mail');
                if (!is_dir($dir)) {
                    mkdir($dir, 0775, true);
                }
                $name = gmdate('Ymd-His') . '-' . substr(sha1($to . $subject . microtime()), 0, 8);
                $extra = '';
                foreach ($headers as $k => $v) {
                    $extra .= " | $k: " . htmlspecialchars($v);
                }
                file_put_contents("$dir/$name.html", "<!-- To: $to | Subject: " . htmlspecialchars($subject) . "$extra -->\n" . $html);
                file_put_contents("$dir/$name.txt", "To: $to\nSubject: $subject\n" . implode('', array_map(fn ($k, $v) => "$k: $v\n", array_keys($headers), $headers)) . "\n" . $text);
            }
            return true;
        }

        $mail = null;
        try {
            $mail = self::$keepAlive && self::$smtp !== null ? self::$smtp : self::mailer();
            $mail->clearAllRecipients();
            $mail->clearReplyTos();
            $mail->clearCustomHeaders();
            $mail->addAddress($to);
            if ($replyTo !== null) {
                $mail->addReplyTo($replyTo);
            }
            foreach ($headers as $name => $value) {
                $mail->addCustomHeader($name, $value);
            }
            $mail->Subject = $subject;
            $mail->isHTML(true);
            $mail->Body = $html;
            $mail->AltBody = $text;
            $mail->send();
            if (self::$keepAlive) {
                self::$smtp = $mail;
            }
            return true;
        } catch (\Throwable $e) {
            self::$lastError = mb_substr((string) (($mail?->ErrorInfo) ?: $e->getMessage()), 0, 300);
            Logger::error('No se pudo enviar el correo', ['subject' => $subject, 'error' => self::$lastError]);
            if (self::$keepAlive) {
                self::close(); // la siguiente vez abre una conexión nueva
            }
            return false;
        }
    }

    private static function mailer(): PHPMailer
    {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = (string) Config::get('MAIL_HOST');
        $mail->Port = Config::int('MAIL_PORT', 587);
        $mail->SMTPAuth = Config::get('MAIL_USERNAME') !== null;
        $mail->Username = (string) Config::get('MAIL_USERNAME', '');
        $mail->Password = (string) Config::get('MAIL_PASSWORD', '');
        $encryption = (string) Config::get('MAIL_ENCRYPTION', 'tls');
        if ($encryption === 'ssl') {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        } elseif ($encryption === 'tls') {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        }
        $mail->SMTPKeepAlive = self::$keepAlive;
        $mail->CharSet = PHPMailer::CHARSET_UTF8;
        // Sin cabecera X-Mailer: anunciar el programa de envío resta puntos en algunos filtros de spam.
        $mail->XMailer = ' ';
        $mail->setFrom((string) Config::get('MAIL_FROM_ADDRESS'), (string) Config::get('MAIL_FROM_NAME', 'Edwin Ortiz Herazo'));
        return $mail;
    }

    /**
     * @param array<string, mixed> $headers
     * @return array<string, string>
     */
    private static function safeHeaders(array $headers): array
    {
        $out = [];
        foreach ($headers as $name => $value) {
            $name = (string) $name;
            $value = trim((string) $value);
            if (!preg_match('/^[A-Za-z][A-Za-z0-9\-]{1,60}$/', $name) || in_array(strtolower($name), self::RESERVED, true)
                || $value === '' || preg_match('/[\r\n\0]/', $value) || strlen($value) > 900) {
                continue;
            }
            $out[$name] = $value;
        }
        return $out;
    }
}
