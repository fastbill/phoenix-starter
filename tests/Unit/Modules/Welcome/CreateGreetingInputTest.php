<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Welcome;

use App\Modules\Welcome\UseCases\CreateGreeting\CreateGreetingInput;
use Fastbill\Phoenix\Framework\Primitives\UseCase\InputValidationException;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for CreateGreetingInput validation
 *
 * Demonstrates testing UseCase input validation.
 */
class CreateGreetingInputTest extends TestCase
{
    public function testValidInputCreatesSuccessfully(): void
    {
        $result = CreateGreetingInput::create([
            'name' => 'John Doe',
            'message' => 'Have a great day!',
        ]);

        $this->assertTrue($result->isValid());
        $this->assertInstanceOf(CreateGreetingInput::class, $result->getInput());
        $this->assertEquals('John Doe', $result->getInput()->getName());
        $this->assertEquals('Have a great day!', $result->getInput()->getMessage());
    }

    public function testValidInputWithoutOptionalMessage(): void
    {
        $result = CreateGreetingInput::create([
            'name' => 'Jane Doe',
        ]);

        $this->assertTrue($result->isValid());
        $this->assertNull($result->getInput()->getMessage());
    }

    public function testEmptyNameIsInvalid(): void
    {
        $result = CreateGreetingInput::create([
            'name' => '',
        ]);

        $this->assertFalse($result->isValid());
        $this->assertNotEmpty($result->getErrors());
    }

    public function testMissingNameIsInvalid(): void
    {
        $result = CreateGreetingInput::create([]);

        $this->assertFalse($result->isValid());
        $this->assertNotEmpty($result->getErrors());
    }

    public function testNameTooLongIsInvalid(): void
    {
        $result = CreateGreetingInput::create([
            'name' => str_repeat('a', 101), // Exceeds max of 100
        ]);

        $this->assertFalse($result->isValid());
    }

    public function testCreateOrFailThrowsOnInvalidInput(): void
    {
        $this->expectException(InputValidationException::class);

        CreateGreetingInput::createOrFail([]);
    }

    public function testCreateOrFailReturnsInputOnValidData(): void
    {
        $input = CreateGreetingInput::createOrFail([
            'name' => 'Test User',
        ]);

        $this->assertInstanceOf(CreateGreetingInput::class, $input);
        $this->assertEquals('Test User', $input->getName());
    }
}
