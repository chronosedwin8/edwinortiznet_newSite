<?php

declare(strict_types=1);

namespace App\Services\Social;

use App\Core\Config;
use App\Core\Logger;

/**
 * Cliente mínimo de la Graph API de Meta (Facebook e Instagram) con cURL.
 *
 * - El token va como parámetro access_token (en el cuerpo en los POST); nunca se registra: los registros
 *   solo llevan el método, la ruta sin consulta, el código HTTP y el código de error de la API.
 * - Las pruebas sustituyen la red con MetaClient::fake(fn (string $method, string $url, array $params) => ['status' => 200, 'body' => '{…}']).
 */
final class MetaClient
{
    /** @var (callable(string, string, array): array{status:int, body:string})|null */
    private static $transport = null;

    public function __construct(private readonly string $base)
    {
    }

    public static function graph(): self
    {
        $version = (string) Config::get('META_GRAPH_VERSION', 'v23.0');
        return new self('https://graph.facebook.com/' . (preg_match('/^v\d{1,2}\.\d$/', $version) ? $version : 'v23.0'));
    }

    /** Pruebas: sustituye la red (null la restablece). */
    public static function fake(?callable $transport): void
    {
        self::$transport = $transport;
    }

    public function get(string $path, array $params = [], ?string $token = null): array
    {
        return $this->call('GET', $path, $params, $token);
    }

    public function post(string $path, array $params = [], ?string $token = null): array
    {
        return $this->call('POST', $path, $params, $token);
    }

    public function delete(string $path, ?string $token = null): array
    {
        return $this->call('DELETE', $path, [], $token);
    }

    private function call(string $method, string $path, array $params, ?string $token): array
    {
        if ($token !== null) {
            $params['access_token'] = $token;
        }
        $url = $this->base . '/' . ltrim($path, '/');
        $res = self::$transport !== null ? (self::$transport)($method, $url, $params) : $this->send($method, $url, $params);
        $status = (int) $res['status'];
        $json = json_decode((string) $res['body'], true);
        if ($status >= 200 && $status < 300 && is_array($json) && !isset($json['error'])) {
            return $json;
        }
        $error = is_array($json) ? (array) ($json['error'] ?? []) : [];
        $code = (int) ($error['code'] ?? 0);
        $sub = (int) ($error['error_subcode'] ?? 0);
        $message = self::scrub((string) ($error['error_user_msg'] ?? $error['message'] ?? ''));
        if ($status === 0) {
            $message = 'No se pudo conectar con ' . (string) parse_url($this->base, PHP_URL_HOST) . '.';
        }
        Logger::warning('API de Meta respondió con error', [
            'method' => $method, 'path' => (string) parse_url($url, PHP_URL_PATH), 'http' => $status, 'code' => $code, 'subcode' => $sub,
            'message' => mb_substr($message, 0, 200),
        ]);
        $transient = $status === 0 || $status >= 500 || !empty($error['is_transient']) || in_array($code, [1, 2, 4, 17, 32, 341, 368, 613], true);
        throw new MetaException($message !== '' ? $message : 'La API respondió con HTTP ' . $status . '.', $status, $code, $sub, $transient);
    }

    /** Quita del texto cualquier cosa que parezca un token (Meta a veces repite parámetros en sus mensajes). */
    public static function scrub(string $text): string
    {
        $text = (string) preg_replace('/\b(EAA|IG)[A-Za-z0-9_\-]{30,}\b/', '[token]', $text);
        $text = (string) preg_replace('/access_token=[^&\s"]+/', 'access_token=[token]', $text);
        return (string) preg_replace('/\b[A-Za-z0-9_\-]{80,}\b/', '[…]', $text);
    }

    /** @return array{status:int, body:string} */
    private function send(string $method, string $url, array $params): array
    {
        $ch = curl_init();
        $options = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_USERAGENT => 'edwinortiz.net/1.0',
            CURLOPT_CUSTOMREQUEST => $method,
        ];
        if ($method === 'GET' || $method === 'DELETE') {
            $options[CURLOPT_URL] = $url . ($params !== [] ? '?' . http_build_query($params) : '');
        } else {
            $options[CURLOPT_URL] = $url;
            $options[CURLOPT_POSTFIELDS] = http_build_query($params);
            $options[CURLOPT_HTTPHEADER] = ['Content-Type: application/x-www-form-urlencoded'];
        }
        curl_setopt_array($ch, $options);
        $body = curl_exec($ch);
        $status = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        if ($body === false) {
            Logger::error('API de Meta sin conexión', ['path' => (string) parse_url($url, PHP_URL_PATH), 'error' => $error]);
            return ['status' => 0, 'body' => ''];
        }
        return ['status' => $status, 'body' => (string) $body];
    }
}
