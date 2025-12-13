<?php

declare(strict_types=1);

namespace App\Http\Controller;

use App\Modules\Welcome\UseCases\CreateGreeting\CreateGreetingInput;
use App\Modules\Welcome\UseCases\CreateGreeting\CreateGreetingResult;
use App\Modules\Welcome\UseCases\CreateGreeting\CreateGreetingUseCase;
use App\Modules\Welcome\UseCases\GetGreeting\GetGreetingInput;
use App\Modules\Welcome\UseCases\GetGreeting\GetGreetingUseCase;
use Fastbill\Phoenix\Framework\Foundation\Dispatcher\Services\DispatcherService;
use Fastbill\Phoenix\Framework\Modules\View\Http\Controller\ViewController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Welcome Controller
 *
 * Demonstrates the Phoenix CQRS pattern with UseCases:
 * - Input validation using AbstractUseCaseInput
 * - Dispatching UseCases via DispatcherService
 * - Handling Success/Failure results
 *
 * Controllers should be thin - they:
 * 1. Parse/validate request input
 * 2. Dispatch to UseCases or Queries
 * 3. Handle results and return responses
 */
class WelcomeController extends ViewController
{
    private DispatcherService $dispatcher;

    public function __construct(DispatcherService $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Display the welcome form.
     */
    public function index(Request $request, array $args): Response
    {
        return $this->createHtmlResponse($request, 'welcome/index', [
            'title' => 'Enter Your Name',
        ]);
    }

    /**
     * Process the welcome form submission.
     *
     * Demonstrates:
     * - Input validation with create() method
     * - UseCase dispatching
     * - Result handling (success/failure pattern)
     */
    public function store(Request $request, array $args): Response
    {
        // Get form data
        $data = $request->request->all();

        // Validate input using the UseCase input's static factory
        $inputResult = CreateGreetingInput::create($data);

        if (!$inputResult->isValid()) {
            // Return to form with validation errors
            return $this->createHtmlResponse($request, 'welcome/index', [
                'title' => 'Enter Your Name',
                'errors' => $inputResult->getErrors(),
                'old' => $data,
            ]);
        }

        // Create and dispatch the UseCase
        $useCase = new CreateGreetingUseCase($inputResult->getInput());
        /** @var CreateGreetingResult $result */
        $result = $this->dispatcher->dispatchUseCase($useCase);

        if ($result->isFailure()) {
            // Handle failure - return to form with error message
            return $this->createHtmlResponse($request, 'welcome/index', [
                'title' => 'Enter Your Name',
                'error' => $result->getError()->getMessage(),
                'old' => $data,
            ]);
        }

        // Redirect to show the greeting
        return new RedirectResponse('/welcome/' . urlencode($result->getName()));
    }

    /**
     * Display a personalized greeting.
     *
     * Demonstrates:
     * - Using createOrFail() for internal/trusted input
     * - Simple query-like UseCases
     */
    public function show(Request $request, array $args): Response
    {
        $name = $args['name'] ?? 'Guest';

        // For internal input, use createOrFail (throws on invalid input)
        $input = GetGreetingInput::createOrFail(['name' => $name]);
        $useCase = new GetGreetingUseCase($input);
        $result = $this->dispatcher->dispatchUseCase($useCase);

        if ($result->isFailure()) {
            return $this->createHtmlResponse($request, 'error', [
                'title' => 'Error',
                'message' => $result->getError()->getMessage(),
            ], 400);
        }

        return $this->createHtmlResponse($request, 'welcome/show', [
            'title' => 'Hello!',
            'greeting' => $result->getGreeting(),
        ]);
    }
}
