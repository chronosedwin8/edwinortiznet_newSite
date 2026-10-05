<?php

declare(strict_types=1);

namespace App\Admin;

use App\Core\DB;
use App\Core\Request;
use App\Core\Response;
use App\Services\Media\MediaLibrary;
use RuntimeException;

/**
 * Biblioteca de medios: cuadrícula, subida (también por arrastrar y soltar desde el editor),
 * texto alternativo y borrado protegido si la imagen está en uso.
 */
final class MediaController extends AdminBase
{
    private const PER_PAGE = 48;

    public function index(Request $request): Response
    {
        $this->requireAdmin($request);
        $q = trim($request->str('q'));
        $page = max(1, (int) $request->input('page', 1));
        $result = MediaLibrary::search($q, $page, self::PER_PAGE);
        return $this->view('media/index', [
            'items' => $result['items'],
            'total' => $result['total'],
            'page' => $page,
            'pages' => max(1, (int) ceil($result['total'] / self::PER_PAGE)),
            'q' => $q,
        ], t('admin.media'));
    }

    /** Listado JSON para el selector de imágenes del editor. */
    public function api(Request $request): Response
    {
        $this->requireAdmin($request);
        $result = MediaLibrary::search(trim($request->str('q')), max(1, (int) $request->input('page', 1)), 30);
        return Response::json($result)->header('Cache-Control', 'private, no-store');
    }

    public function upload(Request $request): Response
    {
        $this->requireAdmin($request);
        $files = self::normalize($request->files['files'] ?? $request->files['file'] ?? null);
        $stored = [];
        $errors = [];
        foreach ($files as $file) {
            try {
                $stored[] = MediaLibrary::store($file, self::str($request, 'alt', 255));
            } catch (RuntimeException $e) {
                $errors[] = t('admin.media.error.' . $e->getMessage(), ['name' => (string) ($file['name'] ?? '')]);
            }
        }
        if ($files === []) {
            $errors[] = t('admin.media.error.upload', ['name' => '']);
        }
        if ($request->wantsJson()) {
            return Response::json(['items' => $stored, 'errors' => $errors], $stored === [] ? 422 : 200);
        }
        return $errors ? $this->fail('/admin/medios/', implode(' ', $errors)) : $this->back('/admin/medios/', t('admin.media.uploaded', ['n' => count($stored)]));
    }

    public function update(Request $request, string $id): Response
    {
        $this->requireAdmin($request);
        DB::update('media', ['alt' => self::str($request, 'alt', 255)], ['id' => (int) $id]);
        if ($request->wantsJson()) {
            return Response::json(['ok' => true, 'item' => MediaLibrary::find((int) $id)]);
        }
        return $this->back('/admin/medios/', t('admin.saved_short'));
    }

    public function delete(Request $request, string $id): Response
    {
        $this->requireAdmin($request);
        $media = MediaLibrary::find((int) $id);
        if ($media !== null && ($uses = MediaLibrary::usage($media)) > 0 && empty($request->post['force'])) {
            return $this->fail('/admin/medios/', t('admin.media.in_use', ['n' => $uses]));
        }
        MediaLibrary::delete((int) $id);
        $this->saved();
        return $this->back('/admin/medios/', t('admin.deleted'));
    }

    /** $_FILES con varios archivos llega "por columnas"; se convierte a una lista de archivos. */
    private static function normalize(mixed $files): array
    {
        if (!is_array($files) || !isset($files['name'])) {
            return [];
        }
        if (!is_array($files['name'])) {
            return [$files];
        }
        $out = [];
        foreach (array_keys($files['name']) as $i) {
            $out[] = ['name' => $files['name'][$i], 'tmp_name' => $files['tmp_name'][$i], 'error' => $files['error'][$i], 'size' => $files['size'][$i]];
        }
        return $out;
    }
}
