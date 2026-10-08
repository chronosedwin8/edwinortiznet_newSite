<?php

declare(strict_types=1);

namespace App\Services\Social;

use App\Core\DB;
use App\Core\Logger;
use App\Models\Setting;

/**
 * Planificador (`social:plan`, una vez al día): llena la cola de los próximos días de cada canal activo según
 * su horario, con contenido que cumpla la regla del canal.
 *
 * Selección: primero lo que nunca se ha compartido en el canal (lo más reciente primero), después lo compartido
 * hace al menos 45 días (lo más antiguo primero). Nunca el mismo contenido en el canal dentro de 30 días después
 * ni 45 días antes. Mezcla: ~1 producto o herramienta por cada 4 publicaciones.
 */
final class Planner
{
    public const DAYS_AHEAD = 7;
    public const REPEAT_AFTER_DAYS = 45;
    public const NO_REPEAT_DAYS = 30;
    public const MIX_EVERY = 4;

    /** @return string[] resumen */
    public static function run(int $days = self::DAYS_AHEAD, bool $useAi = true, ?int $now = null): array
    {
        $now ??= time();
        if (!self::lock()) {
            return ['Otro planificador está en curso.'];
        }
        $out = [];
        try {
            $expired = DB::run(
                "UPDATE social_posts SET status = 'skipped', error = 'No se aprobó a tiempo.' WHERE status = 'draft' AND scheduled_at < :t",
                ['t' => gmdate('Y-m-d H:i:s', $now - 12 * 3600)]
            )->rowCount();
            if ($expired > 0) {
                $out[] = "$expired borrador(es) vencido(s) sin aprobar se marcaron como omitidos.";
            }
            foreach (Channels::all(true) as $channel) {
                $accounts = array_filter(Channels::accounts($channel), fn ($a) => $a['status'] === 'active');
                if ($accounts === []) {
                    $out[] = "{$channel['name']}: sin cuentas conectadas.";
                    continue;
                }
                $created = 0;
                foreach (Schedule::slots($channel['schedule'], $now + 600, $days) as $slot) {
                    if (DB::value('SELECT 1 FROM social_posts WHERE channel_id = :c AND scheduled_at = :s LIMIT 1', ['c' => (int) $channel['id'], 's' => $slot]) !== null) {
                        continue;
                    }
                    $item = self::pick($channel, $slot);
                    if ($item === null) {
                        $out[] = "{$channel['name']}: no hay contenido disponible para " . Schedule::toLocal($slot) . '.';
                        break;
                    }
                    Queue::createGroup($channel, $item, $slot, $accounts, 'planner', $useAi);
                    $created++;
                }
                $out[] = "{$channel['name']}: $created publicación(es) nuevas en la cola.";
            }
            Setting::set('social.last_plan_at', gmdate('Y-m-d H:i:s', $now));
        } catch (\Throwable $e) {
            Logger::error('Planificador de redes falló', ['error' => $e->getMessage()]);
            throw $e;
        } finally {
            self::unlock();
        }
        return $out;
    }

    /**
     * Elige el contenido para un horario del canal (o null si no hay nada que cumpla las reglas).
     * @param string[] $exclude content_key que no se deben elegir
     */
    public static function pick(array $channel, string $slotUtc, array $exclude = []): ?array
    {
        $ranked = self::ranked($channel, $slotUtc, $exclude);
        if ($ranked === []) {
            return null;
        }
        $wantPromo = self::wantsPromo((int) $channel['id'], $slotUtc);
        foreach ($ranked as $item) {
            if (self::isPromo($item) === $wantPromo) {
                return $item;
            }
        }
        return $ranked[0];
    }

    /**
     * Candidatos ordenados por prioridad, sin los que se repetirían.
     * @param string[] $exclude
     * @return array<int, array>
     */
    public static function ranked(array $channel, string $slotUtc, array $exclude = []): array
    {
        $slot = strtotime($slotUtc . ' UTC');
        $history = [];
        foreach (DB::all("SELECT content_key, scheduled_at FROM social_posts WHERE channel_id = :c AND status <> 'skipped'", ['c' => (int) $channel['id']]) as $row) {
            $history[$row['content_key']][] = strtotime($row['scheduled_at'] . ' UTC');
        }
        $never = [];
        $again = [];
        foreach (Catalog::candidates($channel['content']) as $item) {
            if (in_array($item['key'], $exclude, true)) {
                continue;
            }
            $times = $history[$item['key']] ?? [];
            if ($times === []) {
                $never[] = $item;
                continue;
            }
            $blocked = false;
            foreach ($times as $ts) {
                $diff = $slot - $ts; // > 0: antes del horario
                if (($diff >= 0 && $diff < self::REPEAT_AFTER_DAYS * 86400) || ($diff < 0 && -$diff < self::NO_REPEAT_DAYS * 86400)) {
                    $blocked = true;
                    break;
                }
            }
            if (!$blocked) {
                $item['last_shared'] = max($times);
                $again[] = $item;
            }
        }
        // Nunca compartidos: lo más reciente primero (herramientas y productos, en un orden estable).
        usort($never, fn ($a, $b) => [(string) ($b['published_at'] ?? ''), crc32($a['key'])] <=> [(string) ($a['published_at'] ?? ''), crc32($b['key'])]);
        usort($again, fn ($a, $b) => $a['last_shared'] <=> $b['last_shared']);
        return array_merge($never, $again);
    }

    public static function isPromo(array $item): bool
    {
        return in_array($item['type'], ['product', 'tool'], true);
    }

    /** ¿Toca producto o herramienta? Sí, si en las últimas (MIX_EVERY - 1) publicaciones del canal no hubo ninguno. */
    private static function wantsPromo(int $channelId, string $slotUtc): bool
    {
        $recent = DB::column(
            "SELECT MIN(content_type) FROM social_posts WHERE channel_id = :c AND status <> 'skipped' AND scheduled_at < :s
             GROUP BY group_key ORDER BY MAX(scheduled_at) DESC LIMIT " . (self::MIX_EVERY - 1),
            ['c' => $channelId, 's' => $slotUtc]
        );
        if (count($recent) < self::MIX_EVERY - 1) {
            return false;
        }
        return array_intersect($recent, ['product', 'tool']) === [];
    }

    private static function lock(): bool
    {
        return (int) DB::value("SELECT GET_LOCK('edwinortiz_social_plan', 0)") === 1;
    }

    private static function unlock(): void
    {
        DB::value("SELECT RELEASE_LOCK('edwinortiz_social_plan')");
    }
}
