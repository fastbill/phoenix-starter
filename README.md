# Phoenix Starter

A minimal starter template for [Phoenix Framework](https://git2.fastbill.com/phoenix/framework) applications.

## Quick Start

```bash
# Clone the repository
git clone git@git2.fastbill.com:phoenix/phoenix-starter.git my-app
cd my-app
rm -rf .git && git init

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
├── docker-compose.yml           # Production config
├── docker-compose.dev.yml       # Development overrides
├── .gitlab-ci.yml               # CI/CD pipeline
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

## Docker Images

This starter uses Phoenix Docker images from the FastBill registry:

| Image | Purpose |
|-------|---------|
| `docker.fastbill.com/phoenix/devops/docker-images/webapp` | Production web server |
| `docker.fastbill.com/phoenix/devops/docker-images/webapp-dev` | Development (with Xdebug) |
| `docker.fastbill.com/phoenix/devops/docker-images/worker-dev` | Queue worker (development) |

See [docker-images](https://git2.fastbill.com/phoenix/devops/docker-images) for all available images.

## CI/CD

This starter includes a GitLab CI pipeline with linting and testing enabled by default.

### Enabled Jobs

| Job | Description |
|-----|-------------|
| `cs-check` | Code style checking (PHP-CS-Fixer) |
| `phpstan:php74` | Static analysis (PHP 7.4) |
| `phpstan:php84` | Static analysis (PHP 8.4) |
| `test:php74` | Tests (PHP 7.4) |
| `test:php84` | Tests with coverage (PHP 8.4) |

### Enabling Additional Jobs

The following jobs are disabled by default. To enable them, remove or comment out the corresponding section in `.gitlab-ci.yml`:

```yaml
# To enable documentation deployment:
# pages:
#   rules:
#     - when: never

# To enable release workflow (requires GITLAB_API_TOKEN):
# create-release:
#   rules:
#     - when: never

# To enable Slack notifications (requires SLACK_WEBHOOK_URL):
# notify-slack:
#   rules:
#     - when: never

# To enable Satis publishing (for Composer packages):
# satis-update:
#   rules:
#     - when: never
```

See [ci-templates](https://git2.fastbill.com/phoenix/devops/ci-templates) for full documentation.

## Documentation

- [Phoenix Framework](https://git2.fastbill.com/phoenix/framework)
- [CI Templates](https://git2.fastbill.com/phoenix/devops/ci-templates)
- [Docker Images](https://git2.fastbill.com/phoenix/devops/docker-images)
- [Code Quality](https://git2.fastbill.com/phoenix/code-quality)

## License

MIT
