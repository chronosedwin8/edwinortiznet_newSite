<?php

declare(strict_types=1);

use App\Core\DB;

/*
 * Tratamiento editorial del contenido antiguo (sección 6 del plan). No reescribe cuerpos: solo avisos,
 * estados, canonical y redirecciones. Los puntos marcados [DECISIÓN DE EDWIN] están en PENDIENTES.md.
 */
return static function (): string {
    $done = [];

    // 1) Concurso Docente (enero de 2026): aviso fechado al inicio. [DECISIÓN DE EDWIN] revisar el texto.
    $notice = '<p><strong>Actualización del 5 de octubre de 2026:</strong> la CNSC trasladó las inscripciones a enero–febrero de 2027 '
        . 'y las pruebas escritas al segundo semestre de 2027. Las fechas definitivas se publican en '
        . '<a href="https://www.cnsc.gov.co/" rel="noopener" target="_blank">cnsc.gov.co</a>.</p>';
    $contest = DB::column(
        'SELECT p.id FROM posts p JOIN post_category pc ON pc.post_id = p.id JOIN categories c ON c.id = pc.category_id
         WHERE c.wp_slug = "concurso-docente" AND p.locale = "es" AND p.type = "post"'
    );
    foreach ($contest as $id) {
        DB::update('posts', ['notice_html' => $notice], ['id' => (int) $id]);
    }
    $done[] = count($contest) . ' avisos del concurso';

    // 2) Microsoft 365 Copilot: se conserva una; la otra pasa a borrador y redirige con 301.
    $keep = 'microsoft-365-copilot-la-revolucion-de-la-productividad-en-el-mundo-empresarial';
    $dup = 'microsoft-copilot-el-copiloto-de-trabajo-que-revoluciona-la-productividad-empresarial';
    DB::run('UPDATE posts SET status = "draft" WHERE locale = "es" AND slug = :s', ['s' => $dup]);
    DB::upsert('redirects', ['source' => "/$dup/", 'target' => "/$keep/", 'code' => 301, 'match_type' => 'exact', 'note' => 'Copilot duplicado'], ['source', 'match_type']);

    // 3) Restar horas: canonical de la primera hacia la segunda (más completa).
    DB::run('UPDATE posts SET canonical_url = "/como-restar-horas-en-excel-horas-laborales/" WHERE locale = "es" AND slug = "restar-horas-en-excel"');

    // 4) Afiliados de portátiles (2020): noindex y fuera de listados. [DECISIÓN DE EDWIN]
    DB::run('UPDATE posts SET status = "noindex" WHERE locale = "es" AND slug IN ("los-mejores-portatiles-baratos-y-rapidos", "cual-es-la-mejor-laptop-para-estudiantes-de-escuela-y-universidad")');

    // 5) Descarga de YouTube: noindex y sin anuncios (políticas de AdSense). [DECISIÓN DE EDWIN]
    DB::run('UPDATE posts SET status = "noindex", no_ads = 1 WHERE locale = "es" AND slug = "descargar-audio-y-videos-de-youtube-gratis-y-sin-programas"');

    // 6) Artículos con fecha: aviso de posible desactualización.
    foreach (['western-union-dejara-de-estar-disponible-en-youtube-como-forma-de-pago', 'hosting-y-dominio-gratis-por-siempre-100-sin-publicidad', 'como-obtener-filmora-9-x'] as $slug) {
        $post = DB::one('SELECT id, published_at FROM posts WHERE locale = "es" AND slug = :s', ['s' => $slug]);
        if ($post !== null) {
            $year = substr((string) $post['published_at'], 0, 4);
            DB::update('posts', ['notice_html' => "<p>Artículo de $year; puede estar desactualizado.</p>"], ['id' => (int) $post['id']]);
        }
    }

    // 7) /projekttag/: se conserva sin enlazar y con noindex. [DECISIÓN DE EDWIN]
    DB::run('UPDATE posts SET status = "noindex" WHERE locale = "es" AND slug = "projekttag"');

    // 8) /archivos-gratis/ se reemplaza por /herramientas/ (redirección en 04_redirects).
    DB::run('UPDATE posts SET status = "draft" WHERE locale = "es" AND slug = "archivos-gratis"');

    $done[] = 'copilot, canonical, noindex, avisos de fecha, projekttag, archivos-gratis';
    return implode('; ', $done);
};
