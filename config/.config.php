<?php

/**
 * Base Application Configuration
 *
 * This file contains the default configuration values for the application.
 * Environment-specific overrides can be placed in:
 * - .config.development.php
 * - .config.production.php
 * - .config.testing.php
 *
 * CLI-specific overrides (when running via bin/phoenix):
 * - .config-cli.php
 * - .config-cli.development.php
 *
 * Configuration values are accessed via the Configuration service:
 *   $config->get('application.name')
 *   $config->get('welcome.greeting_prefix')
 *
 * @see vendor/fastbill/phoenix-framework/docs/configuration.md
 */

return [
    // ==========================================================================
    // Application Configuration
    // ==========================================================================
    'application' => [
        // Application name (displayed in logs and error pages)
        'name' => 'Phoenix Starter Application',

        // Application version
        'version' => '1.0.0',

        // Environment: development, production, testing
        'environment' => 'development',

        // Encryption key for secure operations (change in production!)
        // Generate with: php -r "echo bin2hex(random_bytes(32));"
        'encryption_key' => 'change-me-in-production-use-random-32-bytes',
    ],

    // ==========================================================================
    // View Configuration
    // ==========================================================================
    'view' => [
        // Template directories (Twig)
        // __main__ is the default namespace
        'template_directories' => [
            '__main__' => [dirname(__DIR__) . '/resources/twig/templates/web'],
        ],

        // Asset configuration (optional)
        'assets' => [
            'base_path' => '/',
            'javascript' => [],
            'stylesheet' => null,
        ],
    ],

    // ==========================================================================
    // Welcome Module Configuration
    // ==========================================================================
    'welcome' => [
        // Greeting prefix used in welcome messages
        'greeting_prefix' => 'Hello',

        // Maximum allowed length for names
        'max_name_length' => 100,

        // Whether to capitalize names automatically
        'capitalize_names' => true,
    ],

    // ==========================================================================
    // Logging Configuration
    // ==========================================================================
    'logging' => [
        // Default log channel
        'default' => 'file',

        // Available log channels
        'channels' => [
            'file' => [
                'path' => dirname(__DIR__) . '/var/log/app.log',
                'level' => 'debug',
            ],
        ],
    ],
];
