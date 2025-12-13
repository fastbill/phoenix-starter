<?php

declare(strict_types=1);

namespace App\Http;

use App\Http\Controller\HomeController;
use App\Http\Controller\WelcomeController;
use Fastbill\Phoenix\Framework\Foundation\Http\Interfaces\RouteProviderInterface;
use League\Route\Router;

/**
 * Application Route Provider
 *
 * Define all application routes in this class. Routes are registered
 * during the kernel boot phase and are available throughout the application.
 *
 * Phoenix uses League\Route for routing. Routes can:
 * - Use controller classes (invokable) or [Controller::class, 'method'] syntax
 * - Be named for URL generation
 * - Be grouped with shared middleware or prefixes
 *
 * @see https://route.thephpleague.com/
 */
class RouteProvider implements RouteProviderInterface
{
    /**
     * Register application routes.
     *
     * @param Router $router
     */
    public function registerRoutes(Router $router): void
    {
        // Home page
        $router
            ->get('/', HomeController::class)
            ->setName('home');

        // Welcome demonstration routes
        $router
            ->get('/welcome', [WelcomeController::class, 'index'])
            ->setName('welcome.index');

        $router
            ->post('/welcome', [WelcomeController::class, 'store'])
            ->setName('welcome.store');

        $router
            ->get('/welcome/{name}', [WelcomeController::class, 'show'])
            ->setName('welcome.show');
    }
}
