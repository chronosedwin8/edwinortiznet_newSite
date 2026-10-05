<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Ejecuta las migraciones SQL numeradas de database/migrations en orden.
 */
final class Migrator
{
    public function __construct(private readonly \Closure $out)
    {
    }

    private function say(string $line): void
    {
        ($this->out)($line);
    }

    public function createDatabase(): void
    {
        $name = (string) Config::get('DB_NAME', 'edwinortiz');
        if (!preg_match('/^[A-Za-z0-9_]+$/', $name)) {
            throw new \RuntimeException('DB_NAME inválido');
        }
        DB::connect(false)->exec("CREATE DATABASE IF NOT EXISTS `$name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    }

    public function fresh(): void
    {
        $name = (string) Config::get('DB_NAME', 'edwinortiz');
        if (!preg_match('/^[A-Za-z0-9_]+$/', $name)) {
            throw new \RuntimeException('DB_NAME inválido');
        }
        DB::connect(false)->exec("DROP DATABASE IF EXISTS `$name`");
        DB::setPdo(null);
        $this->say("Base de datos $name eliminada.");
    }

    public function migrate(): int
    {
        $this->createDatabase();
        $pdo = DB::pdo();
        $pdo->exec('CREATE TABLE IF NOT EXISTS migrations (
            name VARCHAR(190) NOT NULL PRIMARY KEY,
            applied_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');
        $applied = DB::column('SELECT name FROM migrations');
        $files = glob(Config::root('database/migrations/*.sql')) ?: [];
        sort($files, SORT_NATURAL);
        $count = 0;
        foreach ($files as $file) {
            $name = basename($file);
            if (in_array($name, $applied, true)) {
                continue;
            }
            foreach (self::splitStatements((string) file_get_contents($file)) as $statement) {
                $pdo->exec($statement);
            }
            DB::run('INSERT INTO migrations (name) VALUES (:n)', ['n' => $name]);
            $this->say("  ✔ $name");
            $count++;
        }
        $this->say($count === 0 ? 'Nada que migrar.' : "$count migración(es) aplicada(s).");
        return $count;
    }

    /** @return string[] */
    public static function splitStatements(string $sql): array
    {
        $sql = preg_replace('/^\s*--.*$/m', '', $sql) ?? $sql;
        $parts = preg_split('/;\s*(?:\r?\n|$)/', $sql) ?: [];
        return array_values(array_filter(array_map('trim', $parts), fn ($s) => $s !== ''));
    }
}
