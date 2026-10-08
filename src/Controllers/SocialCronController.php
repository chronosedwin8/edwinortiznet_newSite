<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Config;
use App\Core\DB;
use App\Core\HttpException;
use App\Core\Request;
use App\Core\Response;
use App\Models\Setting;
use App\Services\Social\Planner;
use App\Services\Social\Publisher;
use App\Services\Social\Schedule;

/**
 * Disparador externo opcional de las redes (AWS EventBridge → Lambda, o cualquier servicio de cron):
 * GET o POST /cron/redes/{SOCIAL_CRON_TOKEN}/ publica lo pendiente y, una vez al día (hora de Colombia),
 * planifica la semana. Sin SOCIAL_CRON_TOKEN (mínimo 32 caracteres) la ruta responde 404.
 * El camino principal es el cron del servidor (deploy/cron.txt); los dos pueden convivir: hay bloqueos.
 */
final class SocialCronController extends Controller
{
    public function run(Request $request, string $token): Response
    {
        $expected = (string) Config::get('SOCIAL_CRON_TOKEN', '');
        if (strlen($expected) < 32 || !hash_equals($expected, $token)) {
            throw HttpException::notFound();
        }
        @set_time_limit(300);
        ignore_user_abort(true);
        $out = ['plan' => null, 'publish' => []];
        $last = Setting::get('social.last_plan_at');
        if ($last === null || Schedule::toLocal($last, 'Y-m-d') !== Schedule::toLocal(DB::now(), 'Y-m-d')) {
            $out['plan'] = Planner::run();
        }
        $out['publish'] = Publisher::run();
        return Response::json($out)
            ->header('Cache-Control', 'no-store')
            ->header('X-Robots-Tag', 'noindex, nofollow');
    }
}
