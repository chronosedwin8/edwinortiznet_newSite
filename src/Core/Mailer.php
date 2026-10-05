<?php

declare(strict_types=1);

namespace App\Core;

use PHPMailer\PHPMailer\PHPMailer;

/**
 * Envío de correo con PHPMailer (SMTP). Con MAIL_DRIVER=log los correos se guardan en storage/logs/mail/.
 */
final class Mailer
{
    /** @var array<int, array> Correos enviados en esta ejecución (útil en pruebas). */
    public static array $sent = [];

    public static function send(string $to, string $subject, string $html, string $text, ?string $replyTo = null): bool
    {
        $driver = (string) Config::get('MAIL_DRIVER', 'smtp');
        self::$sent[] = compact('to', 'subject', 'html', 'text');
        if ($driver === 'log' || $driver === 'array') {
            if ($driver === 'log') {
                $dir = Config::storage('logs/mail');
                if (!is_dir($dir)) {
                    mkdir($dir, 0775, true);
                }
                $name = gmdate('Ymd-His') . '-' . substr(sha1($to . $subject . microtime()), 0, 8);
                file_put_contents("$dir/$name.html", "<!-- To: $to | Subject: " . htmlspecialchars($subject) . " -->\n" . $html);
                file_put_contents("$dir/$name.txt", "To: $to\nSubject: $subject\n\n" . $text);
            }
            return true;
        }

        $mail = new PHPMailer(true);
        try {
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
            $mail->CharSet = PHPMailer::CHARSET_UTF8;
            $mail->setFrom((string) Config::get('MAIL_FROM_ADDRESS'), (string) Config::get('MAIL_FROM_NAME', 'Edwin Ortiz Herazo'));
            $mail->addAddress($to);
            if ($replyTo !== null) {
                $mail->addReplyTo($replyTo);
            }
            $mail->Subject = $subject;
            $mail->isHTML(true);
            $mail->Body = $html;
            $mail->AltBody = $text;
            $mail->send();
            return true;
        } catch (\Throwable $e) {
            Logger::error('No se pudo enviar el correo', ['subject' => $subject, 'error' => $mail->ErrorInfo]);
            return false;
        }
    }
}
