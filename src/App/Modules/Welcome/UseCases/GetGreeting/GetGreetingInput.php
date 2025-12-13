<?php

declare(strict_types=1);

namespace App\Modules\Welcome\UseCases\GetGreeting;

use Fastbill\Phoenix\Framework\Primitives\UseCase\AbstractUseCaseInput;
use Fastbill\Phoenix\Framework\Support\Data\Validation\ValidationSchema;
use Fastbill\Phoenix\Framework\Support\Data\Validation\ValidationSchemaRule;

/**
 * Input for GetGreeting UseCase
 *
 * A simple input demonstrating the minimal structure needed.
 */
class GetGreetingInput extends AbstractUseCaseInput
{
    private string $name;

    protected function schema(): ValidationSchema
    {
        return ValidationSchema::structure([
            'name' => ValidationSchemaRule::string()
                ->required()
                ->min(1)
                ->max(100),
        ]);
    }

    protected function hydrate(object $normalized): void
    {
        $this->name = $normalized->name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
