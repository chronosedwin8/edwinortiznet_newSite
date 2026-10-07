<?php

declare(strict_types=1);

namespace App\Services\Examenes;

/**
 * Generador pseudoaleatorio determinista (xorshift32) para barajar y armar rejillas: con la misma semilla
 * la vista previa, el PDF y la clave de respuestas siempre coinciden. No toca el estado global de mt_rand.
 */
final class Rng
{
    private int $state;

    public function __construct(int $seed)
    {
        $this->state = ($seed & 0xFFFFFFFF) ?: 0x9E3779B9;
    }

    /** Semilla estable a partir de varias partes (semilla del examen, pregunta, versión…). */
    public static function seed(int|string ...$parts): int
    {
        return (int) hexdec(substr(hash('sha256', implode('|', $parts)), 0, 7)) + 1;
    }

    public function next(): int
    {
        $x = $this->state;
        $x ^= ($x << 13) & 0xFFFFFFFF;
        $x ^= $x >> 17;
        $x ^= ($x << 5) & 0xFFFFFFFF;
        $this->state = $x & 0xFFFFFFFF;
        return $this->state;
    }

    /** Entero en [min, max]. */
    public function int(int $min, int $max): int
    {
        if ($max <= $min) {
            return $min;
        }
        return $min + $this->next() % ($max - $min + 1);
    }

    /** Fisher–Yates sobre una copia. */
    public function shuffle(array $items): array
    {
        $items = array_values($items);
        for ($i = count($items) - 1; $i > 0; $i--) {
            $j = $this->int(0, $i);
            [$items[$i], $items[$j]] = [$items[$j], $items[$i]];
        }
        return $items;
    }

    public function pick(array $items): mixed
    {
        $items = array_values($items);
        return $items === [] ? null : $items[$this->int(0, count($items) - 1)];
    }
}
