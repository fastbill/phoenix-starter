<?php

declare(strict_types=1);

namespace App\Modules\Welcome\UseCases\CreateGreeting;

use Fastbill\Phoenix\Framework\Primitives\UseCase\AbstractUseCaseInput;
use Fastbill\Phoenix\Framework\Support\Data\Validation\ValidationSchema;
use Fastbill\Phoenix\Framework\Support\Data\Validation\ValidationSchemaRule;

/**
 * Input for CreateGreeting UseCase
 *
 * UseCase inputs extend AbstractUseCaseInput which provides:
 * - Validation via schema()
 * - Factory methods: create() (returns result) and createOrFail() (throws)
 * - Hydration of validated data into typed properties
 *
 * Usage:
 *   // For user input (HTTP requests) - handle validation errors gracefully
 *   $result = CreateGreetingInput::create($data);
 *   if (!$result->isValid()) {
 *       // Handle validation errors
 *       return $result->getErrors();
 *   }
 *   $input = $result->getInput();
 *
 *   // For trusted input (internal code) - throws on validation failure
 *   $input = CreateGreetingInput::createOrFail($data);
 *
 * @see vendor/fastbill/phoenix-framework/docs/usecases.md
 */
class CreateGreetingInput extends AbstractUseCaseInput
{
    private string $name;
    private ?string $message;

    /**
     * Define the validation schema.
     *
     * The schema should mirror domain invariants. Rules are applied
     * in order, and validation stops at the first failure for each field.
     *
     * @return ValidationSchema
     */
    protected function schema(): ValidationSchema
    {
        return ValidationSchema::structure([
            'name' => ValidationSchemaRule::string()
                ->required()
                ->min(1)
                ->max(100),
            'message' => ValidationSchemaRule::string()
                ->optional()
                ->max(500),
        ]);
    }

    /**
     * Hydrate the input properties from validated/normalized data.
     *
     * Called after validation succeeds. The $normalized object contains
     * the validated and type-cast data.
     *
     * @param object $normalized The validated data
     */
    protected function hydrate(object $normalized): void
    {
        $this->name = $normalized->name;
        $this->message = $normalized->message ?? null;
    }

    /**
     * Get the name for the greeting.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the optional custom message.
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }
}
