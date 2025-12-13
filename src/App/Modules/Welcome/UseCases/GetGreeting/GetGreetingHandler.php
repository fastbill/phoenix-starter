<?php

declare(strict_types=1);

namespace App\Modules\Welcome\UseCases\GetGreeting;

use Fastbill\Phoenix\Framework\Primitives\UseCase\UseCaseHandlerInterface;
use Fastbill\Phoenix\Framework\Primitives\UseCase\UseCaseInterface;
use Fastbill\Phoenix\Framework\Primitives\UseCase\UseCaseResultInterface;
use League\Config\Configuration;

/**
 * Handler for GetGreeting UseCase
 */
class GetGreetingHandler implements UseCaseHandlerInterface
{
    private Configuration $config;

    public function __construct(Configuration $config)
    {
        $this->config = $config;
    }

    public function handle(UseCaseInterface $useCase): UseCaseResultInterface
    {
        /** @var GetGreetingUseCase $useCase */
        /** @var GetGreetingInput $input */
        $input = $useCase->getInput();

        try {
            $prefix = $this->config->get('welcome.greeting_prefix');
            $capitalize = $this->config->get('welcome.capitalize_names');

            $name = $input->getName();

            if ($capitalize) {
                $name = ucwords(strtolower($name));
            }

            $greeting = sprintf('%s, %s! Welcome to Phoenix Framework.', $prefix, $name);

            return GetGreetingResult::success($greeting);
        } catch (\Throwable $e) {
            return GetGreetingResult::failed($e);
        }
    }
}
