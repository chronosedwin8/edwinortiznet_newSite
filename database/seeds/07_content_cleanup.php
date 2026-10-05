<?php

declare(strict_types=1);

use App\Core\DB;

/*
 * Depuración de contenido (evaluación del 5 de octubre de 2026, ver EVALUACION_CONTENIDO.md).
 * Nada se borra: cada pieza pasa a borrador y su URL redirige con 301 al reemplazo más útil,
 * así se conserva la autoridad de los enlaces. Para revertir: Panel → Artículos → estado "Publicado"
 * y eliminar la redirección en Panel → Redirecciones.
 */
return static function (): string {
    $retire = [
        // slug => [destino 301, motivo]
        'como-obtener-filmora-9-x' => ['/como-convertir-un-video-filmora-a-mp4/', 'Promueve instalar Filmora con crack y quitar la marca de agua: riesgo legal y de AdSense.'],
        'descargar-audio-y-videos-de-youtube-gratis-y-sin-programas' => ['/blog/', 'Descarga de videos de YouTube: riesgo de derechos de autor y de AdSense.'],
        'western-union-dejara-de-estar-disponible-en-youtube-como-forma-de-pago' => ['/blog/', 'Noticia de 2020 sin vigencia y fuera del tema del sitio.'],
        'hosting-y-dominio-gratis-por-siempre-100-sin-publicidad' => ['/como-crear-una-pagina-web-gratis-para-negocio-usando-wordpress/', 'Ofertas de hosting de 2020 que ya no aplican.'],
        'como-instalar-wordpress-en-un-hosting-de-manera-facil' => ['/como-crear-una-pagina-web-gratis-para-negocio-usando-wordpress/', 'Contenido corto que repite la guía de WordPress de 2022.'],
        'los-mejores-portatiles-baratos-y-rapidos' => ['/blog/', 'Recomendaciones de afiliado de 2020 con modelos y precios desactualizados.'],
        'cual-es-la-mejor-laptop-para-estudiantes-de-escuela-y-universidad' => ['/blog/', 'Recomendaciones de afiliado de 2020 con modelos y precios desactualizados.'],
        'por-que-el-cielo-es-azul' => ['/ia-para-docentes/', 'Tema fuera del posicionamiento del sitio y con poco contenido.'],
        'la-tecnologia-en-la-educacion-dio-un-salto-cuantico-durante-el-covid-19' => ['/la-educacion-virtual-de-colegios-publicos-colombianos-en-tiempos-del-covid-19/', 'Opinión de 2020 que se solapa con el artículo más completo sobre educación virtual.'],
        'la-educacion-virtual-y-su-relacion-con-los-padres' => ['/la-educacion-virtual-de-colegios-publicos-colombianos-en-tiempos-del-covid-19/', 'Opinión de 2020 que se solapa con el artículo más completo sobre educación virtual.'],
        'restar-horas-en-excel' => ['/como-restar-horas-en-excel-horas-laborales/', 'Duplicado: la otra guía es más completa (antes solo tenía canonical).'],
        'infografia' => ['/infografia-en-power-point/', 'Página de 2018 con texto genérico; el artículo de infografías en PowerPoint es más útil.'],
        'wordpress' => ['/como-crear-una-pagina-web-gratis-para-negocio-usando-wordpress/', 'Página de 2018 genérica con banners de hosting.'],
        'lineas-de-tiempo' => ['/ia-para-docentes/', 'Página de 2018 genérica sobre diagramas de Gantt.'],
        'herramientas-tic' => ['/herramientas-tecnologicas-para-docentes-pros-y-contras/', 'Página de 2018 que repite el artículo de herramientas tecnológicas para docentes.'],
        'realidad-aumentada' => ['/realidad-aumentada-un-recurso-de-aula/', 'Página de 2018 genérica; el artículo propio con Scratch es más valioso.'],
        'informatica-basica-para-adultos' => ['/cursos/', 'Página de 2018 corta y fuera del enfoque actual.'],
        'projekttag' => ['/', 'Página de 6 palabras sin propósito público.'],
        'combinar-correspondencia-en-documentos-independientes-en-3-simples-pasos' => ['/producto/aplicativo-para-combinar-datos-de-excel-en-documentos-separados-docx-y-pdf/', 'Página de venta que duplica la ficha del producto y el tutorial.'],
    ];
    $count = 0;
    foreach ($retire as $slug => [$target, $reason]) {
        $updated = DB::run('UPDATE posts SET status = "draft" WHERE locale = "es" AND slug = :s', ['s' => $slug])->rowCount();
        DB::upsert('redirects', [
            'source' => "/$slug/", 'target' => $target, 'code' => 301, 'match_type' => 'exact',
            'note' => mb_substr('Depuración 2026-10: ' . $reason, 0, 255),
        ], ['source', 'match_type']);
        $count += $updated > 0 ? 1 : 0;
    }
    // El canonical ya no hace falta: ahora es una redirección.
    DB::run('UPDATE posts SET canonical_url = NULL WHERE locale = "es" AND slug = "restar-horas-en-excel"');
    // El artículo de 2020 que se conserva avisa su fecha.
    DB::run(
        'UPDATE posts SET notice_html = "<p>Artículo de 2020, escrito durante la pandemia; algunas condiciones pueden haber cambiado.</p>"
         WHERE locale = "es" AND slug = "la-educacion-virtual-de-colegios-publicos-colombianos-en-tiempos-del-covid-19" AND notice_html IS NULL'
    );
    \App\Services\Seo\Redirects::clear();
    return count($retire) . ' piezas retiradas con 301';
};
