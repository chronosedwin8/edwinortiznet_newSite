<?php

declare(strict_types=1);

namespace App\Services\Storage;

use App\Core\Config;
use RuntimeException;

/**
 * Cliente mínimo de Amazon S3 (firma Signature V4) para guardar los archivos que se suben desde el panel:
 * imágenes públicas (ACL public-read) y archivos de producto privados, que se entregan con URL firmada.
 *
 * .env: STORAGE_DISK=s3, AWS_S3_BUCKET, AWS_S3_REGION, AWS_S3_KEY, AWS_S3_SECRET y, opcional, AWS_S3_PUBLIC_URL.
 */
final class S3
{
    /** @var (callable(string, string, array, ?string): array{status:int, body:string})|null */
    private static $transport = null;

    /** Las subidas nuevas van a S3. */
    public static function enabled(): bool
    {
        return Config::get('STORAGE_DISK', 'local') === 's3' && self::configured();
    }

    /** Hay credenciales para leer o firmar lo que ya está en el bucket. */
    public static function configured(): bool
    {
        return Config::get('AWS_S3_BUCKET') && Config::get('AWS_S3_KEY') && Config::get('AWS_S3_SECRET');
    }

    /** Pruebas: sustituye la red. Recibe (método, url, cabeceras, archivo a subir o null). */
    public static function fake(?callable $transport): void
    {
        self::$transport = $transport;
    }

    public static function publicUrl(string $key): string
    {
        $base = rtrim((string) Config::get('AWS_S3_PUBLIC_URL', 'https://' . self::host()), '/');
        return $base . '/' . self::encodeKey($key);
    }

    /** Clave del objeto si la URL pertenece a este bucket; null si no. */
    public static function keyFromUrl(string $url): ?string
    {
        foreach (array_unique([rtrim((string) Config::get('AWS_S3_PUBLIC_URL', ''), '/'), 'https://' . self::host()]) as $base) {
            if ($base !== '' && str_starts_with($url, $base . '/')) {
                return rawurldecode(substr($url, strlen($base) + 1));
            }
        }
        return null;
    }

    /** Sube un archivo local. $public = lectura pública (imágenes); si no, el objeto queda privado. */
    public static function put(string $key, string $file, string $contentType, bool $public, ?string $cacheControl = null): void
    {
        $headers = ['content-type' => $contentType];
        if ($public) {
            $headers['x-amz-acl'] = 'public-read';
        }
        if ($cacheControl !== null) {
            $headers['cache-control'] = $cacheControl;
        }
        $res = self::send('PUT', $key, '', $headers, $file);
        if ($res['status'] !== 200) {
            throw new RuntimeException('S3 PUT ' . $key . ': HTTP ' . $res['status'] . ' ' . self::error($res['body']));
        }
    }

    public static function delete(string $key): void
    {
        $res = self::send('DELETE', $key);
        if (!in_array($res['status'], [200, 204, 404], true)) {
            throw new RuntimeException('S3 DELETE ' . $key . ': HTTP ' . $res['status'] . ' ' . self::error($res['body']));
        }
    }

    /** Contenido de un objeto (privado o público), o null si no existe. */
    public static function get(string $key): ?string
    {
        $res = self::send('GET', $key);
        if ($res['status'] === 404) {
            return null;
        }
        if ($res['status'] !== 200) {
            throw new RuntimeException('S3 GET ' . $key . ': HTTP ' . $res['status'] . ' ' . self::error($res['body']));
        }
        return $res['body'];
    }

    /** Tamaño en bytes del objeto, o null si no existe. */
    public static function size(string $key): ?int
    {
        $res = self::send('HEAD', $key);
        if ($res['status'] !== 200) {
            return null;
        }
        return isset($res['headers']['content-length']) ? (int) $res['headers']['content-length'] : 0;
    }

    /** URL temporal para descargar un objeto privado (con nombre de archivo sugerido). */
    public static function presignedGet(string $key, int $seconds = 300, ?string $downloadName = null, ?int $now = null): string
    {
        $now ??= time();
        $time = gmdate('Ymd\THis\Z', $now);
        $date = substr($time, 0, 8);
        $region = self::region();
        $scope = "$date/$region/s3/aws4_request";
        $query = [
            'X-Amz-Algorithm' => 'AWS4-HMAC-SHA256',
            'X-Amz-Credential' => Config::get('AWS_S3_KEY') . '/' . $scope,
            'X-Amz-Date' => $time,
            'X-Amz-Expires' => (string) $seconds,
            'X-Amz-SignedHeaders' => 'host',
        ];
        if ($downloadName !== null) {
            $safe = str_replace(['"', "\r", "\n"], '', $downloadName);
            $query['response-content-disposition'] = 'attachment; filename="' . $safe . '"; filename*=UTF-8\'\'' . rawurlencode($downloadName);
        }
        ksort($query);
        $qs = implode('&', array_map(fn ($k, $v) => rawurlencode($k) . '=' . rawurlencode($v), array_keys($query), $query));
        $path = '/' . self::encodeKey($key);
        $canonical = "GET\n$path\n$qs\nhost:" . self::host() . "\n\nhost\nUNSIGNED-PAYLOAD";
        $toSign = "AWS4-HMAC-SHA256\n$time\n$scope\n" . hash('sha256', $canonical);
        $signature = hash_hmac('sha256', $toSign, self::signingKey($date, $region));
        return 'https://' . self::host() . $path . '?' . $qs . '&X-Amz-Signature=' . $signature;
    }

    // ------------------------------------------------------------------

    /** @return array{status:int, body:string, headers:array<string,string>} */
    private static function send(string $method, string $key, string $query = '', array $headers = [], ?string $file = null): array
    {
        $time = gmdate('Ymd\THis\Z');
        $date = substr($time, 0, 8);
        $region = self::region();
        $headers = array_change_key_case($headers + [
            'host' => self::host(),
            'x-amz-date' => $time,
            'x-amz-content-sha256' => 'UNSIGNED-PAYLOAD',
        ], CASE_LOWER);
        ksort($headers);
        $canonicalHeaders = '';
        foreach ($headers as $k => $v) {
            $canonicalHeaders .= $k . ':' . trim((string) $v) . "\n";
        }
        $signed = implode(';', array_keys($headers));
        $path = '/' . self::encodeKey($key);
        $canonical = "$method\n$path\n$query\n$canonicalHeaders\n$signed\nUNSIGNED-PAYLOAD";
        $scope = "$date/$region/s3/aws4_request";
        $toSign = "AWS4-HMAC-SHA256\n$time\n$scope\n" . hash('sha256', $canonical);
        $signature = hash_hmac('sha256', $toSign, self::signingKey($date, $region));
        $headers['authorization'] = 'AWS4-HMAC-SHA256 Credential=' . Config::get('AWS_S3_KEY') . "/$scope, SignedHeaders=$signed, Signature=$signature";
        $url = 'https://' . self::host() . $path . ($query !== '' ? '?' . $query : '');

        if (self::$transport !== null) {
            return (self::$transport)($method, $url, $headers, $file) + ['headers' => []];
        }

        $lines = [];
        foreach ($headers as $k => $v) {
            if ($k !== 'host') {
                $lines[] = "$k: $v";
            }
        }
        $responseHeaders = [];
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $lines,
            CURLOPT_TIMEOUT => 600,
            CURLOPT_HEADERFUNCTION => static function ($ch, string $line) use (&$responseHeaders): int {
                $parts = explode(':', $line, 2);
                if (count($parts) === 2) {
                    $responseHeaders[strtolower(trim($parts[0]))] = trim($parts[1]);
                }
                return strlen($line);
            },
        ]);
        $fh = null;
        if ($method === 'HEAD') {
            curl_setopt($ch, CURLOPT_NOBODY, true);
        }
        if ($file !== null) {
            $fh = fopen($file, 'rb');
            curl_setopt_array($ch, [CURLOPT_UPLOAD => true, CURLOPT_INFILE => $fh, CURLOPT_INFILESIZE => filesize($file)]);
        }
        $body = curl_exec($ch);
        $status = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        $err = curl_error($ch);
        curl_close($ch);
        if ($fh !== null) {
            fclose($fh);
        }
        if ($body === false) {
            throw new RuntimeException('S3 sin conexión: ' . $err);
        }
        return ['status' => $status, 'body' => (string) $body, 'headers' => $responseHeaders];
    }

    private static function signingKey(string $date, string $region): string
    {
        $k = 'AWS4' . Config::get('AWS_S3_SECRET');
        foreach ([$date, $region, 's3', 'aws4_request'] as $part) {
            $k = hash_hmac('sha256', $part, $k, true);
        }
        return $k;
    }

    private static function region(): string
    {
        return (string) Config::get('AWS_S3_REGION', 'us-east-1');
    }

    private static function host(): string
    {
        $bucket = (string) Config::get('AWS_S3_BUCKET');
        $region = self::region();
        return $region === 'us-east-1' ? "$bucket.s3.amazonaws.com" : "$bucket.s3.$region.amazonaws.com";
    }

    private static function encodeKey(string $key): string
    {
        return implode('/', array_map('rawurlencode', explode('/', ltrim($key, '/'))));
    }

    private static function error(string $xml): string
    {
        return preg_match('#<Code>([^<]+)</Code>#', $xml, $m) ? $m[1] : '';
    }
}
