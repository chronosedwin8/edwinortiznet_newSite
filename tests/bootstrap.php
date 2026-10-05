<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

App\Core\App::boot(dirname(__DIR__));
App\Core\Config::set('MAIL_DRIVER', 'array');
App\Core\Config::set('PAGE_CACHE', 'false');
