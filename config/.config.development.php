<?php

/**
 * Development Environment Configuration Overrides
 *
 * These values override the base configuration when application.environment
 * is set to 'development' in .config.php.
 *
 * Development-specific settings:
 * - Enable debug mode
 * - Verbose logging
 * - Relaxed security for local testing
 */

return [
    'application' => [
        // Enable debug features in development
        'debug' => true,
    ],

    'logging' => [
        'channels' => [
            'file' => [
                // More verbose logging in development
                'level' => 'debug',
            ],
        ],
    ],
];
