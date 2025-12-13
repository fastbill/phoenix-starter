# Phoenix Framework Starter

A starter project template for building applications with the [Phoenix PHP Framework](https://github.com/fastbill/phoenix-framework).

## Quick Start

```bash
# Clone the repository
git clone https://github.com/fastbill/phoenix-starter.git my-app
cd my-app

# Install dependencies
composer install

# Start the development server
composer serve
```

Open [http://localhost:8080](http://localhost:8080) in your browser.

## Project Structure

```
phoenix-starter/
├── config/
│   ├── .config.php                 # Base configuration
│   ├── .config.development.php     # Development overrides
│   └── .config.production.php      # Production overrides
├── public/
│   └── index.php                   # Web entry point
├── resources/
│   └── twig/
│       └── templates/              # Twig templates
├── src/
│   └── App/
│       ├── ApplicationKernel.php   # Application kernel
│       ├── Http/
│       │   ├── RouteProvider.php   # Route definitions
│       │   └── Controller/         # HTTP controllers
│       └── Modules/
│           └── Welcome/            # Example module
│               ├── WelcomeServiceProvider.php
│               ├── WelcomeConfigSchemaProvider.php
│               └── UseCases/
│                   ├── CreateGreeting/
│                   └── GetGreeting/
├── tests/
│   ├── Unit/
│   └── Integration/
├── var/
│   └── log/                        # Application logs
├── composer.json
├── phpunit.xml
└── README.md
```

## Key Concepts

### Application Kernel

The `ApplicationKernel` (`src/App/ApplicationKernel.php`) is the entry point of your application. It:

- Extends `HttpKernel` for web applications
- Registers service providers via `providers()`
- Configures the DI container via `configureContainer()`
- Registers routes via `RouteProviderRegistry`

```php
class ApplicationKernel extends HttpKernel
{
    protected function providers(): array
    {
        return array_merge(parent::providers(), [
            new ViewServiceProvider(),
            new ViewComponentsServiceProvider(),
            new YourModuleServiceProvider(),
        ]);
    }
}
```

### Service Providers

Service providers bootstrap modules and configure dependency injection. They implement `ServiceProviderInterface`:

```php
class YourModuleServiceProvider implements ServiceProviderInterface
{
    public function getDependencies(): array
    {
        return []; // Other providers this depends on
    }

    public function register(ContainerBuilder $builder): void
    {
        // Register DI definitions (before container is built)
    }

    public function boot(Container $container): void
    {
        // Initialize services (after container is built)
    }
}
```

### UseCases (CQRS Pattern)

Phoenix uses the CQRS pattern. UseCases are the highest-level abstraction for business operations:

1. **Input** - Validated input data (`AbstractUseCaseInput`)
2. **UseCase** - The operation with `@HandledBy` annotation
3. **Handler** - Business logic that returns a Result
4. **Result** - Success/Failure outcome (`AbstractUseCaseResult`)

Example:

```php
// 1. Create validated input
$result = CreateGreetingInput::create(['name' => 'John']);
if (!$result->isValid()) {
    return $result->getErrors();
}

// 2. Create and dispatch UseCase
$useCase = new CreateGreetingUseCase($result->getInput());
$result = $dispatcher->dispatchUseCase($useCase);

// 3. Handle the result
if ($result->isSuccess()) {
    return $result->getGreeting();
}
```

### Configuration

Configuration uses schema providers for type-safe access:

```php
// In config/.config.php
return [
    'welcome' => [
        'greeting_prefix' => 'Hello',
        'max_name_length' => 100,
    ],
];

// Access in your code
$prefix = $config->get('welcome.greeting_prefix');
```

## Creating a New Module

1. **Create the module directory**:
   ```
   src/App/Modules/YourModule/
   ├── YourModuleServiceProvider.php
   ├── YourModuleConfigSchemaProvider.php
   └── UseCases/
       └── YourUseCase/
           ├── YourUseCaseInput.php
           ├── YourUseCase.php
           ├── YourUseCaseHandler.php
           └── YourUseCaseResult.php
   ```

2. **Create the UseCase Input**:
   ```php
   class YourUseCaseInput extends AbstractUseCaseInput
   {
       private string $field;

       protected function schema(): ValidationSchema
       {
           return ValidationSchema::structure([
               'field' => ValidationSchemaRule::string()->required(),
           ]);
       }

       protected function hydrate(object $normalized): void
       {
           $this->field = $normalized->field;
       }

       public function getField(): string
       {
           return $this->field;
       }
   }
   ```

3. **Create the UseCase**:
   ```php
   /**
    * @HandledBy(handler=YourUseCaseHandler::class)
    */
   class YourUseCase implements UseCaseInterface
   {
       private YourUseCaseInput $input;

       public function __construct(YourUseCaseInput $input)
       {
           $this->input = $input;
       }

       public function getInput(): UseCaseInputInterface
       {
           return $this->input;
       }
   }
   ```

4. **Create the Handler**:
   ```php
   class YourUseCaseHandler implements UseCaseHandlerInterface
   {
       public function handle(UseCaseInterface $useCase): UseCaseResultInterface
       {
           $input = $useCase->getInput();
           // Business logic here
           return YourUseCaseResult::success($data);
       }
   }
   ```

5. **Create the Result**:
   ```php
   class YourUseCaseResult extends AbstractUseCaseResult
   {
       public static function success($data): self
       {
           return new self(true, ['data' => $data]);
       }

       public function getData()
       {
           return $this->getFromPayload('data');
       }
   }
   ```

6. **Register in the Service Provider**:
   ```php
   public function register(ContainerBuilder $builder): void
   {
       $builder->addDefinitions([
           YourUseCaseHandler::class => autowire(YourUseCaseHandler::class),
       ]);
   }
   ```

7. **Add the provider to `ApplicationKernel`**:
   ```php
   protected function providers(): array
   {
       return array_merge(parent::providers(), [
           // ...
           new YourModuleServiceProvider(),
       ]);
   }
   ```

## Commands and Queries

For simpler operations, use Commands (write) and Queries (read) directly:

```php
// Command (changes state)
class CreateUserCommand implements CommandInterface
{
    public function __construct(
        public readonly string $name,
        public readonly string $email
    ) {}
}

class CreateUserCommandHandler implements CommandHandlerInterface
{
    public function handle(CommandInterface $command): void
    {
        // Create the user
    }
}

// Query (reads data)
class GetUserQuery implements QueryInterface
{
    public function __construct(public readonly int $userId) {}
}

class GetUserQueryHandler implements QueryHandlerInterface
{
    public function handle(QueryInterface $query): ?UserModel
    {
        return $this->repository->find($query->userId);
    }
}
```

Handlers are resolved by naming convention: `{Message}Handler`.

## Testing

```bash
# Run all tests
composer test

# Run with coverage
composer test-coverage
```

## Documentation

- [Getting Started](https://github.com/fastbill/phoenix-framework/blob/main/docs/getting-started.md)
- [Service Providers](https://github.com/fastbill/phoenix-framework/blob/main/docs/service-providers.md)
- [UseCases](https://github.com/fastbill/phoenix-framework/blob/main/docs/usecases.md)
- [Commands](https://github.com/fastbill/phoenix-framework/blob/main/docs/commands.md)
- [Queries](https://github.com/fastbill/phoenix-framework/blob/main/docs/queries.md)
- [Configuration](https://github.com/fastbill/phoenix-framework/blob/main/docs/configuration.md)
- [Dispatcher Service](https://github.com/fastbill/phoenix-framework/blob/main/docs/dispatcher-service.md)

## License

MIT License - see [LICENSE](LICENSE) for details.
