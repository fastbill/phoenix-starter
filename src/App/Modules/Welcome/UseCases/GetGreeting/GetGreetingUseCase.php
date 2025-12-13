<?php

declare(strict_types=1);

namespace App\Modules\Welcome\UseCases\GetGreeting;

use Fastbill\Phoenix\Framework\Primitives\UseCase\Annotations\HandledBy;
use Fastbill\Phoenix\Framework\Primitives\UseCase\UseCaseInputInterface;
use Fastbill\Phoenix\Framework\Primitives\UseCase\UseCaseInterface;

/**
 * GetGreeting UseCase
 *
 * Retrieves a greeting for a given name. Demonstrates a simpler,
 * query-like UseCase pattern.
 *
 * @HandledBy(handler=GetGreetingHandler::class)
 */
class GetGreetingUseCase implements UseCaseInterface
{
    private GetGreetingInput $input;

    public function __construct(GetGreetingInput $input)
    {
        $this->input = $input;
    }

    public function getInput(): UseCaseInputInterface
    {
        return $this->input;
    }
}
