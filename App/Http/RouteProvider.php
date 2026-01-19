<?php

declare(strict_types=1);

namespace Fastbill\Phoenix\Starter\Http;

use Fastbill\Phoenix\Framework\Foundation\Http\Interfaces\RouteProviderInterface;
use Fastbill\Phoenix\Starter\Http\Controller\HomeController;
use League\Route\Router;

class RouteProvider implements RouteProviderInterface
{
    public function registerRoutes(Router $router): void
    {
        $router
            ->get('/', HomeController::class)
            ->setName('home');
    }
}
