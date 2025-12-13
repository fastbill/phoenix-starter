<?php

declare(strict_types=1);

namespace App;

use App\Http\RouteProvider;
use App\Modules\Welcome\WelcomeServiceProvider;
use DI\ContainerBuilder;
use Fastbill\Phoenix\Framework\Foundation\Http\Support\RouteProviderRegistry;
use Fastbill\Phoenix\Framework\Foundation\Kernel\HttpKernel;
use Fastbill\Phoenix\Framework\Modules\ErrorPage\ErrorPageServiceProvider;
use Fastbill\Phoenix\Framework\Modules\View\ViewServiceProvider;
use Fastbill\Phoenix\Framework\Modules\ViewComponents\ViewComponentsServiceProvider;
use function DI\decorate;

/**
 * Application Kernel
 *
 * The kernel is the entry point of your application. It bootstraps the
 * framework, registers service providers, and configures the dependency
 * injection container.
 *
 * Key responsibilities:
 * - Register application service providers via providers()
 * - Configure DI container via configureContainer()
 * - Register application routes via RouteProviderRegistry
 */
class ApplicationKernel extends HttpKernel
{
    /**
     * Return the list of service providers for this application.
     *
     * The parent HttpKernel automatically includes:
     * - ConfigServiceProvider
     * - KernelServiceProvider
     * - DispatcherServiceProvider
     * - LoggingServiceProvider
     * - StorageServiceProvider
     * - FilesystemServiceProvider
     * - HttpServiceProvider
     *
     * Add your application-specific providers here.
     *
     * @return array
     */
    protected function providers(): array
    {
        return array_merge(parent::providers(), [
            // Framework modules
            new ViewServiceProvider(),
            new ViewComponentsServiceProvider(),
            new ErrorPageServiceProvider(),

            // Application modules
            new WelcomeServiceProvider(),
        ]);
    }

    /**
     * Configure the dependency injection container.
     *
     * Use this method to:
     * - Register route providers
     * - Add custom DI definitions
     * - Decorate framework services
     *
     * @param ContainerBuilder $builder
     */
    protected function configureContainer(ContainerBuilder $builder): void
    {
        $builder->addDefinitions([
            // Register application routes
            RouteProviderRegistry::class => decorate(function (RouteProviderRegistry $registry) {
                $registry->register(new RouteProvider());
                return $registry;
            }),
        ]);
    }
}
