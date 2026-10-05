<?php

declare(strict_types=1);

namespace App\Console;

use App\Core\App;
use App\Core\Cache;
use App\Core\Config;
use App\Core\DB;
use App\Core\Migrator;
use App\Core\Request;
use App\Core\RateLimiter;
use App\Services\Downloads\DownloadService;
use App\Services\Importer\WxrImporter;
use App\Services\Orders\Reconciler;
use App\Services\Seo\Sitemap;

final class Kernel
{
    private function out(string $line = ''): void
    {
        fwrite(STDOUT, $line . PHP_EOL);
    }

    public function run(array $args): int
    {
        $command = $args[0] ?? 'help';
        $options = array_slice($args, 1);
        try {
            return match ($command) {
                'migrate' => $this->migrate($options),
                'import:wxr' => $this->import($options),
                'seed' => $this->seed($options),
                'downloads:check' => $this->downloadsCheck(),
                'downloads:fetch' => $this->downloadsFetch(),
                'sitemap:build' => $this->sitemap(),
                'admin:create' => $this->adminCreate($options),
                'orders:reconcile' => $this->reconcile(),
                'cache:clear' => $this->cacheClear(),
                'mail:test' => $this->mailTest($options),
                'mail:ses-password' => $this->sesPassword($options),
                'routes:check' => $this->routesCheck(),
                default => $this->help(),
            };
        } catch (\Throwable $e) {
            fwrite(STDERR, 'Error: ' . $e->getMessage() . PHP_EOL . ($e->getFile() . ':' . $e->getLine()) . PHP_EOL);
            return 1;
        }
    }

    private function help(): int
    {
        $this->out('Comandos: migrate [--fresh], import:wxr, seed, downloads:check, downloads:fetch, sitemap:build, mail:test, mail:ses-password, admin:create, orders:reconcile, cache:clear, routes:check');
        return 0;
    }

    private function migrate(array $options): int
    {
        $migrator = new Migrator(fn (string $l) => $this->out($l));
        if (in_array('--fresh', $options, true)) {
            $migrator->fresh();
        }
        $migrator->migrate();
        return 0;
    }

    private function import(array $options): int
    {
        $importer = new WxrImporter(Config::storage('import'), fn (string $l) => $this->out($l));
        $summary = $importer->run();
        $this->out('');
        $this->out(sprintf(
            'Resumen: %d entradas, %d páginas, %d productos (%d adjuntos leídos).',
            $summary['posts'],
            $summary['pages'],
            $summary['products'],
            $summary['attachments']
        ));
        $this->out(sprintf(
            '  Páginas: %d importadas como contenido, %d son rutas de la aplicación.',
            $summary['pages_imported'],
            $summary['pages'] - $summary['pages_imported']
        ));
        Cache::flushPages();
        return 0;
    }

    private function seed(array $options): int
    {
        $files = glob(Config::root('database/seeds/*.php')) ?: [];
        sort($files, SORT_NATURAL);
        $en = glob(Config::root('database/seeds/en/*.php')) ?: [];
        sort($en, SORT_NATURAL);
        $only = $options[0] ?? null;
        foreach (array_merge($files, $en) as $file) {
            $name = str_replace(Config::root('database/seeds') . '/', '', $file);
            if ($only !== null && !str_contains($name, $only)) {
                continue;
            }
            $seed = require $file;
            $result = DB::transaction(fn () => $seed());
            $this->out("  ✔ $name" . (is_string($result) ? " — $result" : ''));
        }
        Cache::flushPages();
        return 0;
    }

    private function downloadsCheck(): int
    {
        $rows = DownloadService::productsWithoutLocalFile();
        if ($rows === []) {
            $this->out('Todos los productos descargables activos tienen archivo local.');
            return 0;
        }
        $this->out('Productos sin archivo local en storage/downloads/ (no se pueden comprar: "Disponible pronto"):');
        foreach ($rows as $row) {
            $this->out(sprintf('  - [%s] %s (wp %s)', $row['status'], $row['title'], $row['wp_id'] ?? '—'));
            foreach ($row['files'] as $file) {
                $this->out('      origen: ' . ($file['source_url'] ?? '—'));
                $this->out('      copiar a: storage/downloads/' . ($file['expected_path'] ?? ''));
            }
        }
        $this->out(count($rows) . ' producto(s) pendientes.');
        return 0;
    }

    private function downloadsFetch(): int
    {
        foreach (DownloadService::fetchMissing() as $row) {
            $this->out(sprintf('  %-12s %s', $row['status'], $row['file']));
        }
        \App\Core\Cache::flushPages();
        return $this->downloadsCheck();
    }

    private function sitemap(): int
    {
        $xml = Sitemap::build();
        $count = substr_count($xml, '<url>');
        $this->out("Sitemap regenerado con $count URL.");
        return 0;
    }

    private function adminCreate(array $options): int
    {
        $email = $options[0] ?? $this->ask('Correo: ');
        $name = $options[1] ?? $this->ask('Nombre: ');
        $password = $options[2] ?? $this->ask('Contraseña (mín. 12 caracteres): ', true);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($password) < 12) {
            $this->out('Correo inválido o contraseña demasiado corta.');
            return 1;
        }
        DB::upsert('admin_users', [
            'email' => strtolower($email),
            'name' => $name !== '' ? $name : $email,
            'password_hash' => password_hash($password, PASSWORD_ARGON2ID),
            'failed_attempts' => 0,
            'locked_until' => null,
        ], ['email']);
        $this->out("Usuario del panel listo: $email");
        return 0;
    }

    private function ask(string $prompt, bool $hidden = false): string
    {
        fwrite(STDOUT, $prompt);
        if ($hidden && DIRECTORY_SEPARATOR === '/') {
            system('stty -echo');
            $value = trim((string) fgets(STDIN));
            system('stty echo');
            fwrite(STDOUT, PHP_EOL);
            return $value;
        }
        return trim((string) fgets(STDIN));
    }

    private function reconcile(): int
    {
        $result = (new Reconciler())->run();
        $this->out(sprintf('Pedidos consultados: %d, actualizados: %d, anulados por vencimiento: %d.', $result['checked'], $result['updated'], $result['voided']));
        return 0;
    }

    private function mailTest(array $options): int
    {
        $to = $options[0] ?? (string) Config::get('ADMIN_EMAIL', '');
        if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
            $this->out('Uso: php bin/console mail:test correo@dominio.com');
            return 1;
        }
        $ok = \App\Core\Mailer::send($to, 'Prueba de correo de edwinortiz.net', '<p>Si lees esto, el envío funciona.</p>', 'Si lees esto, el envío funciona.');
        $this->out(($ok ? 'Enviado' : 'Falló (revisa storage/logs)') . ' con MAIL_DRIVER=' . Config::get('MAIL_DRIVER'));
        return $ok ? 0 : 1;
    }

    /** Contraseña SMTP de Amazon SES a partir de la clave secreta IAM (algoritmo SigV4 de AWS). */
    private function sesPassword(array $options): int
    {
        $region = $options[0] ?? 'us-east-1';
        $secret = $this->ask('Clave secreta IAM: ', true);
        $sig = hash_hmac('sha256', '11111111', 'AWS4' . $secret, true);
        foreach ([$region, 'ses', 'aws4_request', 'SendRawEmail'] as $part) {
            $sig = hash_hmac('sha256', $part, $sig, true);
        }
        $this->out('MAIL_HOST=email-smtp.' . $region . '.amazonaws.com');
        $this->out('MAIL_PASSWORD=' . base64_encode("" . $sig));
        return 0;
    }

    private function cacheClear(): int
    {
        $this->out(Cache::flushPages() . ' página(s) eliminadas de la caché.');
        return 0;
    }

    /** Recorre todos los slugs importados y verifica que respondan 200 (criterio de la fase 2). */
    private function routesCheck(): int
    {
        RateLimiter::disable();
        Config::set('PAGE_CACHE', 'false');
        $paths = [];
        foreach (DB::all("SELECT slug, locale, type FROM posts WHERE status <> 'draft' AND type IN ('post','page')") as $row) {
            $paths[] = ($row['locale'] === 'en' ? '/en/' : '/') . $row['slug'] . '/';
        }
        foreach (DB::all("SELECT pt.slug, pt.locale FROM product_translations pt JOIN products p ON p.id = pt.product_id") as $row) {
            $paths[] = ($row['locale'] === 'en' ? '/en/product/' : '/producto/') . $row['slug'] . '/';
        }
        $fail = 0;
        foreach ($paths as $path) {
            $response = App::handle(Request::create('GET', $path));
            if ($response->status !== 200) {
                $fail++;
                $this->out("  ✘ {$response->status} $path");
            }
        }
        $this->out(sprintf('%d rutas verificadas, %d con error.', count($paths), $fail));
        return $fail === 0 ? 0 : 1;
    }
}
