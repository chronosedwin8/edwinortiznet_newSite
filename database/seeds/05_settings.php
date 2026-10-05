<?php

declare(strict_types=1);

use App\Core\DB;

/*
 * Ajustes por defecto (editables en el panel).
 */
return static function (): string {
    $defaults = [
        'whatsapp_number' => '573162830615',
        'social_youtube' => '',
        'social_linkedin' => '',
        'refund_days' => '7',
        'ads_enabled' => '1',
        'adsense_max_blocks' => '3',
        'fundales_url' => 'https://fundales.com/',
    ];
    foreach ($defaults as $key => $value) {
        DB::run('INSERT IGNORE INTO settings (`key`, `value`) VALUES (:k, :v)', ['k' => $key, 'v' => $value]);
    }
    return count($defaults) . ' ajustes';
};
