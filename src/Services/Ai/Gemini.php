<?php

declare(strict_types=1);

namespace App\Services\Ai;

use App\Core\Config;
use App\Core\Logger;
use RuntimeException;

/**
 * Cliente mínimo de la API de Google Gemini (generateContent) con salida JSON estructurada.
 * La clave va en la cabecera x-goog-api-key, nunca en la URL ni en los registros.
 *
 * .env: GEMINI_API_KEY y GEMINI_MODEL (por defecto gemini-2.5-pro); GEMINI_ASSIST_MODEL para textos cortos.
 */
final class Gemini
{
    private const BASE = 'https://generativelanguage.googleapis.com/v1beta/models/';

    /** @var (callable(string, array, array): array{status:int, body:string})|null */
    private static $transport = null;

    public static function configured(): bool
    {
        return (string) Config::get('GEMINI_API_KEY', '') !== '' || self::$transport !== null;
    }

    public static function model(): string
    {
        $model = (string) Config::get('GEMINI_MODEL', 'gemini-2.5-pro');
        return preg_match('/^[a-z0-9.\-]{3,60}$/', $model) ? $model : 'gemini-2.5-pro';
    }

    /** Modelo rápido para el asistente de redacción por campo (por defecto gemini-2.5-flash). */
    public static function assistModel(): string
    {
        $model = (string) Config::get('GEMINI_ASSIST_MODEL', 'gemini-2.5-flash');
        return preg_match('/^[a-z0-9.\-]{3,60}$/', $model) ? $model : 'gemini-2.5-flash';
    }

    /** Pruebas: sustituye la red. Recibe (url, cabeceras, cuerpo decodificado) y devuelve ['status', 'body']. */
    public static function fake(?callable $transport): void
    {
        self::$transport = $transport;
    }

    /**
     * Genera JSON según $schema. Lanza RuntimeException con un mensaje seguro (sin secretos).
     * @return array{data: array, model: string, prompt_tokens: int, output_tokens: int}
     */
    public static function generateJson(string $system, string $user, array $schema, float $temperature = 0.6, int $maxTokens = 16384, ?string $model = null, int $thinking = 4096): array
    {
        if (!self::configured()) {
            throw new RuntimeException('Gemini no está configurado (GEMINI_API_KEY).');
        }
        [$url, $headers, $body, $model] = self::request($system, $user, $schema, $temperature, $maxTokens, $model, $thinking);
        $started = microtime(true);
        $res = self::$transport !== null ? (self::$transport)($url, $headers, $body) : self::post($url, $headers, $body);
        return self::parse($res, $model, round(microtime(true) - $started, 1));
    }

    /**
     * Varias llamadas en paralelo (curl_multi), hasta $concurrency a la vez. Cada solicitud es un arreglo con las
     * claves system, user, schema y, opcionales, temperature, maxTokens, model y thinking. Devuelve, en el mismo
     * orden, el resultado de generateJson() o la RuntimeException de esa llamada (las demás siguen).
     * @param array<int, array<string, mixed>> $requests
     * @return array<int, array|RuntimeException>
     */
    public static function generateJsonMany(array $requests, int $concurrency = 4): array
    {
        if (!self::configured()) {
            throw new RuntimeException('Gemini no está configurado (GEMINI_API_KEY).');
        }
        $prepared = [];
        foreach ($requests as $i => $r) {
            $prepared[$i] = self::request(
                (string) $r['system'], (string) $r['user'], (array) $r['schema'], (float) ($r['temperature'] ?? 0.6),
                (int) ($r['maxTokens'] ?? 16384), $r['model'] ?? null, (int) ($r['thinking'] ?? 4096)
            );
        }
        $out = [];
        if (self::$transport !== null) {
            foreach ($prepared as $i => [$url, $headers, $body, $model]) {
                try {
                    $out[$i] = self::parse((self::$transport)($url, $headers, $body), $model, 0.0);
                } catch (RuntimeException $e) {
                    $out[$i] = $e;
                }
            }
            return $out;
        }
        foreach (array_chunk($prepared, max(1, $concurrency), true) as $group) {
            $multi = curl_multi_init();
            $handles = [];
            $started = microtime(true);
            foreach ($group as $i => [$url, $headers, $body]) {
                $handles[$i] = self::handle($url, $headers, $body);
                curl_multi_add_handle($multi, $handles[$i]);
            }
            do {
                $status = curl_multi_exec($multi, $running);
                if ($running) {
                    curl_multi_select($multi, 1.0);
                }
            } while ($running && $status === CURLM_OK);
            foreach ($handles as $i => $ch) {
                $response = curl_multi_getcontent($ch);
                $code = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
                $error = curl_error($ch);
                curl_multi_remove_handle($multi, $ch);
                curl_close($ch);
                if (!is_string($response) || ($response === '' && $code === 0)) {
                    Logger::error('Gemini sin conexión', ['error' => $error]);
                    $out[$i] = new RuntimeException('No se pudo conectar con el servicio de IA.');
                    continue;
                }
                try {
                    $out[$i] = self::parse(['status' => $code, 'body' => $response], $group[$i][3], round(microtime(true) - $started, 1));
                } catch (RuntimeException $e) {
                    $out[$i] = $e;
                }
            }
            curl_multi_close($multi);
        }
        ksort($out);
        return $out;
    }

    /** @return array{0:string, 1:array, 2:array, 3:string} url, cabeceras, cuerpo y modelo */
    private static function request(string $system, string $user, array $schema, float $temperature, int $maxTokens, ?string $model, int $thinking): array
    {
        $model = $model !== null && preg_match('/^[a-z0-9.\-]{3,60}$/', $model) ? $model : self::model();
        $generation = [
            'responseMimeType' => 'application/json',
            'responseSchema' => $schema,
            'temperature' => $temperature,
            'maxOutputTokens' => $maxTokens,
        ];
        // En 2.5 el razonamiento consume del mismo tope de salida: se acota para que el JSON no quede truncado.
        if (str_starts_with($model, 'gemini-2.5')) {
            $generation['thinkingConfig'] = ['thinkingBudget' => $thinking];
        }
        $body = [
            'systemInstruction' => ['parts' => [['text' => $system]]],
            'contents' => [['role' => 'user', 'parts' => [['text' => $user]]]],
            'generationConfig' => $generation,
        ];
        $url = self::BASE . rawurlencode($model) . ':generateContent';
        $headers = ['Content-Type: application/json', 'x-goog-api-key: ' . Config::get('GEMINI_API_KEY', '')];
        return [$url, $headers, $body, $model];
    }

    /**
     * @param array{status:int, body:string} $res
     * @return array{data: array, model: string, prompt_tokens: int, output_tokens: int}
     */
    private static function parse(array $res, string $model, float $seconds): array
    {
        $json = json_decode((string) $res['body'], true);
        if ((int) $res['status'] !== 200 || !is_array($json)) {
            $message = is_array($json) ? (string) ($json['error']['status'] ?? $json['error']['message'] ?? '') : '';
            Logger::error('Gemini respondió con error', ['http' => $res['status'], 'error' => mb_substr($message, 0, 200), 'model' => $model, 'seconds' => $seconds]);
            throw new RuntimeException('El servicio de IA respondió con un error (HTTP ' . (int) $res['status'] . ').');
        }
        $candidate = $json['candidates'][0] ?? null;
        $finish = (string) ($candidate['finishReason'] ?? '');
        $text = '';
        foreach ((array) ($candidate['content']['parts'] ?? []) as $part) {
            if (is_array($part) && empty($part['thought']) && isset($part['text']) && is_string($part['text'])) {
                $text .= $part['text'];
            }
        }
        $usage = (array) ($json['usageMetadata'] ?? []);
        // Respuesta 200 sin JSON utilizable: se factura igual; la excepción lleva el uso y el texto recibido.
        $billed = static function (string $message) use ($usage, $finish, $text, $model): GeminiException {
            $e = new GeminiException($message);
            $e->billed = true;
            $e->promptTokens = (int) ($usage['promptTokenCount'] ?? 0);
            $e->outputTokens = (int) ($usage['candidatesTokenCount'] ?? 0) + (int) ($usage['thoughtsTokenCount'] ?? 0);
            $e->finish = $finish;
            $e->text = $text;
            $e->model = $model;
            return $e;
        };
        if ($text === '') {
            Logger::error('Gemini no devolvió texto', ['finish' => $finish, 'block' => $json['promptFeedback']['blockReason'] ?? null, 'model' => $model]);
            throw $billed('El servicio de IA no devolvió contenido' . ($finish !== '' ? " ($finish)" : '') . '.');
        }
        $data = json_decode(self::stripFences($text), true);
        if (!is_array($data)) {
            Logger::error('Gemini devolvió JSON inválido', ['finish' => $finish, 'chars' => mb_strlen($text), 'model' => $model]);
            throw $billed($finish === 'MAX_TOKENS' ? 'La respuesta de la IA quedó incompleta.' : 'La respuesta de la IA no tiene el formato esperado.');
        }
        Logger::info('Gemini generó contenido', [
            // (las claves no dicen "token": el registro las ocultaría)
            'model' => $model, 'seconds' => $seconds,
            'usage_in' => $usage['promptTokenCount'] ?? null, 'usage_out' => $usage['candidatesTokenCount'] ?? null,
            'usage_thinking' => $usage['thoughtsTokenCount'] ?? null,
        ]);
        return [
            'data' => $data,
            'model' => (string) ($json['modelVersion'] ?? $model),
            'prompt_tokens' => (int) ($usage['promptTokenCount'] ?? 0),
            'output_tokens' => (int) ($usage['candidatesTokenCount'] ?? 0) + (int) ($usage['thoughtsTokenCount'] ?? 0),
        ];
    }

    private static function stripFences(string $text): string
    {
        $text = trim($text);
        if (str_starts_with($text, '```')) {
            $text = (string) preg_replace('/^```[a-z]*\s*|\s*```$/i', '', $text);
        }
        return $text;
    }

    private static function handle(string $url, array $headers, array $body): \CurlHandle
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POSTFIELDS => (string) json_encode($body, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            CURLOPT_CONNECTTIMEOUT => 15,
            CURLOPT_TIMEOUT => 240,
        ]);
        return $ch;
    }

    /** @return array{status:int, body:string} */
    private static function post(string $url, array $headers, array $body): array
    {
        $ch = self::handle($url, $headers, $body);
        $response = curl_exec($ch);
        $status = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        $error = curl_error($ch);
        if ($response === false) {
            Logger::error('Gemini sin conexión', ['error' => $error]);
            throw new RuntimeException('No se pudo conectar con el servicio de IA.');
        }
        return ['status' => $status, 'body' => (string) $response];
    }
}
