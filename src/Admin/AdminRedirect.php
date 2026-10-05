<?php

declare(strict_types=1);

namespace App\Admin;

/** Redirección al acceso cuando no hay sesión del panel. */
final class AdminRedirect extends \RuntimeException
{
    public function __construct(public readonly string $url)
    {
        parent::__construct($url);
    }
}
