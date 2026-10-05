<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Router con rutas nombradas por idioma. El idioma se resuelve por el prefijo de la ruta,
 * nunca por cookie ni por IP.
 */
final class Router
{
    private const PARAM_PATTERNS = [
        'n' => '[1-9][0-9]{0,4}',
        'slug' => '[A-Za-z0-9][A-Za-z0-9_\-]*',
        'token' => '[A-Za-z0-9_\-]{16,128}',
        'gateway' => 'mercadopago|wompi|paypal',
        'id' => '[0-9]+',
        'any' => '.+',
    ];

    /** @var array<int, array> */
    private array $routes = [];
    /** @var array<string, array> */
    private array $named = [];

    /**
     * @param string|string[] $methods
     * @param array{0: class-string, 1: string} $handler
     */
    public function add(string|array $methods, string $pattern, array $handler, ?string $name = null, ?string $locale = null, array $options = []): void
    {
        $route = [
            'methods' => (array) $methods,
            'pattern' => $pattern,
            'regex' => $this->compile($pattern),
            'handler' => $handler,
            'name' => $name,
            'locale' => $locale,
            'options' => $options,
        ];
        $this->routes[] = $route;
        if ($name !== null) {
            $this->named[($locale ?? '*') . '.' . $name] = $route;
        }
    }

    public function get(string $pattern, array $handler, ?string $name = null, ?string $locale = null, array $options = []): void
    {
        $this->add(['GET', 'HEAD'], $pattern, $handler, $name, $locale, $options);
    }

    public function post(string $pattern, array $handler, ?string $name = null, ?string $locale = null, array $options = []): void
    {
        $this->add(['POST'], $pattern, $handler, $name, $locale, $options);
    }

    private function compile(string $pattern): string
    {
        $regex = preg_replace_callback('#\{([a-z]+)(?::([a-z]+))?\}#', function (array $m): string {
            $type = $m[2] ?? $m[1];
            $inner = self::PARAM_PATTERNS[$type] ?? self::PARAM_PATTERNS['slug'];
            return '(?P<' . $m[1] . '>' . $inner . ')';
        }, $pattern);
        return '#^' . $regex . '$#';
    }

    /**
     * @return array{route: array, params: array<string,string>}|array{allowed: string[]}|null
     */
    public function match(string $method, string $path): ?array
    {
        $allowed = [];
        foreach ($this->routes as $route) {
            if (!preg_match($route['regex'], $path, $m)) {
                continue;
            }
            if (!in_array($method, $route['methods'], true)) {
                $allowed = array_merge($allowed, $route['methods']);
                continue;
            }
            $params = array_filter($m, 'is_string', ARRAY_FILTER_USE_KEY);
            return ['route' => $route, 'params' => $params];
        }
        return $allowed ? ['allowed' => array_values(array_unique($allowed))] : null;
    }

    public function has(string $name, ?string $locale): bool
    {
        return isset($this->named[($locale ?? '*') . '.' . $name]) || isset($this->named['*.' . $name]);
    }

    /** Genera la ruta (sin dominio) de una ruta nombrada. */
    public function path(string $name, array $params = [], ?string $locale = null): string
    {
        $route = $this->named[($locale ?? '*') . '.' . $name] ?? $this->named['*.' . $name] ?? null;
        if ($route === null) {
            throw new \InvalidArgumentException("Ruta desconocida: $name ($locale)");
        }
        $query = [];
        $path = preg_replace_callback('#\{([a-z]+)(?::[a-z]+)?\}#', function (array $m) use (&$params): string {
            if (!array_key_exists($m[1], $params)) {
                throw new \InvalidArgumentException("Falta el parámetro {$m[1]}");
            }
            $value = (string) $params[$m[1]];
            unset($params[$m[1]]);
            return rawurlencode($value);
        }, $route['pattern']);
        $query = array_filter($params, fn ($v) => $v !== null && $v !== '');
        return $path . ($query ? '?' . http_build_query($query) : '');
    }
}
