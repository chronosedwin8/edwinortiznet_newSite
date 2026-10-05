<?php

declare(strict_types=1);

// Front controller único: todas las peticiones que no son archivos estáticos llegan aquí.
require dirname(__DIR__) . '/vendor/autoload.php';

App\Core\App::boot(dirname(__DIR__));
App\Core\App::run();
