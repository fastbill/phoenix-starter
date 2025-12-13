<?php

declare(strict_types=1);

namespace App\Modules\Welcome\UseCases\CreateGreeting;

use Fastbill\Phoenix\Framework\Primitives\UseCase\Annotations\HandledBy;
use Fastbill\Phoenix\Framework\Primitives\UseCase\UseCaseInputInterface;
use Fastbill\Phoenix\Framework\Primitives\UseCase\UseCaseInterface;

/**
 * CreateGreeting UseCase
 *
 * UseCases are the highest-level abstraction in Phoenix's CQRS architecture.
 * They represent complete business operations that orchestrate commands,
 * queries, and events.
 *
 * Key characteristics:
 * - Carry validated input via getInput()
 * - Are bound to exactly one handler via @HandledBy annotation
 * - Return a UseCase-specific Result object (success or failure)
 * - Cannot be dispatched from within another UseCase (enforced by middleware)
 *
 * The @HandledBy annotation:
 * - Makes the handler binding explicit and visible in code
 * - Enables IDE navigation (click-through to handler)
 * - Is used by AnnotationHandlerLocator to resolve the handler
 *
 * @HandledBy(handler=CreateGreetingHandler::class)
 *
 * @see vendor/fastbill/phoenix-framework/docs/usecases.md
 */
class CreateGreetingUseCase implements UseCaseInterface
{
    private CreateGreetingInput $input;

    public function __construct(CreateGreetingInput $input)
    {
        $this->input = $input;
    }

    /**
     * Get the validated input for this use case.
     *
     * The input is guaranteed to be valid (validated during construction).
     *
     * @return CreateGreetingInput
     */
    public function getInput(): UseCaseInputInterface
    {
        return $this->input;
    }
}
