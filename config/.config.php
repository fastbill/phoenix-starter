<?php

declare(strict_types=1);

return [
    'application' => [
        'name' => 'Phoenix Starter App',
        'version' => '1.0.0',
        'encryption_key' => '95ead581e4b470809cd66fdecacf6a01',
    ],

    'view' => [
        'template_directories' => [
            '__main__' => [dirname(__DIR__) . '/templates'],
        ],
    ],
];
