<?php

declare(strict_types=1);

namespace App\Services\Examenes;

use App\Core\Config;
use App\Core\DB;
use App\Core\Logger;
use App\Services\Storage\S3;

/**
 * Perfil docente del Generador de exámenes: aceptación de términos, institución, nombre para el encabezado y logo.
 * El logo se valida con getimagesize, se vuelve a codificar como PNG (máx. 600×300) y queda privado:
 * en S3 (examenes/logos/…) si está activo, o en storage/examenes/logos/.
 */
final class ExamProfile
{
    public const LOGO_MAX_BYTES = 1048576;

    public static function get(int $customerId): ?array
    {
        return DB::one('SELECT * FROM exam_profiles WHERE customer_id = :c', ['c' => $customerId]);
    }

    public static function ensure(int $customerId): void
    {
        DB::run('INSERT IGNORE INTO exam_profiles (customer_id) VALUES (:c)', ['c' => $customerId]);
    }

    public static function acceptTerms(int $customerId): void
    {
        self::ensure($customerId);
        DB::run('UPDATE exam_profiles SET terms_accepted_at = :now WHERE customer_id = :c AND terms_accepted_at IS NULL', ['now' => DB::now(), 'c' => $customerId]);
    }

    public static function save(int $customerId, string $institution, string $teacher): void
    {
        self::ensure($customerId);
        DB::update('exam_profiles', [
            'institution' => $institution !== '' ? mb_substr($institution, 0, 190) : null,
            'teacher' => $teacher !== '' ? mb_substr($teacher, 0, 120) : null,
        ], ['customer_id' => $customerId]);
    }

    /**
     * Valida y guarda el logo subido. Devuelve la clave del error (lang examenes.profile.logo_*) o null.
     * @param array{tmp_name?:string, error?:int, size?:int} $file
     */
    public static function saveLogo(int $customerId, array $file): ?string
    {
        $err = (int) ($file['error'] ?? UPLOAD_ERR_NO_FILE);
        if ($err === UPLOAD_ERR_INI_SIZE || $err === UPLOAD_ERR_FORM_SIZE) {
            return 'logo_size';
        }
        $tmp = (string) ($file['tmp_name'] ?? '');
        if ($err !== UPLOAD_ERR_OK || $tmp === '' || !is_file($tmp)) {
            return 'logo_invalid';
        }
        if (filesize($tmp) > self::LOGO_MAX_BYTES) {
            return 'logo_size';
        }
        $info = @getimagesize($tmp);
        $types = [IMAGETYPE_PNG => 'imagecreatefrompng', IMAGETYPE_JPEG => 'imagecreatefromjpeg', IMAGETYPE_WEBP => 'imagecreatefromwebp'];
        if ($info === false || !isset($types[$info[2]]) || $info[0] < 16 || $info[1] < 16 || $info[0] > 6000 || $info[1] > 6000) {
            return 'logo_invalid';
        }
        $src = @($types[$info[2]])($tmp);
        if ($src === false) {
            return 'logo_invalid';
        }
        $png = self::encodePng($src, (int) $info[0], (int) $info[1]);
        $profile = self::get($customerId);
        $key = 'examenes/logos/' . $customerId . '-' . bin2hex(random_bytes(8)) . '.png';
        try {
            if (S3::enabled()) {
                $tmpPng = tempnam(sys_get_temp_dir(), 'exlogo');
                file_put_contents((string) $tmpPng, $png);
                try {
                    S3::put($key, (string) $tmpPng, 'image/png', false);
                } finally {
                    @unlink((string) $tmpPng);
                }
                $disk = 's3';
            } else {
                $dir = Config::storage('examenes/logos');
                if (!is_dir($dir)) {
                    mkdir($dir, 0770, true);
                }
                file_put_contents($dir . '/' . basename($key), $png);
                $disk = 'local';
            }
        } catch (\Throwable $e) {
            Logger::error('No se pudo guardar el logo del examen', ['customer' => $customerId, 'error' => $e->getMessage()]);
            return 'logo_failed';
        }
        self::ensure($customerId);
        DB::update('exam_profiles', ['logo_key' => $key, 'logo_disk' => $disk], ['customer_id' => $customerId]);
        if ($profile !== null && !empty($profile['logo_key'])) {
            self::deleteFile((string) $profile['logo_key'], (string) $profile['logo_disk']);
        }
        return null;
    }

    public static function removeLogo(int $customerId): void
    {
        $profile = self::get($customerId);
        if ($profile !== null && !empty($profile['logo_key'])) {
            self::deleteFile((string) $profile['logo_key'], (string) $profile['logo_disk']);
            DB::update('exam_profiles', ['logo_key' => null, 'logo_disk' => null], ['customer_id' => $customerId]);
        }
    }

    /** Bytes PNG del logo, o null. */
    public static function logoData(?array $profile): ?string
    {
        if ($profile === null || empty($profile['logo_key'])) {
            return null;
        }
        $key = (string) $profile['logo_key'];
        try {
            if ($profile['logo_disk'] === 's3') {
                return S3::get($key);
            }
            $file = Config::storage('examenes/logos/' . basename($key));
            return is_file($file) ? (string) file_get_contents($file) : null;
        } catch (\Throwable $e) {
            Logger::warning('No se pudo leer el logo del examen', ['error' => $e->getMessage()]);
            return null;
        }
    }

    private static function deleteFile(string $key, string $disk): void
    {
        try {
            if ($disk === 's3') {
                S3::delete($key);
            } else {
                @unlink(Config::storage('examenes/logos/' . basename($key)));
            }
        } catch (\Throwable $e) {
            Logger::warning('No se pudo borrar el logo anterior del examen', ['error' => $e->getMessage()]);
        }
    }

    private static function encodePng(\GdImage $src, int $w, int $h): string
    {
        $scale = min(1, 600 / $w, 300 / $h);
        $nw = max(1, (int) round($w * $scale));
        $nh = max(1, (int) round($h * $scale));
        $dst = imagecreatetruecolor($nw, $nh);
        imagealphablending($dst, false);
        imagesavealpha($dst, true);
        imagefilledrectangle($dst, 0, 0, $nw, $nh, imagecolorallocatealpha($dst, 255, 255, 255, 127));
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);
        ob_start();
        imagepng($dst, null, 9);
        return (string) ob_get_clean();
    }
}
