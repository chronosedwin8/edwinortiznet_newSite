<?php

declare(strict_types=1);

namespace App\Core;

final class Response
{
    public bool $cacheable = false;
    /** @var callable|null */
    public $streamer = null;

    public function __construct(
        public string $body = '',
        public int $status = 200,
        public array $headers = [],
    ) {
    }

    public static function html(string $body, int $status = 200): self
    {
        return new self($body, $status, ['Content-Type' => 'text/html; charset=UTF-8']);
    }

    public static function json(mixed $data, int $status = 200): self
    {
        return new self(
            (string) json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            $status,
            ['Content-Type' => 'application/json; charset=UTF-8', 'Cache-Control' => 'no-store']
        );
    }

    public static function text(string $body, int $status = 200, string $type = 'text/plain'): self
    {
        return new self($body, $status, ['Content-Type' => $type . '; charset=UTF-8']);
    }

    public static function redirect(string $url, int $status = 302): self
    {
        return new self('', $status, ['Location' => $url, 'Cache-Control' => 'no-store']);
    }

    public function header(string $name, string $value): self
    {
        $this->headers[$name] = $value;
        return $this;
    }

    public function cache(bool $cacheable = true): self
    {
        $this->cacheable = $cacheable;
        return $this;
    }

    public function send(Request $request): void
    {
        if ($this->streamer === null && $this->status === 200 && $request->isGet() && $this->body !== '') {
            $etag = $this->headers['ETag'] ?? '"' . substr(hash('xxh128', $this->body), 0, 32) . '"';
            $this->headers['ETag'] = $etag;
            if (trim((string) $request->header('If-None-Match')) === $etag) {
                $this->status = 304;
                $this->body = '';
            }
        }
        if (!headers_sent()) {
            http_response_code($this->status);
            foreach ($this->headers as $name => $value) {
                if (is_array($value)) {
                    foreach ($value as $v) {
                        header("$name: $v", false);
                    }
                } else {
                    header("$name: $value");
                }
            }
        }
        if ($this->streamer !== null) {
            ($this->streamer)();
            return;
        }
        if ($request->method !== 'HEAD') {
            echo $this->body;
        }
    }
}
