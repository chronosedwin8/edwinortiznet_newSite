<?php

declare(strict_types=1);

namespace App\Services\Social;

use App\Core\Config;
use App\Core\DB;
use App\Core\Logger;

/**
 * Publicador (`social:publish`, cada 5 minutos): publica las filas aprobadas cuya hora ya llegó.
 *
 * - Idempotente: cada fila se toma con un UPDATE condicionado (approved → publishing); una fila que queda en
 *   "publishing" más de 15 minutos pasa a fallida para revisarla a mano (nunca se reintenta sola: podría duplicar).
 * - Instagram: se crea el contenedor, se consulta su estado hasta FINISHED y se publica. Si el contenedor
 *   sigue en proceso, se guarda su id y se retoma en la siguiente ejecución (sin crear otro).
 * - Errores: hasta 3 intentos con espera creciente (5 y 20 minutos); al final, aviso por correo. Un token inválido
 *   marca la cuenta "por reconectar", avisa por correo y no reintenta.
 */
final class Publisher
{
    public const MAX_ATTEMPTS = 3;
    private const BACKOFF_MINUTES = [1 => 5, 2 => 20];
    private const STUCK_MINUTES = 15;

    /** Segundos entre consultas del estado de un contenedor y espera máxima por ejecución (las pruebas usan 0). */
    public static int $pollDelay = 3;
    public static int $pollTimeout = 45;

    /** @return string[] resumen */
    public static function run(int $limit = 10): array
    {
        if ((int) DB::value("SELECT GET_LOCK('edwinortiz_social_publish', 0)") !== 1) {
            return ['Otro publicador está en curso.'];
        }
        try {
            $out = self::recoverStuck();
            $rows = DB::all(
                "SELECT * FROM social_posts WHERE status = 'approved' AND scheduled_at <= :now AND (next_attempt_at IS NULL OR next_attempt_at <= :now2)
                 ORDER BY scheduled_at, id LIMIT " . max(1, min(50, $limit)),
                ['now' => DB::now(), 'now2' => DB::now()]
            );
            foreach ($rows as $row) {
                $out[] = self::publishRow((int) $row['id']);
            }
            return $out;
        } finally {
            DB::value("SELECT RELEASE_LOCK('edwinortiz_social_publish')");
        }
    }

    /** "Publicar ahora" desde el panel: aprueba el grupo con la hora actual y lo publica. @return string[] */
    public static function publishGroupNow(string $groupKey): array
    {
        $out = [];
        foreach (Queue::group($groupKey) as $row) {
            if (!in_array($row['status'], ['draft', 'approved', 'failed', 'skipped'], true)) {
                continue;
            }
            DB::update('social_posts', ['status' => 'approved', 'scheduled_at' => DB::now(), 'attempts' => 0, 'next_attempt_at' => null, 'error' => null], ['id' => (int) $row['id']]);
            $out[] = self::publishRow((int) $row['id']);
        }
        return $out;
    }

    /** Toma la fila (si sigue aprobada) y la publica. Devuelve una línea de resumen. */
    public static function publishRow(int $id): string
    {
        $claimed = DB::run(
            "UPDATE social_posts SET status = 'publishing', locked_at = :now, attempts = attempts + 1 WHERE id = :id AND status = 'approved'",
            ['now' => DB::now(), 'id' => $id]
        )->rowCount();
        if ($claimed !== 1) {
            return "#$id: ya no estaba aprobada.";
        }
        $row = DB::one('SELECT * FROM social_posts WHERE id = :id', ['id' => $id]);
        $label = '#' . $id . ' ' . (Accounts::NETWORKS[$row['network']] ?? $row['network']) . ' «' . mb_substr((string) $row['title'], 0, 60) . '»';
        $account = Accounts::find($row['account_id'] !== null ? (int) $row['account_id'] : null);
        if ($account === null || $account['status'] !== 'active') {
            self::finalFail($row, 'La cuenta no está conectada o hay que reconectarla.', false);
            return "$label: cuenta desconectada.";
        }
        try {
            $result = match ($row['network']) {
                'fb' => self::facebook($row, $account),
                'ig' => self::instagram($row, $account),
            };
            if (!empty($result['pending'])) {
                // El contenedor sigue en proceso: se retoma en 2 minutos sin gastar un intento.
                DB::update('social_posts', [
                    'status' => 'approved', 'locked_at' => null, 'attempts' => max(0, (int) $row['attempts'] - 1),
                    'next_attempt_at' => gmdate('Y-m-d H:i:s', time() + 120),
                ], ['id' => $id]);
                return "$label: contenedor en proceso, se retoma luego.";
            }
            DB::update('social_posts', [
                'status' => 'published', 'external_id' => (string) $result['id'], 'permalink' => $result['permalink'] ?? null,
                'published_at' => DB::now(), 'locked_at' => null, 'container_id' => null, 'error' => null, 'next_attempt_at' => null,
            ], ['id' => $id]);
            Logger::info('Publicado en redes', ['id' => $id, 'network' => $row['network'], 'external' => (string) $result['id']]);
            return "$label: publicado.";
        } catch (MetaException $e) {
            if ($e->isTokenError()) {
                Accounts::tokenFailed((int) $account['id'], $e->getMessage());
                self::finalFail($row, 'Token inválido o vencido: reconecta la cuenta y vuelve a aprobar. (' . $e->getMessage() . ')', false);
                return "$label: token inválido.";
            }
            return self::retryOrFail($row, $label, $e->getMessage());
        } catch (\Throwable $e) {
            Logger::error('Error inesperado al publicar en redes', ['id' => $id, 'error' => $e->getMessage()]);
            return self::retryOrFail($row, $label, 'Error interno: ' . $e->getMessage());
        }
    }

    private static function retryOrFail(array $row, string $label, string $error): string
    {
        $attempts = (int) $row['attempts'];
        if ($attempts >= self::MAX_ATTEMPTS) {
            self::finalFail($row, $error, true);
            return "$label: falló tras $attempts intentos ($error).";
        }
        $wait = self::BACKOFF_MINUTES[$attempts] ?? 30;
        DB::update('social_posts', [
            'status' => 'approved', 'locked_at' => null, 'error' => mb_substr($error, 0, 1000),
            'next_attempt_at' => gmdate('Y-m-d H:i:s', time() + $wait * 60),
        ], ['id' => (int) $row['id']]);
        return "$label: error, se reintenta en $wait min ($error).";
    }

    private static function finalFail(array $row, string $error, bool $email): void
    {
        DB::update('social_posts', ['status' => 'failed', 'locked_at' => null, 'error' => mb_substr($error, 0, 1000), 'next_attempt_at' => null], ['id' => (int) $row['id']]);
        if ($email) {
            $network = Accounts::NETWORKS[$row['network']] ?? $row['network'];
            Accounts::alert(
                "Redes sociales: no se pudo publicar en $network",
                "No se pudo publicar «{$row['title']}» en $network después de " . (int) $row['attempts'] . " intentos.\n\nError: $error\n\nRevísalo y vuelve a aprobarlo en " . Config::appUrl() . '/admin/redes/historial/'
            );
        }
    }

    /** Filas que quedaron "publicando" (el proceso se cortó): pasan a fallidas para revisarlas a mano. @return string[] */
    private static function recoverStuck(): array
    {
        $rows = DB::all(
            "SELECT * FROM social_posts WHERE status = 'publishing' AND (locked_at IS NULL OR locked_at < :t)",
            ['t' => gmdate('Y-m-d H:i:s', time() - self::STUCK_MINUTES * 60)]
        );
        foreach ($rows as $row) {
            self::finalFail($row, 'La publicación se interrumpió. Revisa en la red si quedó publicada antes de volver a aprobarla.', true);
        }
        return $rows === [] ? [] : [count($rows) . ' publicación(es) interrumpida(s) pasaron a fallidas.'];
    }

    /** @return array{id:string, permalink:?string} */
    private static function facebook(array $row, array $account): array
    {
        $token = Accounts::token($account);
        $client = MetaClient::graph();
        $message = CaptionWriter::message('fb', (string) $row['caption'], $row['hashtags'], (string) $row['link']);
        $res = $client->post($account['external_id'] . '/feed', ['message' => $message, 'link' => (string) $row['link']], $token);
        $postId = (string) ($res['id'] ?? '');
        if ($postId === '') {
            throw new MetaException('Facebook no devolvió el id de la publicación.');
        }
        $permalink = null;
        try {
            $permalink = $client->get($postId, ['fields' => 'permalink_url'], $token)['permalink_url'] ?? null;
        } catch (MetaException) {
        }
        return ['id' => $postId, 'permalink' => $permalink ?? 'https://www.facebook.com/' . $postId];
    }

    /** @return array{id?:string, permalink?:?string, pending?:bool} */
    private static function instagram(array $row, array $account): array
    {
        $token = Accounts::token($account);
        $client = MetaClient::graph();
        $ig = (string) $account['external_id'];
        $container = (string) ($row['container_id'] ?? '');
        if ($container === '') {
            if (empty($row['image_url']) || !preg_match('#^https://#', (string) $row['image_url'])) {
                throw new MetaException('Instagram necesita una imagen JPEG pública (https). Revisa APP_URL y la carpeta public/social/.');
            }
            $message = CaptionWriter::message('ig', (string) $row['caption'], $row['hashtags'], (string) $row['link']);
            $res = $client->post("$ig/media", ['image_url' => (string) $row['image_url'], 'caption' => $message], $token);
            $container = (string) ($res['id'] ?? '');
            if ($container === '') {
                throw new MetaException('Instagram no devolvió el contenedor.');
            }
            DB::update('social_posts', ['container_id' => $container], ['id' => (int) $row['id']]);
        }
        $status = self::waitFor(fn () => (string) ($client->get($container, ['fields' => 'status_code'], $token)['status_code'] ?? ''));
        if ($status === 'IN_PROGRESS' || $status === '') {
            return ['pending' => true];
        }
        if ($status !== 'FINISHED') {
            DB::update('social_posts', ['container_id' => null], ['id' => (int) $row['id']]);
            throw new MetaException("Instagram no pudo procesar la imagen (estado $status).");
        }
        $res = $client->post("$ig/media_publish", ['creation_id' => $container], $token);
        $mediaId = (string) ($res['id'] ?? '');
        if ($mediaId === '') {
            throw new MetaException('Instagram no devolvió el id de la publicación.');
        }
        $permalink = null;
        try {
            $permalink = $client->get($mediaId, ['fields' => 'permalink'], $token)['permalink'] ?? null;
        } catch (MetaException) {
        }
        return ['id' => $mediaId, 'permalink' => $permalink];
    }

    /** Consulta el estado hasta que deje de estar en proceso o se acabe el tiempo de esta ejecución. */
    private static function waitFor(callable $status): string
    {
        $deadline = time() + self::$pollTimeout;
        do {
            $current = $status();
            if ($current !== 'IN_PROGRESS' && $current !== '') {
                return $current;
            }
            if (self::$pollDelay > 0) {
                sleep(self::$pollDelay);
            }
        } while (time() < $deadline && self::$pollDelay > 0);
        return $current;
    }
}
