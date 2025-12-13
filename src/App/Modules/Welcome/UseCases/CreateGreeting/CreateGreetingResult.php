<?php

declare(strict_types=1);

namespace App\Modules\Welcome\UseCases\CreateGreeting;

use Fastbill\Phoenix\Framework\Primitives\UseCase\AbstractUseCaseResult;
use InvalidArgumentException;
use Throwable;

/**
 * Result for CreateGreeting UseCase
 *
 * Results follow the Success/Failure pattern:
 * - Success results carry a typed payload
 * - Failure results carry an error (Throwable)
 *
 * Always check isSuccess()/isFailure() before accessing payload or error.
 * Accessing payload on a failure result throws RuntimeException.
 *
 * Best practices:
 * - Create named factory methods for common success/failure scenarios
 * - Use specific exception types for expected failure cases
 * - Return failure for expected errors, throw for unexpected errors
 *
 * @see vendor/fastbill/phoenix-framework/docs/usecases.md
 */
class CreateGreetingResult extends AbstractUseCaseResult
{
    /**
     * Create a success result with the greeting data.
     *
     * @param string $name The greeted name
     * @param string $greeting The full greeting message
     * @return self
     */
    public static function success(string $name, string $greeting): self
    {
        return new self(true, [
            'name' => $name,
            'greeting' => $greeting,
        ]);
    }

    /**
     * Create a failure result for an invalid name.
     *
     * @param string $reason Why the name is invalid
     * @return self
     */
    public static function invalidName(string $reason): self
    {
        return self::failure(new InvalidArgumentException("Invalid name: $reason"));
    }

    /**
     * Create a failure result from a generic error.
     *
     * @param Throwable $error The error that occurred
     * @return self
     */
    public static function failed(Throwable $error): self
    {
        return self::failure($error);
    }

    /**
     * Get the greeted name from a success result.
     *
     * @return string
     * @throws \RuntimeException If result is a failure
     */
    public function getName(): string
    {
        return $this->getFromPayload('name');
    }

    /**
     * Get the full greeting message from a success result.
     *
     * @return string
     * @throws \RuntimeException If result is a failure
     */
    public function getGreeting(): string
    {
        return $this->getFromPayload('greeting');
    }
}
