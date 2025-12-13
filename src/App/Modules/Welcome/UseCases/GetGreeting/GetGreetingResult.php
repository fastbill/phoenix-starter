<?php

declare(strict_types=1);

namespace App\Modules\Welcome\UseCases\GetGreeting;

use Fastbill\Phoenix\Framework\Primitives\UseCase\AbstractUseCaseResult;
use InvalidArgumentException;
use Throwable;

/**
 * Result for GetGreeting UseCase
 */
class GetGreetingResult extends AbstractUseCaseResult
{
    public static function success(string $greeting): self
    {
        return new self(true, ['greeting' => $greeting]);
    }

    public static function notFound(string $name): self
    {
        return self::failure(new InvalidArgumentException("No greeting found for: $name"));
    }

    public static function failed(Throwable $error): self
    {
        return self::failure($error);
    }

    public function getGreeting(): string
    {
        return $this->getFromPayload('greeting');
    }
}
