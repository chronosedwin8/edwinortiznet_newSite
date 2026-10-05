<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Registro en storage/logs. No escribir datos sensibles (tarjetas, documentos, secretos).
 */
final class Logger
{
    public static function log(string $level, string $message, array $context = []): void
    {
        $dir = Config::storage('logs');
        if (!is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }
        $line = json_encode([
            'time' => gmdate('c'),
            'level' => $level,
            'message' => $message,
            'context' => self::scrub($context),
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        @file_put_contents($dir . '/app-' . gmdate('Y-m-d') . '.log', $line . PHP_EOL, FILE_APPEND | LOCK_EX);
    }

    public static function info(string $message, array $context = []): void
    {
        self::log('info', $message, $context);
    }

    public static function warning(string $message, array $context = []): void
    {
        self::log('warning', $message, $context);
    }

    public static function error(string $message, array $context = []): void
    {
        self::log('error', $message, $context);
    }

    private static function scrub(array $context): array
    {
        $sensitive = ['password', 'pass', 'secret', 'token', 'document', 'phone', 'authorization', 'card'];
        foreach ($context as $key => $value) {
            if (is_array($value)) {
                $context[$key] = self::scrub($value);
                continue;
            }
            foreach ($sensitive as $word) {
                if (is_string($key) && str_contains(strtolower($key), $word)) {
                    $context[$key] = '[redacted]';
                }
            }
        }
        return $context;
    }
}
