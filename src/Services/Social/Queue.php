<?php

declare(strict_types=1);

namespace App\Services\Social;

use App\Core\DB;

/**
 * Cola e historial (tabla social_posts). Un "grupo" es un contenido programado en un canal a una hora:
 * una fila por red (Facebook e Instagram) con su propio texto, imagen y estado.
 */
final class Queue
{
    public const SOURCES = ['fb' => 'facebook', 'ig' => 'instagram'];
    /** Estados en los que el grupo aún se puede editar. */
    public const EDITABLE = ['draft', 'approved', 'failed'];

    public static function utm(string $path, string $network, string $channelKey): string
    {
        $url = url($path);
        $query = http_build_query([
            'utm_source' => self::SOURCES[$network] ?? $network,
            'utm_medium' => 'social',
            'utm_campaign' => 'auto',
            'utm_content' => $channelKey,
        ]);
        return $url . (str_contains($url, '?') ? '&' : '?') . $query;
    }

    /** Primeras líneas de las últimas publicaciones del canal (para que la IA no repita aperturas). @return string[] */
    public static function recentOpenings(int $channelId, int $limit = 8): array
    {
        $rows = DB::column(
            "SELECT caption FROM social_posts WHERE channel_id = :c AND network = 'fb' AND caption IS NOT NULL AND status <> 'skipped' ORDER BY scheduled_at DESC LIMIT " . max(1, min(20, $limit)),
            ['c' => $channelId]
        );
        return array_map(fn ($c) => strtok((string) $c, "\n") ?: '', $rows);
    }

    /**
     * Crea el grupo (una fila por red conectada del canal) con textos e imágenes. Devuelve el group_key.
     * @param array<string, array> $accounts red => cuenta
     */
    public static function createGroup(array $channel, array $item, string $scheduledAt, array $accounts, string $createdBy = 'planner', bool $useAi = true): string
    {
        $captions = CaptionWriter::write($item, self::recentOpenings((int) $channel['id']), $useAi);
        $images = self::images($item, array_keys($accounts));
        $group = bin2hex(random_bytes(10));
        $status = !empty($channel['auto_approve']) ? 'approved' : 'draft';
        foreach (CaptionWriter::NETWORKS as $network) {
            if (!isset($accounts[$network])) {
                continue;
            }
            $image = $images[$network] ?? null;
            DB::insert('social_posts', [
                'group_key' => $group,
                'channel_id' => (int) $channel['id'],
                'network' => $network,
                'account_id' => (int) $accounts[$network]['id'],
                'content_type' => $item['type'],
                'content_id' => $item['id'],
                'content_key' => $item['key'],
                'title' => mb_substr((string) $item['title'], 0, 255),
                'link' => self::utm((string) $item['path'], $network, (string) $channel['key']),
                'caption' => $captions[$network]['text'],
                'hashtags' => CaptionWriter::formatTags($captions[$network]['hashtags']),
                'caption_source' => $captions['source'] === 'ai' ? 'ai' : 'template',
                'image_path' => $image,
                'image_url' => $image !== null ? url($image) : null,
                'scheduled_at' => $scheduledAt,
                'status' => $status,
                'error' => $network === 'ig' && $image === null ? 'No se pudo generar la imagen de Instagram.' : null,
                'created_by' => $createdBy,
            ]);
        }
        return $group;
    }

    /** @param string[] $networks @return array<string, ?string> */
    private static function images(array $item, array $networks): array
    {
        $fb = ImageMaker::facebook($item);
        $ig = in_array('ig', $networks, true) ? ImageMaker::instagram($item) : null;
        return ['fb' => $fb, 'ig' => $ig];
    }

    /** @return array<int, array> filas del grupo */
    public static function group(string $groupKey): array
    {
        return DB::all("SELECT * FROM social_posts WHERE group_key = :g ORDER BY FIELD(network, 'fb', 'ig')", ['g' => $groupKey]);
    }

    /**
     * Grupos para el panel, en orden. Cada grupo: key, channel_id, scheduled_at, title, content_key, content_type, rows (red => fila).
     * @return array<int, array>
     */
    public static function groups(string $where, array $params, string $order = 'scheduled_at ASC', int $limit = 200): array
    {
        $rows = DB::all("SELECT * FROM social_posts WHERE $where ORDER BY $order, FIELD(network, 'fb', 'ig') LIMIT " . max(1, min(1000, $limit)), $params);
        $groups = [];
        foreach ($rows as $row) {
            $g = &$groups[$row['group_key']];
            $g ??= ['key' => $row['group_key'], 'channel_id' => (int) $row['channel_id'], 'scheduled_at' => $row['scheduled_at'], 'title' => $row['title'],
                'content_key' => $row['content_key'], 'content_type' => $row['content_type'], 'rows' => []];
            $g['rows'][$row['network']] = $row;
            unset($g);
        }
        return array_values($groups);
    }

    /** Guarda los textos editados a mano. @param array<string, array{caption?:string, hashtags?:string}> $texts */
    public static function saveTexts(string $groupKey, array $texts): int
    {
        $n = 0;
        foreach (self::group($groupKey) as $row) {
            if (!in_array($row['status'], self::EDITABLE, true) || !isset($texts[$row['network']])) {
                continue;
            }
            $caption = CaptionWriter::cleanText((string) ($texts[$row['network']]['caption'] ?? ''), 2000);
            $tags = CaptionWriter::formatTags(CaptionWriter::parseTags($texts[$row['network']]['hashtags'] ?? '', 30));
            if ($caption === (string) $row['caption'] && $tags === (string) $row['hashtags']) {
                continue;
            }
            DB::update('social_posts', ['caption' => $caption, 'hashtags' => $tags, 'caption_source' => 'manual'], ['id' => (int) $row['id']]);
            $n++;
        }
        return $n;
    }

    /** Vuelve a escribir los textos (IA o plantilla) de las filas editables. */
    public static function regenerate(string $groupKey, bool $useAi = true): ?string
    {
        $rows = self::editableRows($groupKey);
        if ($rows === []) {
            return null;
        }
        $item = Catalog::item((string) $rows[0]['content_key']);
        if ($item === null) {
            return null;
        }
        $captions = CaptionWriter::write($item, self::recentOpenings((int) $rows[0]['channel_id']), $useAi);
        foreach ($rows as $row) {
            DB::update('social_posts', [
                'caption' => $captions[$row['network']]['text'],
                'hashtags' => CaptionWriter::formatTags($captions[$row['network']]['hashtags']),
                'caption_source' => $captions['source'] === 'ai' ? 'ai' : 'template',
            ], ['id' => (int) $row['id']]);
        }
        return $captions['source'];
    }

    /** Cambia el contenido del grupo (nuevo título, enlace, imágenes y textos). */
    public static function changeContent(string $groupKey, string $contentKey, bool $useAi = true): bool
    {
        $rows = self::editableRows($groupKey);
        $item = Catalog::item($contentKey);
        if ($rows === [] || $item === null) {
            return false;
        }
        $channel = Channels::find((int) $rows[0]['channel_id']);
        if ($channel === null) {
            return false;
        }
        $captions = CaptionWriter::write($item, self::recentOpenings((int) $channel['id']), $useAi);
        $images = self::images($item, array_column($rows, 'network'));
        foreach ($rows as $row) {
            $image = $images[$row['network']] ?? null;
            DB::update('social_posts', [
                'content_type' => $item['type'], 'content_id' => $item['id'], 'content_key' => $item['key'],
                'title' => mb_substr((string) $item['title'], 0, 255),
                'link' => self::utm((string) $item['path'], $row['network'], (string) $channel['key']),
                'caption' => $captions[$row['network']]['text'],
                'hashtags' => CaptionWriter::formatTags($captions[$row['network']]['hashtags']),
                'caption_source' => $captions['source'] === 'ai' ? 'ai' : 'template',
                'image_path' => $image, 'image_url' => $image !== null ? url($image) : null,
                'container_id' => null, 'error' => null,
            ], ['id' => (int) $row['id']]);
        }
        return true;
    }

    /** Cambia el estado de las filas editables del grupo (aprobar, omitir…). */
    public static function setStatus(string $groupKey, string $status): int
    {
        $n = 0;
        // Aprobar también recupera un grupo omitido.
        $allowed = $status === 'approved' ? [...self::EDITABLE, 'skipped'] : self::EDITABLE;
        foreach (self::group($groupKey) as $row) {
            if (!in_array($row['status'], $allowed, true)) {
                continue;
            }
            $data = ['status' => $status];
            if ($status === 'approved') {
                $data += ['attempts' => 0, 'next_attempt_at' => null, 'error' => $row['network'] === 'ig' && $row['image_url'] === null ? $row['error'] : null];
            }
            $n += DB::update('social_posts', $data, ['id' => (int) $row['id']]);
        }
        return $n;
    }

    public static function reschedule(string $groupKey, string $utc): int
    {
        $n = 0;
        foreach (self::editableRows($groupKey) as $row) {
            $n += DB::update('social_posts', ['scheduled_at' => $utc], ['id' => (int) $row['id']]);
        }
        return $n;
    }

    /** Borra el grupo solo si nada se publicó ni se está publicando. */
    public static function delete(string $groupKey): bool
    {
        $rows = self::group($groupKey);
        if ($rows === [] || array_filter($rows, fn ($r) => in_array($r['status'], ['published', 'publishing'], true)) !== []) {
            return false;
        }
        DB::run('DELETE FROM social_posts WHERE group_key = :g', ['g' => $groupKey]);
        return true;
    }

    /** @return array<int, array> */
    private static function editableRows(string $groupKey): array
    {
        return array_values(array_filter(self::group($groupKey), fn ($r) => in_array($r['status'], self::EDITABLE, true)));
    }
}
