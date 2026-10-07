<?php

declare(strict_types=1);

namespace App\Services\Downloads;

use App\Core\Config;
use App\Core\DB;
use App\Core\Request;
use App\Core\Response;
use App\Services\Storage\S3;

/**
 * Permisos de descarga (30 días, 5 descargas) y entrega del archivo: desde S3 con una URL firmada de pocos
 * minutos (storage_disk = s3) o desde storage/downloads (local). Nunca con una URL pública permanente.
 */
final class DownloadService
{
    /** Prefijo de los archivos de producto dentro del bucket (objetos privados). */
    public const S3_PREFIX = 'descargas/';
    /** Vigencia de la URL firmada de S3: basta para empezar la descarga. */
    private const S3_LINK_SECONDS = 300;

    public static function maxDownloads(): int
    {
        return max(1, Config::int('DOWNLOAD_MAX', 5));
    }

    public static function days(): int
    {
        return max(1, Config::int('DOWNLOAD_DAYS', 30));
    }

    public static function path(string $storagePath): string
    {
        return Config::storage('downloads/' . ltrim(str_replace(['..', '\\'], ['', '/'], $storagePath), '/'));
    }

    /** Ruta sugerida dentro de storage/downloads para un archivo de producto. */
    public static function expectedPath(array $file, string $productSlug): string
    {
        $name = basename(rawurldecode((string) parse_url((string) $file['source_url'], PHP_URL_PATH)));
        return $productSlug . '/' . ($name !== '' ? $name : 'archivo.zip');
    }

    public static function createGrants(int $orderId, bool $revokePrevious = false): int
    {
        if ($revokePrevious) {
            self::revokeGrants($orderId);
        }
        $items = DB::all(
            'SELECT oi.id, oi.product_id, oi.variant FROM order_items oi JOIN products p ON p.id = oi.product_id WHERE oi.order_id = :o AND p.type = "download"',
            ['o' => $orderId]
        );
        $count = 0;
        foreach ($items as $item) {
            // Archivos sin variante: para todos. Con variante: solo para quien compró esa variante.
            $files = DB::all(
                'SELECT id FROM product_files WHERE product_id = :p AND (variant IS NULL OR variant = "" OR variant = :v) ORDER BY id',
                ['p' => (int) $item['product_id'], 'v' => (string) ($item['variant'] ?? '')]
            );
            foreach ($files as $file) {
                $active = DB::value(
                    'SELECT id FROM download_grants WHERE order_item_id = :i AND product_file_id = :f AND revoked_at IS NULL AND expires_at > UTC_TIMESTAMP() AND downloads < max_downloads',
                    ['i' => (int) $item['id'], 'f' => (int) $file['id']]
                );
                if ($active !== null) {
                    continue;
                }
                DB::insert('download_grants', [
                    'order_item_id' => (int) $item['id'],
                    'product_file_id' => (int) $file['id'],
                    'token' => bin2hex(random_bytes(32)),
                    'max_downloads' => self::maxDownloads(),
                    'downloads' => 0,
                    'expires_at' => gmdate('Y-m-d H:i:s', time() + self::days() * 86400),
                ]);
                $count++;
            }
        }
        return $count;
    }

    public static function revokeGrants(int $orderId): void
    {
        DB::run(
            'UPDATE download_grants g JOIN order_items oi ON oi.id = g.order_item_id SET g.revoked_at = UTC_TIMESTAMP() WHERE oi.order_id = :o AND g.revoked_at IS NULL',
            ['o' => $orderId]
        );
    }

    /** Descargas vigentes de un pedido aprobado. */
    public static function forOrder(int $orderId): array
    {
        return DB::all(
            'SELECT g.token, g.downloads, g.max_downloads, g.expires_at, pf.label, pf.storage_path, oi.title
             FROM download_grants g
             JOIN order_items oi ON oi.id = g.order_item_id
             JOIN orders o ON o.id = oi.order_id AND o.status = "approved"
             LEFT JOIN product_files pf ON pf.id = g.product_file_id
             WHERE oi.order_id = :o AND g.revoked_at IS NULL
             ORDER BY g.id',
            ['o' => $orderId]
        );
    }

    /**
     * Valida el token y entrega el archivo. Devuelve null si el enlace no es válido.
     * @return Response|string|null string = clave de error de i18n
     */
    public static function serve(string $token, Request $request): Response|string|null
    {
        return DB::transaction(function () use ($token, $request): Response|string|null {
            $grant = DB::one(
                'SELECT g.*, pf.storage_path, pf.storage_disk, pf.label, o.status AS order_status
                 FROM download_grants g
                 JOIN order_items oi ON oi.id = g.order_item_id
                 JOIN orders o ON o.id = oi.order_id
                 LEFT JOIN product_files pf ON pf.id = g.product_file_id
                 WHERE g.token = :t FOR UPDATE',
                ['t' => $token]
            );
            if ($grant === null) {
                return null;
            }
            if ($grant['order_status'] !== 'approved' || $grant['revoked_at'] !== null
                || strtotime($grant['expires_at'] . ' UTC') < time() || (int) $grant['downloads'] >= (int) $grant['max_downloads']) {
                return 'download.expired';
            }
            $inS3 = ($grant['storage_disk'] ?? 'local') === 's3';
            if (empty($grant['storage_path']) || ($inS3 ? !S3::configured() : !is_file(self::path((string) $grant['storage_path'])))) {
                return 'download.unavailable';
            }
            DB::run('UPDATE download_grants SET downloads = downloads + 1 WHERE id = :id', ['id' => (int) $grant['id']]);
            DB::insert('download_log', ['grant_id' => (int) $grant['id'], 'ip' => $request->ip(), 'user_agent' => $request->userAgent()]);
            if ($inS3) {
                $url = S3::presignedGet(self::S3_PREFIX . $grant['storage_path'], self::S3_LINK_SECONDS, basename((string) $grant['storage_path']));
                return Response::redirect($url, 302)
                    ->header('Cache-Control', 'private, no-store')
                    ->header('Referrer-Policy', 'no-referrer')
                    ->header('X-Robots-Tag', 'noindex');
            }
            return self::fileResponse((string) $grant['storage_path']);
        });
    }

    public static function fileResponse(string $storagePath): Response
    {
        $file = self::path($storagePath);
        $name = basename($file);
        $response = new Response('', 200, [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="' . str_replace('"', '', $name) . '"; filename*=UTF-8\'\'' . rawurlencode($name),
            'Cache-Control' => 'private, no-store',
            'X-Robots-Tag' => 'noindex',
        ]);
        if (Config::bool('DOWNLOAD_ACCEL')) {
            // Nginx entrega el archivo desde la ubicación interna /protected-downloads/.
            $response->headers['X-Accel-Redirect'] = '/protected-downloads/' . implode('/', array_map('rawurlencode', explode('/', ltrim($storagePath, '/'))));
            return $response;
        }
        $response->headers['Content-Length'] = (string) filesize($file);
        $response->streamer = static function () use ($file): void {
            while (ob_get_level() > 0) {
                ob_end_clean();
            }
            $fh = fopen($file, 'rb');
            if ($fh === false) {
                return;
            }
            while (!feof($fh)) {
                echo fread($fh, 1024 * 256);
                flush();
            }
            fclose($fh);
        };
        return $response;
    }

    /** Productos activos (o pronto) tipo descarga a los que les falta el archivo local. */
    public static function productsWithoutLocalFile(): array
    {
        $rows = DB::all(
            'SELECT p.id, p.wp_id, p.status, t.title, t.slug FROM products p
             JOIN product_translations t ON t.product_id = p.id AND t.locale = "es"
             WHERE p.type = "download" AND p.status IN ("active","hidden") ORDER BY p.status, p.sort, p.id'
        );
        $out = [];
        foreach ($rows as $row) {
            $missing = [];
            $files = DB::all('SELECT * FROM product_files WHERE product_id = :p', ['p' => (int) $row['id']]);
            foreach ($files as $file) {
                $present = !empty($file['storage_path'])
                    && (($file['storage_disk'] ?? 'local') === 's3' || is_file(self::path((string) $file['storage_path'])));
                if (!$present) {
                    $file['expected_path'] = self::expectedPath($file, $row['slug']);
                    $missing[] = $file;
                }
            }
            if ($files === [] || $missing !== []) {
                $row['files'] = $missing;
                $out[] = $row;
            }
        }
        return $out;
    }

    /**
     * Enlaza archivos que ya están en storage/downloads/{slug}/{archivo} con su product_file.
     * @return int archivos enlazados
     */
    public static function linkExisting(): int
    {
        $linked = 0;
        foreach (DB::all('SELECT pf.*, t.slug FROM product_files pf JOIN product_translations t ON t.product_id = pf.product_id AND t.locale = "es"') as $file) {
            $expected = self::expectedPath($file, $file['slug']);
            if (empty($file['storage_path']) && is_file(self::path($expected))) {
                DB::update('product_files', ['storage_path' => $expected, 'bytes' => filesize(self::path($expected))], ['id' => (int) $file['id']]);
                $linked++;
            }
        }
        return $linked;
    }
    /**
     * Copia los archivos desde su URL original (WordPress o S3) a storage/downloads y los enlaza.
     * @return array<int, array{file:string, status:string}>
     */
    public static function fetchMissing(): array
    {
        $out = [];
        foreach (DB::all('SELECT pf.*, t.slug FROM product_files pf JOIN product_translations t ON t.product_id = pf.product_id AND t.locale = "es"') as $file) {
            $expected = self::expectedPath($file, $file['slug']);
            $target = self::path($expected);
            if (!empty($file['storage_path']) && is_file(self::path((string) $file['storage_path']))) {
                $out[] = ['file' => $file['storage_path'], 'status' => 'ok'];
                continue;
            }
            if (!is_file($target) && !empty($file['source_url'])) {
                if (!is_dir(dirname($target))) {
                    mkdir(dirname($target), 0775, true);
                }
                $tmp = $target . '.part';
                $fh = fopen($tmp, 'wb');
                $ch = curl_init((string) $file['source_url']);
                curl_setopt_array($ch, [CURLOPT_FILE => $fh, CURLOPT_FOLLOWLOCATION => true, CURLOPT_TIMEOUT => 300, CURLOPT_USERAGENT => 'edwinortiz.net-migration']);
                $ok = curl_exec($ch);
                $code = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
                $type = (string) curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
                curl_close($ch);
                fclose($fh);
                $head = (string) file_get_contents($tmp, false, null, 0, 512);
                if (!$ok || $code !== 200 || str_contains($type, 'text/html') || stripos($head, '<html') !== false || filesize($tmp) === 0) {
                    @unlink($tmp);
                    $out[] = ['file' => $expected, 'status' => "error HTTP $code ($type)"];
                    continue;
                }
                rename($tmp, $target);
            }
            if (is_file($target)) {
                DB::update('product_files', ['storage_path' => $expected, 'bytes' => filesize($target)], ['id' => (int) $file['id']]);
                $out[] = ['file' => $expected, 'status' => 'descargado'];
            }
        }
        return $out;
    }
}