<?php

declare(strict_types=1);

namespace App\Services\Social;

use DateTimeImmutable;
use DateTimeZone;

/**
 * Horarios de los canales. En la base todo va en UTC; los canales se configuran en hora local (America/Bogota).
 * Regla: {"days":[1..7] (ISO: 1 = lunes), "time":"HH:MM", "tz":"America/Bogota"}.
 */
final class Schedule
{
    public const TZ = 'America/Bogota';

    public static function normalize(array $rule): array
    {
        $days = array_values(array_unique(array_filter(array_map('intval', (array) ($rule['days'] ?? [])), fn ($d) => $d >= 1 && $d <= 7)));
        sort($days);
        $time = preg_match('/^([01]\d|2[0-3]):[0-5]\d$/', (string) ($rule['time'] ?? '')) ? (string) $rule['time'] : '18:30';
        $tz = (string) ($rule['tz'] ?? self::TZ);
        if (!in_array($tz, DateTimeZone::listIdentifiers(), true)) {
            $tz = self::TZ;
        }
        return ['days' => $days, 'time' => $time, 'tz' => $tz];
    }

    /**
     * Horarios (UTC, "Y-m-d H:i:s") de la regla entre $fromTs y $fromTs + $days días.
     * @return string[]
     */
    public static function slots(array $rule, int $fromTs, int $days): array
    {
        $rule = self::normalize($rule);
        $tz = new DateTimeZone($rule['tz']);
        $utc = new DateTimeZone('UTC');
        $start = (new DateTimeImmutable('@' . $fromTs))->setTimezone($tz)->setTime(0, 0);
        [$h, $m] = array_map('intval', explode(':', $rule['time']));
        $out = [];
        for ($i = 0; $i <= $days; $i++) {
            $day = $start->modify("+$i day");
            if (!in_array((int) $day->format('N'), $rule['days'], true)) {
                continue;
            }
            $at = $day->setTime($h, $m);
            $ts = $at->getTimestamp();
            if ($ts > $fromTs && $ts <= $fromTs + $days * 86400) {
                $out[] = $at->setTimezone($utc)->format('Y-m-d H:i:s');
            }
        }
        return $out;
    }

    public static function toLocal(?string $utc, string $format = 'Y-m-d H:i', string $tz = self::TZ): string
    {
        if ($utc === null || $utc === '') {
            return '';
        }
        return (new DateTimeImmutable($utc, new DateTimeZone('UTC')))->setTimezone(new DateTimeZone($tz))->format($format);
    }

    /** "2026-10-09T18:30" o "2026-10-09 18:30" en hora local → UTC. Null si no es válida. */
    public static function toUtc(string $local, string $tz = self::TZ): ?string
    {
        $local = str_replace('T', ' ', trim($local));
        if (!preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}(:\d{2})?$/', $local)) {
            return null;
        }
        try {
            $dt = new DateTimeImmutable($local, new DateTimeZone($tz));
        } catch (\Exception) {
            return null;
        }
        return $dt->setTimezone(new DateTimeZone('UTC'))->format('Y-m-d H:i:s');
    }
}
