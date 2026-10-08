<?php

declare(strict_types=1);

use App\Core\DB;
use App\Services\Social\Channels;

/*
 * Redes sociales: canales por defecto (idempotente; si el canal ya existe no se tocan sus ajustes, que se
 * editan en el panel). Solo se completan las cuentas que falten si ya están conectadas.
 *
 * - principal: página de Facebook «Tecnología 1» + Instagram @edwinortizherazo,
 *   todos los días a las 18:30 (hora de Colombia), todo el contenido menos el hub del Concurso Docente.
 * - concurso: página de Facebook «Fundales.com», lunes, miércoles y viernes a las 19:00, entradas del hub del
 *   Concurso Docente y el simulacro (PIAR y exámenes se pueden activar en el panel).
 * Modo por defecto: sin aprobación automática (Edwin aprueba la cola de la semana).
 */
return static function (): string {
    $channels = [
        'principal' => [
            'name' => 'Principal (Tecnología 1 + Instagram)',
            'schedule' => ['days' => [1, 2, 3, 4, 5, 6, 7], 'time' => '18:30', 'tz' => 'America/Bogota'],
            'content' => [
                'types' => ['post', 'page', 'product', 'tool'],
                'hubs_include' => [],
                'hubs_exclude' => ['concurso-docente'],
                'audiences' => ['oficina', 'docente'],
                'skus' => [],
                // Los paquetes de PIAR y de exámenes se promocionan como herramienta (una sola publicación).
                'exclude_skus' => ['PIAR-*', 'EXAM-*'],
                'tools' => ['qr', 'words', 'piar', 'examenes'],
            ],
        ],
        'concurso' => [
            'name' => 'Concurso Docente (Fundales.com)',
            'schedule' => ['days' => [1, 3, 5], 'time' => '19:00', 'tz' => 'America/Bogota'],
            'content' => [
                'types' => ['post', 'tool'],
                'hubs_include' => ['concurso-docente'],
                'hubs_exclude' => [],
                'audiences' => ['concurso'],
                'skus' => [],
                'exclude_skus' => [],
                'tools' => ['fundales'],
            ],
        ],
    ];
    $created = 0;
    foreach ($channels as $key => $c) {
        if (DB::value('SELECT id FROM social_channels WHERE `key` = :k', ['k' => $key]) !== null) {
            continue;
        }
        DB::insert('social_channels', [
            'key' => $key,
            'name' => $c['name'],
            'schedule_json' => json_encode($c['schedule']),
            'content_json' => json_encode($c['content']),
            'auto_approve' => 0,
            'active' => 1,
        ]);
        $created++;
    }
    Channels::assignDefaults();
    return "$created canal(es) creado(s)";
};
