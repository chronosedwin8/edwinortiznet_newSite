<?php

declare(strict_types=1);

namespace App\Services\Newsletter;

use App\Services\Seo\Meta;

/**
 * Contexto de suscripción de cada página (va en $meta['subscribe']): tipo de origen, ruta, título y los
 * intereses que se marcan por omisión en los formularios y en la página de confirmación.
 * Se calcula en el servidor, así que la página sigue siendo cacheable.
 */
final class SubscribeContext
{
    /** @return array{type:string, path:string, title:string, interests:string[]} */
    public static function fromPage(string $template, array $data, array $meta): array
    {
        $title = (string) ($meta['title'] ?? '');
        $type = 'other';
        $interests = [];
        switch ($template) {
            case 'pages/home':
                $type = 'home';
                break;
            case 'pages/article':
                $type = 'article';
                $title = (string) ($data['post']['title'] ?? $title);
                $interests = Interests::forHub($data['hub']['key'] ?? null);
                break;
            case 'pages/hub':
                $type = 'hub';
                $title = (string) ($data['hub']['title'] ?? $title);
                $interests = Interests::forHub($data['hub']['key'] ?? null);
                break;
            case 'pages/product':
                $type = 'product';
                $title = (string) ($data['product']['title'] ?? $title);
                $interests = isset($data['product']) ? Interests::forProduct($data['product']) : [];
                break;
            case 'pages/tool':
                $type = 'tool';
                $interests = Interests::forTool($data['key'] ?? null);
                break;
            case 'pages/piar/landing':
                $type = 'tool';
                $interests = Interests::forTool('piar');
                break;
            case 'pages/examenes/landing':
                $type = 'tool';
                $interests = Interests::forTool('examenes');
                break;
            case 'pages/fundales':
                $type = 'tool';
                $interests = Interests::forTool('fundales');
                break;
            case 'pages/checkout':
                $type = 'checkout';
                break;
            case 'pages/account':
                $type = 'account';
                break;
        }
        return [
            'type' => $type,
            'path' => mb_substr(Meta::path(), 0, 255),
            'title' => mb_substr(trim($title), 0, 255),
            'interests' => $interests,
        ];
    }
}
