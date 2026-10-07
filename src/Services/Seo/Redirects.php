<?php

declare(strict_types=1);

namespace App\Services\Seo;

use App\Core\DB;
use App\Core\Logger;
use App\Core\Request;

/**
 * Tabla `redirects` (exacta, prefijo o regex) y registro de 404 en `not_found_log`.
 */
final class Redirects
{
    private static ?array $rules = null;

    public static function clear(): void
    {
        self::$rules = null;
    }

    /**
     * Redirección exacta (301 por defecto) de una URL que deja de existir. Las reglas que apuntaban a esa URL
     * pasan a apuntar al nuevo destino, para no encadenar saltos.
     */
    public static function add(string $source, string $target, string $note, int $code = 301): void
    {
        if ($source === $target) {
            return;
        }
        DB::upsert('redirects', ['source' => $source, 'target' => $target, 'code' => $code, 'match_type' => 'exact', 'note' => mb_substr($note, 0, 255)], ['source', 'match_type']);
        DB::run('UPDATE redirects SET target = ? WHERE target = ? AND source <> ?', [$target, $source, $target]);
        self::$rules = null;
    }

    private static function rules(): array
    {
        if (self::$rules === null) {
            try {
                self::$rules = DB::all('SELECT id, source, target, code, match_type FROM redirects ORDER BY match_type = "exact" DESC, LENGTH(source) DESC');
            } catch (\Throwable) {
                self::$rules = [];
            }
        }
        return self::$rules;
    }

    /** @return array{target:string, code:int}|null */
    public static function find(string $path): ?array
    {
        $candidates = [$path];
        if (!str_contains($path, '?')) {
            $candidates[] = str_ends_with($path, '/') ? rtrim($path, '/') : $path . '/';
        }
        foreach (self::rules() as $rule) {
            $target = null;
            if ($rule['match_type'] === 'exact' && in_array($rule['source'], $candidates, true)) {
                $target = $rule['target'];
            } elseif ($rule['match_type'] === 'prefix' && str_starts_with($path, $rule['source'])) {
                $target = $rule['target'];
            } elseif ($rule['match_type'] === 'regex') {
                $regex = '#' . str_replace('#', '\#', $rule['source']) . '#';
                if (@preg_match($regex, $path) === 1) {
                    $target = preg_replace($regex, $rule['target'], $path);
                }
            }
            if ($target !== null && $target !== $path) {
                DB::run('UPDATE redirects SET hits = hits + 1, last_hit_at = UTC_TIMESTAMP() WHERE id = :id', ['id' => (int) $rule['id']]);
                return ['target' => $target, 'code' => (int) $rule['code']];
            }
        }
        return null;
    }

    public static function logNotFound(Request $request): void
    {
        try {
            DB::run(
                'INSERT INTO not_found_log (path, referer, hits, first_seen, last_seen)
                 VALUES (:p, :r, 1, UTC_TIMESTAMP(), UTC_TIMESTAMP())
                 ON DUPLICATE KEY UPDATE hits = hits + 1, last_seen = UTC_TIMESTAMP(), referer = COALESCE(VALUES(referer), referer)',
                [
                    'p' => mb_substr($request->path, 0, 255),
                    'r' => ($ref = $request->header('Referer')) !== null ? mb_substr($ref, 0, 255) : null,
                ]
            );
        } catch (\Throwable $e) {
            Logger::warning('No se pudo registrar el 404', ['error' => $e->getMessage()]);
        }
    }
}
