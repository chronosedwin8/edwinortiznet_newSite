<?php

declare(strict_types=1);

namespace App\Services\Kits;

/**
 * ZIP mínimo (deflate, nombres UTF-8) sin depender de la extensión zip, que no siempre está instalada.
 */
final class ZipWriter
{
    /** @var array<int, array{name:string, data:string}> */
    private array $entries = [];

    public function add(string $name, string $data): self
    {
        $this->entries[] = ['name' => ltrim(str_replace('\\', '/', $name), '/'), 'data' => $data];
        return $this;
    }

    public function bytes(?int $time = null): string
    {
        $time ??= time();
        $dosTime = ((int) date('H', $time) << 11) | ((int) date('i', $time) << 5) | intdiv((int) date('s', $time), 2);
        $dosDate = (((int) date('Y', $time) - 1980) << 9) | ((int) date('n', $time) << 5) | (int) date('j', $time);
        $out = '';
        $central = '';
        foreach ($this->entries as $entry) {
            $data = $entry['data'];
            $deflated = (string) gzdeflate($data, 9);
            $method = strlen($deflated) < strlen($data) ? 8 : 0;
            $stored = $method === 8 ? $deflated : $data;
            $crc = crc32($data);
            $name = $entry['name'];
            $offset = strlen($out);
            // Bit 11 (0x0800): nombre en UTF-8.
            $out .= pack('VvvvvvVVVvv', 0x04034b50, 20, 0x0800, $method, $dosTime, $dosDate, $crc, strlen($stored), strlen($data), strlen($name), 0)
                . $name . $stored;
            $central .= pack('VvvvvvvVVVvvvvvVV', 0x02014b50, 20, 20, 0x0800, $method, $dosTime, $dosDate, $crc, strlen($stored), strlen($data), strlen($name), 0, 0, 0, 0, 32, $offset)
                . $name;
        }
        $count = count($this->entries);
        return $out . $central . pack('VvvvvVVv', 0x06054b50, 0, 0, $count, $count, strlen($central), strlen($out), 0);
    }

    public function save(string $path, ?int $time = null): int
    {
        $bytes = $this->bytes($time);
        $tmp = $path . '.part';
        file_put_contents($tmp, $bytes);
        rename($tmp, $path);
        return strlen($bytes);
    }
}
