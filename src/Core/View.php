<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Plantillas PHP. Todo valor se imprime con e() salvo HTML ya saneado (lista blanca del importador/panel).
 */
final class View
{
    /** Datos compartidos por todas las plantillas (meta, idioma, alternativas…). */
    private static array $shared = [];

    public static function share(string $key, mixed $value): void
    {
        self::$shared[$key] = $value;
    }

    public static function shared(string $key, mixed $default = null): mixed
    {
        return self::$shared[$key] ?? $default;
    }

    public static function reset(): void
    {
        self::$shared = [];
    }

    public static function render(string $template, array $data = []): string
    {
        $file = Config::root('templates/' . $template . '.php');
        if (!is_file($file)) {
            throw new \RuntimeException("Plantilla no encontrada: $template");
        }
        $data = array_merge(self::$shared, $data);
        return (static function (string $__file, array $__data): string {
            extract($__data, EXTR_SKIP);
            ob_start();
            try {
                include $__file;
            } catch (\Throwable $e) {
                ob_end_clean();
                throw $e;
            }
            return (string) ob_get_clean();
        })($file, $data);
    }

    /**
     * Renderiza una página dentro de un layout. $meta alimenta <head> (title, description, canonical…).
     */
    public static function page(string $template, array $data = [], array $meta = [], string $layout = 'layouts/base'): string
    {
        $content = self::render($template, $data);
        return self::render($layout, array_merge($data, ['content' => $content, 'meta' => $meta]));
    }
}
