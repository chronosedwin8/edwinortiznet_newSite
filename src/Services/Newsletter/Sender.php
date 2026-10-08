<?php

declare(strict_types=1);

namespace App\Services\Newsletter;

use App\Core\Config;
use App\Core\DB;
use App\Core\Logger;
use App\Core\Mailer;
use App\Services\Subscribers;

/**
 * Cola del boletín (cron `newsletter:run` cada 10 minutos).
 *
 * 1. Prepara la edición cuando falta un día (NewsletterSettings::nextDue) y envía la vista previa a ADMIN_EMAIL.
 * 2. A la hora programada (modo automático, o cuando el administrador la aprueba) pone en cola a todos los
 *    suscriptores activos (no pausados) con INSERT IGNORE sobre UNIQUE(issue_id, subscriber_id).
 * 3. Envía por lotes (50 por ejecución por omisión, ~5 por segundo; SES permite 14/s). Cada envío se toma con un
 *    UPDATE condicionado, así que dos procesos nunca envían el mismo; un envío que quedó "sending" más de
 *    30 minutos (proceso caído) se da por fallido sin reintentar, para no duplicarlo. Los fallos de SMTP se
 *    reintentan 3 veces (15 y 45 minutos).
 */
final class Sender
{
    private const MAX_ATTEMPTS = 3;
    private const PAUSE_US = 200_000;      // ~5 correos por segundo
    private const STALE_MINUTES = 30;
    /** Una edición sin aprobar (modo "esperar aprobación" o boletín apagado) se cancela a los 7 días de su fecha. */
    private const APPROVAL_TTL = 7 * 86400;

    /** Pruebas: sin pausas entre correos. */
    public static bool $throttle = true;

    /** @return string[] líneas para el registro del cron */
    public static function run(?int $now = null): array
    {
        $now ??= time();
        $log = [];
        if ((int) DB::value("SELECT GET_LOCK('eo_newsletter_run', 0)") !== 1) {
            return ['Otra ejecución del boletín está en curso.'];
        }
        try {
            $settings = NewsletterSettings::all();
            $nowUtc = gmdate('Y-m-d H:i:s', $now);
            // Envíos colgados: no se reintentan (podrían haber salido).
            $stale = DB::run(
                "UPDATE newsletter_sends SET status = 'failed', error = 'Interrumpido durante el envío (no se reintenta para no duplicar)'
                 WHERE status = 'sending' AND locked_at < :t",
                ['t' => gmdate('Y-m-d H:i:s', $now - self::STALE_MINUTES * 60)]
            )->rowCount();
            if ($stale > 0) {
                $log[] = "$stale envío(s) interrumpido(s) marcados como fallidos.";
            }
            // Ediciones que esperaban aprobación y nadie aprobó.
            DB::run(
                "UPDATE newsletter_issues SET status = 'cancelled', note = 'Sin aprobar a tiempo' WHERE status = 'scheduled' AND approved_at IS NULL AND scheduled_for < :t",
                ['t' => gmdate('Y-m-d H:i:s', $now - self::APPROVAL_TTL)]
            );

            $open = self::openIssue();
            if ($open === null && $settings['enabled']) {
                $due = self::nextDue($settings, $now);
                if ($now >= $due - NewsletterSettings::LEAD) {
                    $issue = Builder::createIssue(gmdate('Y-m-d H:i:s', $due));
                    $log[] = "Edición {$issue['issue_key']} preparada para " . NewsletterSettings::local($issue['scheduled_for']) . ' (Colombia).';
                    $open = $issue;
                }
            }
            if ($open !== null && $open['status'] === 'scheduled') {
                if ($open['preview_sent_at'] === null && strtotime($open['scheduled_for'] . ' UTC') - $now <= NewsletterSettings::LEAD + 600) {
                    $log[] = self::sendPreview($open) ? 'Vista previa enviada a ADMIN_EMAIL.' : 'No se pudo enviar la vista previa (revisa ADMIN_EMAIL).';
                }
                $approved = $open['approved_at'] !== null || ($settings['mode'] === 'auto' && $settings['enabled']);
                if ($approved && $open['scheduled_for'] <= $nowUtc) {
                    $n = self::start((int) $open['id']);
                    $log[] = "Edición {$open['issue_key']}: envío iniciado para $n suscriptor(es).";
                    $open = Builder::issue((int) $open['id']);
                }
            }
            if ($open !== null && $open['status'] === 'sending') {
                foreach (self::batch($open, $settings, $now) as $line) {
                    $log[] = $line;
                }
            }
        } finally {
            DB::value("SELECT RELEASE_LOCK('eo_newsletter_run')");
        }
        return $log === [] ? ['Nada que hacer.'] : $log;
    }

    public static function openIssue(): ?array
    {
        $id = DB::value("SELECT id FROM newsletter_issues WHERE status IN ('scheduled','sending') ORDER BY scheduled_for LIMIT 1");
        return $id !== null ? Builder::issue((int) $id) : null;
    }

    /** Próxima fecha según el calendario (desde la última edición enviada o cancelada). */
    public static function nextDue(array $settings, int $now): int
    {
        $last = DB::value("SELECT scheduled_for FROM newsletter_issues WHERE status IN ('sent','cancelled','failed') ORDER BY scheduled_for DESC LIMIT 1");
        return NewsletterSettings::nextDue($settings, $last !== null ? (string) $last : null, $now);
    }

    /** Pone en cola a los suscriptores activos y no pausados. Devuelve cuántos. */
    public static function start(int $issueId): int
    {
        $claimed = DB::run("UPDATE newsletter_issues SET status = 'sending', started_at = UTC_TIMESTAMP() WHERE id = :id AND status = 'scheduled'", ['id' => $issueId])->rowCount();
        if ($claimed !== 1) {
            return 0;
        }
        DB::run(
            'INSERT IGNORE INTO newsletter_sends (issue_id, subscriber_id, email, locale, status)
             SELECT :i, id, email, locale, \'queued\' FROM subscribers WHERE ' . Subscribers::RECEIVES,
            ['i' => $issueId]
        );
        $n = (int) DB::value('SELECT COUNT(*) FROM newsletter_sends WHERE issue_id = :i', ['i' => $issueId]);
        DB::update('newsletter_issues', ['recipients' => $n], ['id' => $issueId]);
        return $n;
    }

    /** @return string[] */
    private static function batch(array $issue, array $settings, int $now): array
    {
        $issueId = (int) $issue['id'];
        $rows = DB::all(
            "SELECT * FROM newsletter_sends WHERE issue_id = :i AND status = 'queued' AND (next_attempt_at IS NULL OR next_attempt_at <= :t)
             ORDER BY id LIMIT " . (int) $settings['batch'],
            ['i' => $issueId, 't' => gmdate('Y-m-d H:i:s', $now)]
        );
        $sent = $failed = $skipped = $streak = 0;
        Mailer::keepAlive(true);
        try {
            foreach ($rows as $row) {
                // Toma el envío: si otro proceso ya lo tomó, rowCount = 0 y se salta.
                $claimed = DB::run(
                    "UPDATE newsletter_sends SET status = 'sending', locked_at = UTC_TIMESTAMP(), attempts = attempts + 1 WHERE id = :id AND status = 'queued'",
                    ['id' => (int) $row['id']]
                )->rowCount();
                if ($claimed !== 1) {
                    continue;
                }
                $subscriber = $row['subscriber_id'] !== null ? Subscribers::byId((int) $row['subscriber_id']) : null;
                if ($subscriber === null || $subscriber['status'] !== 'active'
                    || ($subscriber['paused_until'] !== null && strtotime($subscriber['paused_until'] . ' UTC') > $now)) {
                    DB::update('newsletter_sends', ['status' => 'skipped', 'error' => 'Ya no está activo'], ['id' => (int) $row['id']]);
                    $skipped++;
                    continue;
                }
                $personal = Builder::personalize($issue, (string) $subscriber['locale'], Interests::fromSet($subscriber['interests']), $settings);
                $mail = Renderer::render($issue, $personal, $subscriber, (int) $row['id']);
                $ok = Mailer::send((string) $subscriber['email'], $mail['subject'], $mail['html'], $mail['text'], null, $mail['headers']);
                $items = array_merge(array_column($personal['posts'], 'key'), array_column($personal['offers'], 'key'));
                if ($ok) {
                    DB::run(
                        "UPDATE newsletter_sends SET status = 'sent', sent_at = UTC_TIMESTAMP(), error = NULL, subject = :s, items_json = :j WHERE id = :id",
                        ['s' => mb_substr($mail['subject'], 0, 255), 'j' => json_encode($items), 'id' => (int) $row['id']]
                    );
                    DB::run('UPDATE subscribers SET last_sent_at = UTC_TIMESTAMP(), sends_count = sends_count + 1 WHERE id = :id', ['id' => (int) $subscriber['id']]);
                    $sent++;
                    $streak = 0;
                } else {
                    $attempts = (int) $row['attempts'] + 1;
                    $final = $attempts >= self::MAX_ATTEMPTS;
                    DB::update('newsletter_sends', [
                        'status' => $final ? 'failed' : 'queued',
                        'next_attempt_at' => $final ? null : gmdate('Y-m-d H:i:s', $now + 900 * $attempts * $attempts),
                        'error' => mb_substr((string) (Mailer::$lastError ?? 'Error de envío'), 0, 500),
                    ], ['id' => (int) $row['id']]);
                    $failed++;
                    // Varios fallos seguidos = problema de SMTP, no del destinatario: se para y se reintenta luego.
                    if (++$streak >= 3) {
                        Logger::error('Boletín: 3 fallos seguidos de envío; se detiene el lote', ['issue' => $issue['issue_key']]);
                        break;
                    }
                }
                if (self::$throttle) {
                    usleep(self::PAUSE_US);
                }
            }
        } finally {
            Mailer::keepAlive(false);
        }
        $log = ["Edición {$issue['issue_key']}: $sent enviado(s), $failed fallido(s), $skipped omitido(s)."];
        $pending = (int) DB::value("SELECT COUNT(*) FROM newsletter_sends WHERE issue_id = :i AND status IN ('queued','sending')", ['i' => $issueId]);
        if ($pending === 0) {
            $okCount = (int) DB::value("SELECT COUNT(*) FROM newsletter_sends WHERE issue_id = :i AND status = 'sent'", ['i' => $issueId]);
            $total = (int) DB::value('SELECT COUNT(*) FROM newsletter_sends WHERE issue_id = :i', ['i' => $issueId]);
            DB::run(
                "UPDATE newsletter_issues SET status = :s, finished_at = UTC_TIMESTAMP() WHERE id = :id AND status = 'sending'",
                ['s' => $okCount > 0 || $total === 0 ? 'sent' : 'failed', 'id' => $issueId]
            );
            $log[] = "Edición {$issue['issue_key']} terminada.";
        }
        return $log;
    }

    /** Copia de la edición (perfil "de todo un poco") a ADMIN_EMAIL con un aviso para cancelar o posponer. */
    public static function sendPreview(array $issue): bool
    {
        $to = (string) Config::get('ADMIN_EMAIL', '');
        if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        $settings = NewsletterSettings::all();
        $recipients = (int) DB::value('SELECT COUNT(*) FROM subscribers WHERE ' . Subscribers::RECEIVES);
        $when = NewsletterSettings::local($issue['scheduled_for'], 'd/m/Y \a \l\a\s g:i a');
        $admin = url('/admin/boletin/');
        $needsApproval = $settings['mode'] === 'approval' && $issue['approved_at'] === null;
        $banner = '<strong>' . e($needsApproval ? 'Necesita tu aprobación.' : 'Vista previa del boletín.') . '</strong> '
            . e(($needsApproval ? 'Si lo apruebas, saldrá el ' : 'Saldrá automáticamente el ') . $when . " (hora de Colombia) a $recipients suscriptor(es) activos. Cada persona recibe los artículos y productos de sus temas; esta copia es la versión «de todo un poco». ")
            . 'Para ' . ($needsApproval ? 'aprobarlo, ' : '') . 'cancelarlo, posponerlo o editar el asunto entra a <a href="' . e($admin) . '" style="color:#5a3300;text-decoration:underline;">' . e($admin) . '</a>.';
        $personal = Builder::personalize($issue, 'es', [], $settings);
        $mail = Renderer::render($issue, $personal, null, null, $banner);
        $ok = Mailer::send($to, '[Vista previa] ' . $mail['subject'], $mail['html'], $mail['text']);
        if ($ok) {
            DB::run('UPDATE newsletter_issues SET preview_sent_at = UTC_TIMESTAMP() WHERE id = :id', ['id' => (int) $issue['id']]);
        }
        return $ok;
    }

    /** Envío de prueba con un perfil de intereses (sin seguimiento ni cola). */
    public static function sendTest(array $issue, string $to, array $interests, string $locale = 'es'): bool
    {
        $personal = Builder::personalize($issue, $locale, $interests);
        $mail = Renderer::render($issue, $personal);
        return Mailer::send($to, '[Prueba] ' . $mail['subject'], $mail['html'], $mail['text']);
    }

    /** Estadísticas de una edición. */
    public static function stats(int $issueId): array
    {
        return DB::one(
            "SELECT COUNT(*) AS total, SUM(status = 'sent') AS sent, SUM(status = 'failed') AS failed, SUM(status = 'skipped') AS skipped,
                    SUM(status IN ('queued','sending')) AS pending, SUM(opened_at IS NOT NULL) AS opened, SUM(clicked_at IS NOT NULL) AS clicked,
                    SUM(unsubscribed_at IS NOT NULL) AS unsubscribed, COALESCE(SUM(clicks), 0) AS clicks
             FROM newsletter_sends WHERE issue_id = :i",
            ['i' => $issueId]
        ) ?? [];
    }
}
