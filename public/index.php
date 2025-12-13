<?php

declare(strict_types=1);

use App\ApplicationKernel;

// Set default timezone
date_default_timezone_set('Europe/Berlin');

// Load Composer autoloader
require_once dirname(__FILE__, 2) . '/vendor/autoload.php';

// Bootstrap and run the application
$app = new ApplicationKernel(dirname(__FILE__, 2));
$app->boot()->run();
