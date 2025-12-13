<?php

declare(strict_types=1);

namespace App\Modules\Welcome;

use Fastbill\Phoenix\Framework\Foundation\Config\Interfaces\ConfigSchemaProviderInterface;
use Nette\Schema\Expect;

/**
 * Welcome Module Configuration Schema Provider
 *
 * Defines the configuration schema for the Welcome module.
 * Schema providers ensure type-safe configuration with validation.
 *
 * Configuration values are accessed via:
 *   $config->get('welcome.greeting_prefix')
 *
 * @see vendor/fastbill/phoenix-framework/docs/configuration.md
 */
class WelcomeConfigSchemaProvider implements ConfigSchemaProviderInterface
{
    /**
     * Register the configuration schema for this module.
     *
     * Uses Nette Schema for defining configuration structure,
     * types, defaults, and validation rules.
     *
     * @param array $schemaCollection Existing schemas (ignored)
     * @return array Schema definitions keyed by config path
     */
    public function registerSchema(array $schemaCollection): array
    {
        return [
            'welcome' => Expect::structure([
                // The prefix used for greetings
                'greeting_prefix' => Expect::string('Hello'),

                // Maximum allowed name length
                'max_name_length' => Expect::int(100)->min(1)->max(500),

                // Whether to capitalize names
                'capitalize_names' => Expect::bool(true),
            ]),
        ];
    }
}
