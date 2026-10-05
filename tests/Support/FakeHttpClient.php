<?php

declare(strict_types=1);

namespace Tests\Support;

use App\Core\HttpClient;

/**
 * Cliente HTTP simulado: responde según "MÉTODO patrón-de-URL" y registra las peticiones.
 */
final class FakeHttpClient implements HttpClient
{
    /** @var array<int, array{method:string, pattern:string, status:int, json:mixed}> */
    private array $routes = [];
    /** @var array<int, array{method:string, url:string, headers:array, body:?string}> */
    public array $requests = [];

    public function on(string $method, string $pattern, int $status, mixed $json): self
    {
        array_unshift($this->routes, compact('method', 'pattern', 'status', 'json'));
        return $this;
    }

    public function request(string $method, string $url, array $headers = [], ?string $body = null): array
    {
        $this->requests[] = compact('method', 'url', 'headers', 'body');
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && preg_match($route['pattern'], $url)) {
                $json = is_callable($route['json']) ? ($route['json'])($url, $body) : $route['json'];
                return ['status' => $route['status'], 'body' => (string) json_encode($json), 'json' => is_array($json) ? $json : null];
            }
        }
        return ['status' => 404, 'body' => '{}', 'json' => []];
    }

    public function last(string $pattern): ?array
    {
        foreach (array_reverse($this->requests) as $r) {
            if (preg_match($pattern, $r['url'])) {
                return $r;
            }
        }
        return null;
    }
}
