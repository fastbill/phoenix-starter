<?php

declare(strict_types=1);

use FastBill\Phoenix\CodeQuality\ConfigBuilder;

return ConfigBuilder::create()
    ->inDir(__DIR__ . '/App')
    ->inDir(__DIR__ . '/tests')
    ->cacheFile(__DIR__ . '/.php-cs-fixer.cache')
    ->getConfig();
