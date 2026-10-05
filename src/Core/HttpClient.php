<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Cliente HTTP mínimo. Las pasarelas lo reciben por constructor para poder simularlo en pruebas.
 */
interface HttpClient
{
    /**
     * @param array<string,string> $headers
     * @return array{status:int, body:string, json:array|null}
     */
    public function request(string $method, string $url, array $headers = [], ?string $body = null): array;
}
