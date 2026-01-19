# Phoenix Starter

A minimal starter template for [Phoenix Framework](https://github.com/fastbill/phoenix) applications.

## Quick Start

```bash
# Clone the repository
git clone https://github.com/fastbill/phoenix-starter.git my-app
cd my-app

# Copy environment file
cp .env.example .env

# Start Docker
docker compose -f docker-compose.yml -f docker-compose.dev.yml up -d

# Install dependencies
docker compose exec app composer install

# Install git hooks
docker compose exec app composer hooks:install
```

Open [http://localhost:8080](http://localhost:8080)

## Project Structure

```
my-app/
├── App/
│   ├── ApplicationKernel.php    # Application kernel
│   └── Http/
│       ├── RouteProvider.php    # Route definitions
│       └── Controller/
│           └── HomeController.php
├── config/
│   └── .config.php              # Application config
├── public/
│   └── index.php                # Web entry point
├── templates/
│   └── home.html.twig           # Twig templates
├── docker-compose.yml
├── docker-compose.dev.yml
├── composer.json
├── phpunit.xml
├── phpstan.neon
└── .php-cs-fixer.php
```

## Development

### Docker Commands

```bash
# Start services
docker compose -f docker-compose.yml -f docker-compose.dev.yml up -d

# View logs
docker compose logs -f app

# Run commands in container
docker compose exec app <command>

# Stop services
docker compose down
```

### Code Quality

```bash
# Run tests
docker compose exec app composer test

# Run PHPStan
docker compose exec app composer phpstan

# Fix code style
docker compose exec app composer cs:fix

# Check code style (dry-run)
docker compose exec app composer cs:check
```

### With Queue Worker

```bash
docker compose -f docker-compose.yml -f docker-compose.dev.yml --profile queue up -d
```

## Services

| Service | Port | Description |
|---------|------|-------------|
| App | 8080 | FrankenPHP web server |
| MySQL | 3306 | Database |
| Redis | 6379 | Cache & sessions |
| RabbitMQ | 5672, 15672 | Message queue (optional) |

## Documentation

- [Phoenix Framework Documentation](https://github.com/fastbill/phoenix/tree/main/docs)

## License

MIT
