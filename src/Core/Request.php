<?php

declare(strict_types=1);

namespace App\Core;

final class Request
{
    public array $attributes = [];

    public function __construct(
        public readonly string $method,
        public readonly string $path,
        public readonly array $query,
        public readonly array $post,
        public readonly array $server,
        public readonly array $cookies,
        public readonly array $files = [],
        private readonly ?string $rawBody = null,
    ) {
    }

    public static function fromGlobals(): self
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $path = rawurldecode((string) parse_url($uri, PHP_URL_PATH));
        $path = '/' . ltrim(preg_replace('#/+#', '/', $path) ?? '/', '/');
        return new self(
            strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET'),
            $path,
            $_GET,
            $_POST,
            $_SERVER,
            $_COOKIE,
            $_FILES,
        );
    }

    /** Construye peticiones sintéticas (pruebas y consola). */
    public static function create(string $method, string $uri, array $post = [], array $server = [], array $cookies = [], ?string $body = null): self
    {
        $path = (string) parse_url($uri, PHP_URL_PATH);
        parse_str((string) parse_url($uri, PHP_URL_QUERY), $query);
        $server += ['REMOTE_ADDR' => '127.0.0.1', 'QUERY_STRING' => (string) parse_url($uri, PHP_URL_QUERY)];
        return new self(strtoupper($method), $path === '' ? '/' : $path, $query, $post, $server, $cookies, [], $body);
    }

    public function body(): string
    {
        return $this->rawBody ?? (string) file_get_contents('php://input');
    }

    public function json(): array
    {
        $data = json_decode($this->body(), true);
        return is_array($data) ? $data : [];
    }

    public function input(string $key, mixed $default = null): mixed
    {
        return $this->post[$key] ?? $this->query[$key] ?? $default;
    }

    public function str(string $key, string $default = ''): string
    {
        $value = $this->input($key, $default);
        return is_string($value) ? trim($value) : $default;
    }

    public function header(string $name): ?string
    {
        $key = 'HTTP_' . strtoupper(str_replace('-', '_', $name));
        if ($name === 'Content-Type') {
            return $this->server['CONTENT_TYPE'] ?? $this->server[$key] ?? null;
        }
        return $this->server[$key] ?? null;
    }

    public function cookie(string $name): ?string
    {
        $value = $this->cookies[$name] ?? null;
        return is_string($value) ? $value : null;
    }

    public function ip(): string
    {
        // Detrás de un proxy confiable (Cloudflare/Nginx) se puede usar X-Forwarded-For.
        $ip = $this->server['REMOTE_ADDR'] ?? '0.0.0.0';
        return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : '0.0.0.0';
    }

    public function userAgent(): string
    {
        return mb_substr((string) ($this->server['HTTP_USER_AGENT'] ?? ''), 0, 255);
    }

    public function isGet(): bool
    {
        return $this->method === 'GET' || $this->method === 'HEAD';
    }

    public function isPost(): bool
    {
        return $this->method === 'POST';
    }

    public function wantsJson(): bool
    {
        return str_contains((string) $this->header('Accept'), 'application/json')
            || $this->header('X-Requested-With') === 'fetch';
    }

    public function queryString(): string
    {
        return http_build_query($this->query);
    }

    public function fullPath(): string
    {
        $qs = $this->queryString();
        return $this->path . ($qs !== '' ? '?' . $qs : '');
    }

    public function isSecure(): bool
    {
        return (!empty($this->server['HTTPS']) && $this->server['HTTPS'] !== 'off')
            || ($this->server['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https';
    }
}
