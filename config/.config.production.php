<?php

/**
 * Production Environment Configuration Overrides
 *
 * These values override the base configuration when application.environment
 * is set to 'production' in .config.php.
 *
 * IMPORTANT: Update these values for your production environment!
 */

return [
    'application' => [
        // Always disable debug in production
        'debug' => false,

        // IMPORTANT: Set a secure, random encryption key!
        // Generate with: php -r "echo bin2hex(random_bytes(32));"
        // 'encryption_key' => 'your-production-key-here',
    ],

    'logging' => [
        'channels' => [
            'file' => [
                // Only log warnings and above in production
                'level' => 'warning',
            ],
        ],
    ],
];
