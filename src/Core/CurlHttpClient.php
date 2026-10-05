<?php

declare(strict_types=1);

namespace App\Core;

final class CurlHttpClient implements HttpClient
{
    public function __construct(private readonly int $timeout = 20)
    {
    }

    public function request(string $method, string $url, array $headers = [], ?string $body = null): array
    {
        $ch = curl_init($url);
        $headerLines = [];
        foreach ($headers as $name => $value) {
            $headerLines[] = "$name: $value";
        }
        curl_setopt_array($ch, [
            CURLOPT_CUSTOMREQUEST => strtoupper($method),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headerLines,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_USERAGENT => 'edwinortiz.net/1.0',
        ]);
        if ($body !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        }
        $response = curl_exec($ch);
        $status = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        if ($response === false) {
            Logger::error('HTTP falló', ['url' => preg_replace('#\?.*#', '', $url), 'error' => $error]);
            return ['status' => 0, 'body' => '', 'json' => null];
        }
        $json = json_decode((string) $response, true);
        return ['status' => $status, 'body' => (string) $response, 'json' => is_array($json) ? $json : null];
    }
}
