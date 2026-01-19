<?php

declare(strict_types=1);

// Suppress deprecation notices from legacy packages
error_reporting(E_ALL & ~E_DEPRECATED);

use Fastbill\Phoenix\Starter\ApplicationKernel;

date_default_timezone_set('Europe/Berlin');

// Autoload dependencies
require_once dirname(__FILE__, 2) . '/vendor/autoload.php';

$app = new ApplicationKernel(dirname(__FILE__, 2));
$app->boot()->run();
