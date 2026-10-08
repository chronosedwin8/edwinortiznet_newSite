<?php

declare(strict_types=1);

namespace App\Services\Newsletter;

use App\Models\Setting;

/**
 * Ajustes del boletín (tabla settings, claves "newsletter.*") y cálculo de la próxima edición.
 *
 * Calendario: cada N días (15 por omisión) a la hora indicada, hora de Colombia. Si N ≥ 7 y hay un día de la
 * semana elegido, la fecha se ajusta a ese día de la semana más cercano (con 15 días y martes = un martes cada dos semanas).
 * Con día "cualquiera" se respeta N exacto. La edición se prepara y se envía la vista previa a ADMIN_EMAIL
 * 24 horas antes; si esa ventana ya pasó (p. ej. el boletín estuvo apagado), se toma el siguiente horario
 * que deje al menos 22 horas para revisar.
 */
final class NewsletterSettings
{
    public const TZ = 'America/Bogota';
    /** La edición se prepara (y sale la vista previa) este tiempo antes del envío. */
    public const LEAD = 86400;
    /** Margen mínimo para revisar la vista previa cuando hay que reprogramar. */
    private const MIN_REVIEW = 22 * 3600;

    public const DEFAULTS = [
        'enabled' => '1',
        'every_days' => '15',
        'weekday' => '2',        // ISO: 1 = lunes … 7 = domingo; 0 = cualquier día
        'time' => '07:00',
        'mode' => 'auto',        // auto | approval
        'articles' => '5',
        'products' => '3',
        'batch' => '50',
        'ai' => '1',
        'address' => 'Barranquilla, Colombia',
    ];

    /** @return array{enabled:bool, every_days:int, weekday:int, time:string, mode:string, articles:int, products:int, batch:int, ai:bool, address:string} */
    public static function all(): array
    {
        $v = [];
        foreach (self::DEFAULTS as $key => $default) {
            $v[$key] = Setting::get('newsletter.' . $key, $default) ?? $default;
        }
        return [
            'enabled' => $v['enabled'] === '1',
            'every_days' => max(1, min(90, (int) $v['every_days'])),
            'weekday' => max(0, min(7, (int) $v['weekday'])),
            'time' => preg_match('/^([01]\d|2[0-3]):[0-5]\d$/', $v['time']) ? $v['time'] : '07:00',
            'mode' => $v['mode'] === 'approval' ? 'approval' : 'auto',
            'articles' => max(1, min(10, (int) $v['articles'])),
            'products' => max(0, min(4, (int) $v['products'])),
            'batch' => max(5, min(300, (int) $v['batch'])),
            'ai' => $v['ai'] === '1',
            'address' => mb_substr(trim($v['address']), 0, 160) ?: self::DEFAULTS['address'],
        ];
    }

    public static function save(array $input): void
    {
        $time = (string) ($input['time'] ?? '');
        $values = [
            'enabled' => !empty($input['enabled']) ? '1' : '0',
            'every_days' => (string) max(1, min(90, (int) ($input['every_days'] ?? 15))),
            'weekday' => (string) max(0, min(7, (int) ($input['weekday'] ?? 2))),
            'time' => preg_match('/^([01]\d|2[0-3]):[0-5]\d$/', $time) ? $time : '07:00',
            'mode' => ($input['mode'] ?? '') === 'approval' ? 'approval' : 'auto',
            'articles' => (string) max(1, min(10, (int) ($input['articles'] ?? 5))),
            'products' => (string) max(0, min(4, (int) ($input['products'] ?? 3))),
            'batch' => (string) max(5, min(300, (int) ($input['batch'] ?? 50))),
            'ai' => !empty($input['ai']) ? '1' : '0',
            'address' => mb_substr(trim((string) ($input['address'] ?? '')), 0, 160) ?: self::DEFAULTS['address'],
        ];
        foreach ($values as $key => $value) {
            Setting::set('newsletter.' . $key, $value);
        }
    }

    /**
     * Fecha (timestamp UTC) de la próxima edición.
     * @param string|null $lastScheduledUtc fecha programada de la última edición (enviada o cancelada)
     */
    public static function nextDue(array $s, ?string $lastScheduledUtc, int $now): int
    {
        $tz = new \DateTimeZone(self::TZ);
        [$h, $m] = array_map('intval', explode(':', $s['time']));
        if ($lastScheduledUtc !== null) {
            $base = (new \DateTimeImmutable($lastScheduledUtc, new \DateTimeZone('UTC')))->setTimezone($tz)
                ->modify('+' . $s['every_days'] . ' days')->setTime($h, $m);
            if ($s['weekday'] > 0 && $s['every_days'] >= 7) {
                $diff = $s['weekday'] - (int) $base->format('N');
                $diff += $diff > 3 ? -7 : ($diff < -3 ? 7 : 0);
                $base = $base->modify(($diff >= 0 ? '+' : '') . $diff . ' days');
            }
            if ($base->getTimestamp() >= $now + self::MIN_REVIEW) {
                return $base->getTimestamp();
            }
        }
        // Primera edición o calendario vencido: el siguiente horario con tiempo para revisar la vista previa.
        $c = (new \DateTimeImmutable('@' . ($now + self::MIN_REVIEW)))->setTimezone($tz)->setTime($h, $m);
        if ($c->getTimestamp() < $now + self::MIN_REVIEW) {
            $c = $c->modify('+1 day');
        }
        if ($s['weekday'] > 0) {
            for ($i = 0; $i < 7 && (int) $c->format('N') !== $s['weekday']; $i++) {
                $c = $c->modify('+1 day');
            }
        }
        return $c->getTimestamp();
    }

    /** Fecha UTC (Y-m-d H:i:s) → texto en hora de Colombia. */
    public static function local(?string $utc, string $format = 'Y-m-d H:i'): string
    {
        if ($utc === null || $utc === '') {
            return '—';
        }
        return (new \DateTimeImmutable($utc, new \DateTimeZone('UTC')))->setTimezone(new \DateTimeZone(self::TZ))->format($format);
    }

    /** Fecha local (Y-m-d H:i, Colombia) → UTC (Y-m-d H:i:s); null si no es válida. */
    public static function toUtc(string $local): ?string
    {
        $d = \DateTimeImmutable::createFromFormat('Y-m-d\TH:i', $local, new \DateTimeZone(self::TZ))
            ?: \DateTimeImmutable::createFromFormat('Y-m-d H:i', $local, new \DateTimeZone(self::TZ));
        return $d ? $d->setTimezone(new \DateTimeZone('UTC'))->format('Y-m-d H:i:s') : null;
    }
}
