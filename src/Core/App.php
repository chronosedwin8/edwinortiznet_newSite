<?php

declare(strict_types=1);

namespace App\Core;

use App\Controllers\ErrorController;
use App\Services\Content\AntiSpam;
use App\Services\I18n\I18n;
use App\Services\Seo\Redirects;
use App\Services\Seo\SecurityHeaders;

/**
 * Núcleo: arranque, front controller y ciclo de petición.
 */
final class App
{
    private static ?Router $router = null;

    public static function boot(string $root): void
    {
        Config::load($root);
        date_default_timezone_set('UTC');
        mb_internal_encoding('UTF-8');
        error_reporting(E_ALL);
        ini_set('display_errors', Config::debug() ? '1' : '0');
        set_error_handler(static function (int $severity, string $message, string $file, int $line): bool {
            if (!(error_reporting() & $severity)) {
                return false;
            }
            // Un aviso de obsolescencia de una versión nueva de PHP no debe tumbar una página: solo se registra.
            if ($severity & (E_DEPRECATED | E_USER_DEPRECATED)) {
                error_log("PHP Deprecated: $message in $file:$line");
                return true;
            }
            throw new \ErrorException($message, 0, $severity, $file, $line);
        });
        self::$router = null;
    }

    public static function router(): Router
    {
        if (self::$router === null) {
            $router = new Router();
            (require Config::root('src/routes.php'))($router);
            self::$router = $router;
        }
        return self::$router;
    }

    public static function run(): void
    {
        $request = Request::fromGlobals();
        $response = self::handle($request);
        $response->send($request);
    }

    public static function localeFromPath(string $path): string
    {
        return ($path === '/en' || str_starts_with($path, '/en/')) ? 'en' : 'es';
    }

    public static function handle(Request $request): Response
    {
        Csrf::reset();
        View::reset();
        \App\Services\AdminAccess::reset();
        I18n::setLocale(self::localeFromPath($request->path));
        \App\Services\Seo\Meta::setPath($request->path);
        try {
            $response = self::dispatch($request);
        } catch (\App\Admin\AdminRedirect $e) {
            $response = Response::redirect($e->url, 303);
        } catch (HttpException $e) {
            $response = $e->status === 404
                ? self::notFound($request)
                : (new ErrorController())->error($request, $e->status);
        } catch (\Throwable $e) {
            Logger::error('Excepción no controlada', [
                'path' => $request->path,
                'error' => $e->getMessage(),
                'file' => $e->getFile() . ':' . $e->getLine(),
            ]);
            if (Config::debug() && PHP_SAPI !== 'cli') {
                $response = Response::html('<pre>' . htmlspecialchars((string) $e) . '</pre>', 500);
            } else {
                try {
                    $response = (new ErrorController())->error($request, 500);
                } catch (\Throwable) {
                    $response = Response::html('Error', 500);
                }
            }
        }

        if ($response->cacheable && $response->status === 200 && $request->method === 'GET'
            && $request->query === [] && empty($response->headers['Set-Cookie'])) {
            Cache::putPage($request, $response);
        }
        // ETag sobre el cuerpo estable (antes de sustituir los marcadores por valores del visitante).
        if ($response->status === 200 && $response->streamer === null && $response->body !== '') {
            $response->headers['ETag'] = '"' . substr(hash('xxh128', $response->body . '|' . (string) $request->cookie(Csrf::COOKIE)), 0, 32) . '"';
        }
        Csrf::apply($request, $response);
        if (str_contains($response->body, AntiSpam::PLACEHOLDER)) {
            $response->body = str_replace(AntiSpam::PLACEHOLDER, AntiSpam::stamp(), $response->body);
        }
        SecurityHeaders::apply($request, $response);
        return $response;
    }

    private static function dispatch(Request $request): Response
    {
        $path = $request->path;

        // Barra final obligatoria: /blog → /blog/ (301), salvo archivos y API.
        if ($request->isGet() && $path !== '/' && !str_ends_with($path, '/')
            && !preg_match('#\.[a-z0-9]{2,5}$#i', $path)
            && !str_starts_with($path, '/api/') && !str_starts_with($path, '/webhooks/')) {
            $qs = $request->queryString();
            return Response::redirect($path . '/' . ($qs !== '' ? '?' . $qs : ''), 301);
        }

        // Enlaces antiguos de WooCommerce: /?add-to-cart={id}
        if (isset($request->query['add-to-cart']) && is_scalar($request->query['add-to-cart'])) {
            $target = Redirects::find('/?add-to-cart=' . (int) $request->query['add-to-cart']);
            if ($target !== null) {
                return Response::redirect($target['target'], $target['code']);
            }
        }

        if ($request->method === 'GET' && $request->query === [] && $request->cookie('eo_cart') === null
            && !str_starts_with($path, '/admin')) {
            $cached = Cache::getPage($request);
            if ($cached !== null) {
                return $cached;
            }
        }

        $match = self::router()->match($request->method, $path);
        if ($match === null) {
            throw HttpException::notFound();
        }
        if (isset($match['allowed'])) {
            return Response::text('Method Not Allowed', 405)->header('Allow', implode(', ', $match['allowed']));
        }
        $route = $match['route'];
        if ($route['locale'] !== null) {
            I18n::setLocale($route['locale']);
        }
        $request->attributes['route'] = $route;
        [$class, $method] = $route['handler'];
        $controller = new $class();
        $result = $controller->$method($request, ...array_values($match['params']));
        $response = $result instanceof Response ? $result : Response::html((string) $result);
        if (!empty($route['options']['cache']) && !isset($response->headers['Cache-Control'])) {
            $response->cache(true);
        }
        return $response;
    }

    public static function notFound(Request $request): Response
    {
        $target = Redirects::find($request->path);
        if ($target !== null) {
            $qs = $request->queryString();
            $url = $target['target'];
            if ($qs !== '' && !str_contains($url, '?')) {
                $url .= '?' . $qs;
            }
            return Response::redirect($url, $target['code']);
        }
        Redirects::logNotFound($request);
        return (new ErrorController())->error($request, 404);
    }
}
