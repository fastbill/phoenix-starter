<?php

declare(strict_types=1);

namespace App\Modules\Welcome\UseCases\CreateGreeting;

use Fastbill\Phoenix\Framework\Foundation\Dispatcher\Services\DispatcherService;
use Fastbill\Phoenix\Framework\Primitives\UseCase\UseCaseHandlerInterface;
use Fastbill\Phoenix\Framework\Primitives\UseCase\UseCaseInterface;
use Fastbill\Phoenix\Framework\Primitives\UseCase\UseCaseResultInterface;
use League\Config\Configuration;

/**
 * Handler for CreateGreeting UseCase
 *
 * Handlers contain the application logic for processing a UseCase.
 * They orchestrate Commands, Queries, and Events to fulfill the use case.
 *
 * Key responsibilities:
 * - Receive the UseCase with validated input
 * - Execute business logic (often via commands/queries)
 * - Dispatch events for side effects
 * - Return a typed Result (Success or Failure)
 *
 * Best practices:
 * - Keep handlers focused on orchestration, not business logic
 * - Return Failure for expected errors (not found, conflict, etc.)
 * - Throw for unexpected errors (infrastructure failures)
 * - Use dependency injection for all dependencies
 *
 * @see vendor/fastbill/phoenix-framework/docs/usecases.md
 */
class CreateGreetingHandler implements UseCaseHandlerInterface
{
    private Configuration $config;
    private DispatcherService $dispatcher;

    public function __construct(Configuration $config, DispatcherService $dispatcher)
    {
        $this->config = $config;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Handle the CreateGreeting use case.
     *
     * @param UseCaseInterface $useCase The use case to handle
     * @return UseCaseResultInterface The result of the operation
     */
    public function handle(UseCaseInterface $useCase): UseCaseResultInterface
    {
        /** @var CreateGreetingUseCase $useCase */
        /** @var CreateGreetingInput $input */
        $input = $useCase->getInput();

        try {
            // Get configuration values
            $prefix = $this->config->get('welcome.greeting_prefix');
            $capitalize = $this->config->get('welcome.capitalize_names');
            $maxLength = $this->config->get('welcome.max_name_length');

            $name = $input->getName();

            // Validate name length against config
            if (strlen($name) > $maxLength) {
                return CreateGreetingResult::invalidName(
                    "Name must not exceed $maxLength characters"
                );
            }

            // Apply name capitalization if configured
            if ($capitalize) {
                $name = ucwords(strtolower($name));
            }

            // Build the greeting
            $customMessage = $input->getMessage();
            if ($customMessage) {
                $greeting = sprintf('%s, %s! %s', $prefix, $name, $customMessage);
            } else {
                $greeting = sprintf('%s, %s! Welcome to Phoenix Framework.', $prefix, $name);
            }

            // In a real application, you might:
            // 1. Dispatch a command to persist the greeting
            //    $this->dispatcher->dispatchCommand(new SaveGreetingCommand($name, $greeting));
            //
            // 2. Dispatch an event to notify other parts of the system
            //    $this->dispatcher->dispatchEvent(new GreetingCreatedEvent($name));

            return CreateGreetingResult::success($name, $greeting);
        } catch (\Throwable $e) {
            return CreateGreetingResult::failed($e);
        }
    }
}
