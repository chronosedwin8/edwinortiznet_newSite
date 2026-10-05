<?php

declare(strict_types=1);

use App\Core\App;
use App\Core\Config;
use App\Core\Csrf;
use App\Services\I18n\I18n;

/** Escapa para HTML (texto y atributos). */
function e(mixed $value): string
{
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8');
}

/** Cadena de interfaz traducida (lang/{es,en}.php). */
function t(string $key, array $params = [], ?string $locale = null): string
{
    return I18n::t($key, $params, $locale);
}

function locale(): string
{
    return I18n::locale();
}

/** URL absoluta a partir de una ruta. */
function url(string $path = '/'): string
{
    if (preg_match('#^https?://#', $path)) {
        return $path;
    }
    return Config::appUrl() . '/' . ltrim($path, '/');
}

/** Ruta nombrada en el idioma actual (o el indicado). */
function route(string $name, array $params = [], ?string $locale = null): string
{
    return App::router()->path($name, $params, $locale ?? I18n::locale());
}

function route_exists(string $name, ?string $locale = null): bool
{
    return App::router()->has($name, $locale ?? I18n::locale());
}

/** Recurso estático con versión para invalidar caché del navegador. */
function asset(string $path): string
{
    static $versions = [];
    $path = ltrim($path, '/');
    if (!isset($versions[$path])) {
        $file = Config::root('public/assets/' . $path);
        $versions[$path] = is_file($file) ? substr(base_convert((string) filemtime($file), 10, 36), -6) : '0';
    }
    return '/assets/' . $path . '?v=' . $versions[$path];
}

function money(float|int|string $amount, string $currency, ?string $locale = null): string
{
    return I18n::money($amount, $currency, $locale);
}

function fdate(mixed $date, string $style = 'long'): string
{
    return I18n::date($date, $style);
}

function csrf_field(): string
{
    return Csrf::field();
}

/** Campos anti-spam para formularios públicos: honeypot + marca de tiempo firmada. */
function antispam_fields(): string
{
    return \App\Services\Content\AntiSpam::fields();
}

function config(string $key, mixed $default = null): mixed
{
    return Config::get($key, $default);
}

/** Recorta texto plano a una longitud sin cortar palabras. */
function excerpt_text(?string $text, int $length = 160): string
{
    $text = trim(preg_replace('/\s+/u', ' ', strip_tags((string) $text)) ?? '');
    if (mb_strlen($text) <= $length) {
        return $text;
    }
    $cut = mb_substr($text, 0, $length - 1);
    $space = mb_strrpos($cut, ' ');
    return rtrim($space !== false && $space > $length * 0.6 ? mb_substr($cut, 0, $space) : $cut, " ,.;:") . '…';
}

/** Ruta interna de una entrada/página según su idioma. */
function post_path(array $post): string
{
    if (($post['type'] ?? 'post') === 'policy') {
        return route('policy', ['slug' => $post['slug']], $post['locale']);
    }
    return ($post['locale'] === 'en' ? '/en/' : '/') . $post['slug'] . '/';
}

function product_path(array $product, ?string $locale = null): string
{
    return route('product', ['slug' => $product['slug']], $locale ?? ($product['locale'] ?? I18n::locale()));
}

/** Ícono SVG del sprite (los íconos solo se usan cuando aportan función). */
function icon(string $name, string $class = 'icon'): string
{
    return '<svg class="' . e($class) . '" aria-hidden="true" focusable="false"><use href="' . e(asset('img/icons.svg')) . '#' . e($name) . '"></use></svg>';
}
