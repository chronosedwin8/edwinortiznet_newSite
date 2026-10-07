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
 * .env: GEMINI_API_KEY y GEMINI_MODEL (por defecto gemini-2.5-pro).
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

    /** Pruebas: sustituye la red. Recibe (url, cabeceras, cuerpo decodificado) y devuelve ['status', 'body']. */
    public static function fake(?callable $transport): void
    {
        self::$transport = $transport;
    }

    /**
     * Genera JSON según $schema. Lanza RuntimeException con un mensaje seguro (sin secretos).
     * @return array{data: array, model: string, prompt_tokens: int, output_tokens: int}
     */
    public static function generateJson(string $system, string $user, array $schema, float $temperature = 0.6, int $maxTokens = 16384): array
    {
        if (!self::configured()) {
            throw new RuntimeException('Gemini no está configurado (GEMINI_API_KEY).');
        }
        $model = self::model();
        $generation = [
            'responseMimeType' => 'application/json',
            'responseSchema' => $schema,
            'temperature' => $temperature,
            'maxOutputTokens' => $maxTokens,
        ];
        // En 2.5 el razonamiento consume del mismo tope de salida: se acota para que el JSON no quede truncado.
        if (str_starts_with($model, 'gemini-2.5')) {
            $generation['thinkingConfig'] = ['thinkingBudget' => 4096];
        }
        $body = [
            'systemInstruction' => ['parts' => [['text' => $system]]],
            'contents' => [['role' => 'user', 'parts' => [['text' => $user]]]],
            'generationConfig' => $generation,
        ];
        $url = self::BASE . rawurlencode($model) . ':generateContent';
        $headers = ['Content-Type: application/json', 'x-goog-api-key: ' . Config::get('GEMINI_API_KEY', '')];

        $started = microtime(true);
        $res = self::$transport !== null ? (self::$transport)($url, $headers, $body) : self::post($url, $headers, $body);
        $seconds = round(microtime(true) - $started, 1);

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
        if ($text === '') {
            Logger::error('Gemini no devolvió texto', ['finish' => $finish, 'block' => $json['promptFeedback']['blockReason'] ?? null, 'model' => $model]);
            throw new RuntimeException('El servicio de IA no devolvió contenido' . ($finish !== '' ? " ($finish)" : '') . '.');
        }
        $data = json_decode(self::stripFences($text), true);
        if (!is_array($data)) {
            Logger::error('Gemini devolvió JSON inválido', ['finish' => $finish, 'chars' => mb_strlen($text), 'model' => $model]);
            throw new RuntimeException($finish === 'MAX_TOKENS' ? 'La respuesta de la IA quedó incompleta.' : 'La respuesta de la IA no tiene el formato esperado.');
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

    /** @return array{status:int, body:string} */
    private static function post(string $url, array $headers, array $body): array
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
