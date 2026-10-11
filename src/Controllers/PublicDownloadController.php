<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Services\Storage\PublicDownloads;

/**
 * /descargas/<ruta>: archivos gratuitos de artículos y herramientas. En producción redirige al objeto
 * público en S3; en desarrollo (sin S3) entrega la copia de storage/descargas/.
 */
final class PublicDownloadController extends Controller
{
    public function show(Request $request, string $path): Response
    {
        $path = PublicDownloads::normalize($path);
        if ($path === null) {
            $this->notFound();
        }
        $remote = PublicDownloads::remoteUrl($path);
        if ($remote !== null) {
            return Response::redirect($remote, 302);
        }
        $file = PublicDownloads::localFile($path);
        if ($file === null) {
            $this->notFound();
        }
        return new Response((string) file_get_contents($file), 200, [
            'Content-Type' => PublicDownloads::contentType($path),
            'Content-Disposition' => 'attachment; filename="' . basename($path) . '"',
            'Content-Length' => (string) filesize($file),
            'Cache-Control' => 'no-store',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}
