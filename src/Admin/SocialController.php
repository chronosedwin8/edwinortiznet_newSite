<?php

declare(strict_types=1);

namespace App\Admin;

use App\Core\Config;
use App\Core\DB;
use App\Core\HttpException;
use App\Core\Request;
use App\Core\Response;
use App\Models\Setting;
use App\Services\Social\Accounts;
use App\Services\Social\Catalog;
use App\Services\Social\Channels;
use App\Services\Social\Connector;
use App\Services\Social\MetaException;
use App\Services\Social\Planner;
use App\Services\Social\Publisher;
use App\Services\Social\Queue;
use App\Services\Social\Schedule;

/**
 * Redes sociales: cola de los próximos 14 días (vista previa, edición y aprobación), historial,
 * conexión de cuentas (Facebook e Instagram) y ajustes de los canales.
 */
final class SocialController extends AdminBase
{
    private const BASE = '/admin/redes/';

    public function queue(Request $request): Response
    {
        $this->requireAdmin($request);
        $channels = $this->channelsById();
        $channelId = (int) ($request->query['canal'] ?? 0);
        $where = "scheduled_at >= :from AND scheduled_at <= :to AND status IN ('draft','approved','publishing','failed','skipped')";
        $params = ['from' => gmdate('Y-m-d H:i:s', time() - 6 * 3600), 'to' => gmdate('Y-m-d H:i:s', time() + 14 * 86400)];
        if (isset($channels[$channelId])) {
            $where .= ' AND channel_id = :c';
            $params['c'] = $channelId;
        }
        $groups = Queue::groups($where, $params);
        $options = [];
        foreach ($channels as $id => $channel) {
            $options[$id] = array_map(fn ($i) => ['key' => $i['key'], 'title' => $i['title'], 'type' => $i['type']], Catalog::candidates($channel['content']));
        }
        $stats = DB::one(
            "SELECT COUNT(DISTINCT CASE WHEN status = 'draft' AND scheduled_at > :now THEN group_key END) AS drafts,
                COUNT(DISTINCT CASE WHEN status = 'approved' THEN group_key END) AS approved,
                SUM(status = 'published' AND published_at > :d30) AS published30, SUM(status = 'failed' AND updated_at > :d7) AS failed7
             FROM social_posts",
            ['now' => DB::now(), 'd30' => gmdate('Y-m-d H:i:s', time() - 30 * 86400), 'd7' => gmdate('Y-m-d H:i:s', time() - 7 * 86400)]
        ) ?? [];
        return $this->view('social/queue', [
            'groups' => $groups,
            'channels' => $channels,
            'channelId' => $channelId,
            'options' => $options,
            'stats' => $stats,
            'accounts' => array_column(Accounts::all(), null, 'id'),
            'lastPlan' => Setting::get('social.last_plan_at'),
            'needsConnect' => (int) DB::value("SELECT COUNT(*) FROM social_accounts WHERE status = 'active' AND token_enc IS NOT NULL") === 0,
        ], t('admin.social'));
    }

    public function history(Request $request): Response
    {
        $this->requireAdmin($request);
        $status = in_array($request->query['estado'] ?? '', ['published', 'failed', 'skipped'], true) ? (string) $request->query['estado'] : '';
        $where = $status !== '' ? 'p.status = :s' : "p.status IN ('published','failed','skipped')";
        $params = $status !== '' ? ['s' => $status] : [];
        $rows = DB::all(
            "SELECT p.*, a.name AS account_name, a.username AS account_username FROM social_posts p LEFT JOIN social_accounts a ON a.id = p.account_id
             WHERE $where ORDER BY COALESCE(p.published_at, p.scheduled_at) DESC, p.id DESC LIMIT 300",
            $params
        );
        return $this->view('social/history', ['rows' => $rows, 'status' => $status, 'channels' => $this->channelsById()], t('admin.social.history'));
    }

    public function settings(Request $request): Response
    {
        $this->requireAdmin($request);
        $accounts = Accounts::all();
        return $this->view('social/settings', [
            'accounts' => $accounts,
            'channels' => Channels::all(),
            'hubs' => Catalog::hubOptions(),
            'tools' => Catalog::toolOptions(),
            'userExpires' => Setting::get('social.meta_user_expires_at'),
            'connectedAt' => Setting::get('social.meta_connected_at'),
            'lastPlan' => Setting::get('social.last_plan_at'),
            'metaApp' => (string) Config::get('META_APP_ID', '') !== '' && (string) Config::get('META_APP_SECRET', '') !== '',
            'cronToken' => strlen((string) Config::get('SOCIAL_CRON_TOKEN', '')) >= 32,
        ], t('admin.social.settings'));
    }

    public function connectMeta(Request $request): Response
    {
        $this->requireAdmin($request);
        try {
            $r = Connector::connectMeta((string) ($request->post['token'] ?? ''));
            return $this->back(self::BASE . 'ajustes/', t('admin.social.connected', ['pages' => $r['pages'], 'ig' => $r['instagram']]));
        } catch (MetaException $e) {
            return $this->fail(self::BASE . 'ajustes/', t('admin.social.connect_error', ['error' => $e->getMessage()]));
        }
    }

    public function check(Request $request): Response
    {
        $this->requireAdmin($request);
        $results = Connector::check();
        $bad = array_filter($results, fn ($r) => !$r['ok']);
        return $bad === []
            ? $this->back(self::BASE . 'ajustes/', t('admin.social.check_ok', ['n' => count($results)]))
            : $this->fail(self::BASE . 'ajustes/', t('admin.social.check_bad', ['list' => implode('; ', array_map(fn ($r) => $r['account'] . ': ' . $r['detail'], $bad))]));
    }

    public function plan(Request $request): Response
    {
        $this->requireAdmin($request);
        @set_time_limit(300);
        $lines = Planner::run();
        return $this->back(self::BASE, implode(' ', $lines));
    }

    /** Aprueba todos los borradores de los próximos 7 días (de un canal o de todos). */
    public function approveWeek(Request $request): Response
    {
        $this->requireAdmin($request);
        $params = ['now' => DB::now(), 'to' => gmdate('Y-m-d H:i:s', time() + 7 * 86400)];
        $sql = "UPDATE social_posts SET status = 'approved', attempts = 0, next_attempt_at = NULL WHERE status = 'draft' AND scheduled_at > :now AND scheduled_at <= :to";
        $channel = (int) ($request->post['channel'] ?? 0);
        if ($channel > 0) {
            $sql .= ' AND channel_id = :c';
            $params['c'] = $channel;
        }
        $n = DB::run($sql, $params)->rowCount();
        return $this->back(self::BASE . ($channel > 0 ? '?canal=' . $channel : ''), t('admin.social.approved_week', ['n' => $n]));
    }

    public function saveChannel(Request $request, string $id): Response
    {
        $this->requireAdmin($request);
        $channel = Channels::find((int) $id);
        if ($channel === null) {
            throw HttpException::notFound();
        }
        $p = $request->post;
        $list = static fn (string $k): array => array_values(array_filter((array) ($p[$k] ?? []), 'is_string'));
        $csv = static fn (string $k): array => array_values(array_filter(array_map('trim', explode(',', (string) ($p[$k] ?? ''))), fn ($v) => $v !== ''));
        $schedule = Schedule::normalize(['days' => $list('days'), 'time' => (string) ($p['time'] ?? ''), 'tz' => Schedule::TZ]);
        if ($schedule['days'] === []) {
            return $this->fail(self::BASE . 'ajustes/#canal-' . $channel['id'], t('admin.social.no_days'));
        }
        $content = Channels::normalizeContent([
            'types' => $list('types'), 'hubs_include' => $list('hubs_include'), 'hubs_exclude' => $list('hubs_exclude'),
            'audiences' => $list('audiences'), 'skus' => $csv('skus'), 'exclude_skus' => $csv('exclude_skus'), 'tools' => $list('tools'),
        ]);
        $account = static function (string $network) use ($p): ?int {
            $id = (int) ($p[$network . '_account_id'] ?? 0);
            return $id > 0 && DB::value('SELECT id FROM social_accounts WHERE id = :id AND network = :n', ['id' => $id, 'n' => $network]) !== null ? $id : null;
        };
        DB::update('social_channels', [
            'name' => self::str($request, 'name', 120) ?? $channel['name'],
            'fb_account_id' => $account('fb'),
            'ig_account_id' => $account('ig'),
            'schedule_json' => json_encode($schedule),
            'content_json' => json_encode($content),
            'auto_approve' => !empty($p['auto_approve']) ? 1 : 0,
            'active' => !empty($p['active']) ? 1 : 0,
        ], ['id' => (int) $channel['id']]);
        return $this->back(self::BASE . 'ajustes/#canal-' . $channel['id'], t('admin.social.channel_saved'));
    }

    /** Acciones sobre un grupo de la cola: guardar textos, regenerar, cambiar contenido, aprobar, omitir, reprogramar, publicar ahora o borrar. */
    public function group(Request $request, string $token): Response
    {
        $this->requireAdmin($request);
        $rows = Queue::group($token);
        if ($rows === []) {
            throw HttpException::notFound();
        }
        $back = (string) ($request->post['return'] ?? '');
        $back = str_starts_with($back, self::BASE) ? $back : self::BASE;
        $back .= '#g-' . $token;
        $action = (string) ($request->post['action'] ?? '');
        switch ($action) {
            case 'save':
            case 'save_approve':
                $texts = [];
                foreach ((array) ($request->post['caption'] ?? []) as $network => $caption) {
                    $texts[(string) $network] = ['caption' => (string) $caption, 'hashtags' => (string) ($request->post['hashtags'][$network] ?? '')];
                }
                Queue::saveTexts($token, $texts);
                if ($action === 'save_approve') {
                    Queue::setStatus($token, 'approved');
                    return $this->back($back, t('admin.social.saved_approved'));
                }
                return $this->back($back, t('admin.social.saved'));
            case 'regenerate':
                @set_time_limit(120);
                $source = Queue::regenerate($token);
                return $source === null ? $this->fail($back, t('admin.social.not_editable')) : $this->back($back, t($source === 'ai' ? 'admin.social.regenerated' : 'admin.social.regenerated_template'));
            case 'change':
                @set_time_limit(120);
                return Queue::changeContent($token, (string) ($request->post['content_key'] ?? ''))
                    ? $this->back($back, t('admin.social.changed'))
                    : $this->fail($back, t('admin.social.not_editable'));
            case 'approve':
                Queue::setStatus($token, 'approved');
                return $this->back($back, t('admin.social.approved'));
            case 'unapprove':
                Queue::setStatus($token, 'draft');
                return $this->back($back, t('admin.social.unapproved'));
            case 'skip':
                Queue::setStatus($token, 'skipped');
                return $this->back($back, t('admin.social.skipped'));
            case 'reschedule':
                $utc = Schedule::toUtc((string) ($request->post['scheduled_local'] ?? ''));
                if ($utc === null || strtotime($utc . ' UTC') < time() - 60) {
                    return $this->fail($back, t('admin.social.bad_date'));
                }
                Queue::reschedule($token, $utc);
                return $this->back($back, t('admin.social.rescheduled'));
            case 'publish':
                @set_time_limit(180);
                $lines = Publisher::publishGroupNow($token);
                $failed = array_filter(Queue::group($token), fn ($r) => $r['status'] !== 'published');
                return $failed === [] ? $this->back($back, implode(' ', $lines)) : $this->fail($back, implode(' ', $lines));
            case 'delete':
                return Queue::delete($token) ? $this->back(self::BASE, t('admin.social.deleted')) : $this->fail($back, t('admin.social.not_deletable'));
        }
        return $this->fail($back, t('admin.social.unknown_action'));
    }

    /** "Programar en redes" desde la edición de un artículo o página. */
    public function schedulePost(Request $request): Response
    {
        $this->requireAdmin($request);
        $postId = (int) ($request->post['post_id'] ?? 0);
        $post = DB::one('SELECT id, type, status, locale FROM posts WHERE id = :id', ['id' => $postId]);
        $back = '/admin/contenido/' . $postId . '/';
        if ($post === null || !in_array($post['type'], ['post', 'page'], true)) {
            throw HttpException::notFound();
        }
        $item = Catalog::item($post['type'] . ':' . $postId);
        if ($item === null) {
            return $this->fail($back, t('admin.social.post_not_eligible'));
        }
        $channel = Channels::find((int) ($request->post['channel_id'] ?? 0));
        if ($channel === null) {
            return $this->fail($back, t('admin.social.no_channel'));
        }
        $accounts = array_filter(Channels::accounts($channel), fn ($a) => $a['status'] === 'active');
        if ($accounts === []) {
            return $this->fail($back, t('admin.social.no_accounts'));
        }
        $utc = Schedule::toUtc((string) ($request->post['scheduled_local'] ?? ''));
        if ($utc === null || strtotime($utc . ' UTC') < time() - 60) {
            return $this->fail($back, t('admin.social.bad_date'));
        }
        @set_time_limit(120);
        $group = Queue::createGroup($channel, $item, $utc, $accounts, 'admin');
        return $this->back(self::BASE . '?canal=' . $channel['id'] . '#g-' . $group, t('admin.social.scheduled', ['date' => Schedule::toLocal($utc)]));
    }

    /** @return array<int, array> */
    private function channelsById(): array
    {
        $out = [];
        foreach (Channels::all() as $c) {
            $out[(int) $c['id']] = $c;
        }
        return $out;
    }
}
