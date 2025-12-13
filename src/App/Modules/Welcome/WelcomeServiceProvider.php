<?php

declare(strict_types=1);

namespace App\Modules\Welcome;

use App\Modules\Welcome\UseCases\CreateGreeting\CreateGreetingHandler;
use App\Modules\Welcome\UseCases\GetGreeting\GetGreetingHandler;
use DI\Container;
use DI\ContainerBuilder;
use Fastbill\Phoenix\Framework\Foundation\Config\Support\ConfigSchemaProviderRegistry;
use Fastbill\Phoenix\Framework\Foundation\Container\Interfaces\ServiceProviderInterface;
use function DI\autowire;
use function DI\decorate;

/**
 * Welcome Module Service Provider
 *
 * Service providers are the primary mechanism for registering modules
 * and their dependencies within the Phoenix application kernel.
 *
 * A service provider has three main methods:
 * - getDependencies(): Declare other providers this one depends on
 * - register(): Configure the DI container (before it's built)
 * - boot(): Initialize services (after container is built)
 *
 * @see vendor/fastbill/phoenix-framework/docs/service-providers.md
 */
class WelcomeServiceProvider implements ServiceProviderInterface
{
    /**
     * Declare dependencies on other service providers.
     *
     * These providers will be registered and booted before this one.
     * This ensures that services we depend on are available.
     *
     * @return array List of service provider class names
     */
    public function getDependencies(): array
    {
        // No dependencies for this simple module
        return [];
    }

    /**
     * Register services with the DI container.
     *
     * Called during the container building phase. Use this to:
     * - Register service definitions
     * - Configure autowiring
     * - Register configuration schema providers
     *
     * IMPORTANT: The container is not yet built, so you cannot
     * resolve services here. Use boot() for that.
     *
     * @param ContainerBuilder $builder
     */
    public function register(ContainerBuilder $builder): void
    {
        $builder->addDefinitions([
            // Register configuration schema provider
            ConfigSchemaProviderRegistry::class => decorate(function (ConfigSchemaProviderRegistry $registry) {
                return $registry->register(new WelcomeConfigSchemaProvider());
            }),

            // Register UseCase handlers
            // Handlers must be registered for the DispatcherService to resolve them
            CreateGreetingHandler::class => autowire(CreateGreetingHandler::class),
            GetGreetingHandler::class => autowire(GetGreetingHandler::class),
        ]);
    }

    /**
     * Bootstrap the module after the container is built.
     *
     * Called after all providers are registered and the container is built.
     * Use this for:
     * - Middleware registration
     * - Event listener registration
     * - Service initialization that requires other services
     *
     * @param Container $container
     */
    public function boot(Container $container): void
    {
        // No boot-time initialization needed for this module
    }
}
