<?php

declare(strict_types=1);

namespace Fastbill\Phoenix\Starter;

use DI\ContainerBuilder;
use Fastbill\Phoenix\Framework\Foundation\Http\Support\RouteProviderRegistry;
use Fastbill\Phoenix\Framework\Foundation\Kernel\HttpKernel;
use Fastbill\Phoenix\Framework\Modules\ErrorPage\ErrorPageServiceProvider;
use Fastbill\Phoenix\Framework\Modules\View\ViewServiceProvider;
use Fastbill\Phoenix\Framework\Modules\ViewComponents\ViewComponentsServiceProvider;
use Fastbill\Phoenix\Starter\Http\RouteProvider;

use function DI\decorate;

class ApplicationKernel extends HttpKernel
{
    protected function providers(): array
    {
        return array_merge(parent::providers(), [
            new ViewServiceProvider(),
            new ViewComponentsServiceProvider(),
            new ErrorPageServiceProvider(),
        ]);
    }

    protected function configureContainer(ContainerBuilder $builder): void
    {
        $builder->addDefinitions([
            RouteProviderRegistry::class => decorate(function (RouteProviderRegistry $registry) {
                $registry->register(new RouteProvider());
                return $registry;
            }),
        ]);
    }
}
