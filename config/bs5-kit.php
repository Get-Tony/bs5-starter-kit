<?php

return [
    /*
    |--------------------------------------------------------------------------
    | BS5 Starter Kit Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration options for the BS5 Starter Kit.
    | BS5 Kit provides Bootstrap 5 components and SASS architecture for Laravel.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Default Stack Components
    |--------------------------------------------------------------------------
    |
    | These options control which components are installed by default
    | when running the bs5:install command.
    |
    */

    'install' => [
        'bootstrap' => true,
        'sass' => true,
        'auth' => false, // Install authentication scaffolding
    ],

    /*
    |--------------------------------------------------------------------------
    | Bootstrap Configuration
    |--------------------------------------------------------------------------
    |
    | Configure Bootstrap installation options.
    |
    */

    'bootstrap' => [
        'version' => '^5.3',
        'include_icons' => true, // Include Bootstrap Icons
        'include_popper' => true, // Include Popper.js for tooltips/dropdowns
    ],

    /*
    |--------------------------------------------------------------------------
    | SASS Configuration
    |--------------------------------------------------------------------------
    |
    | Configure SASS/SCSS compilation options.
    |
    */

    'sass' => [
        'architecture' => '7-1', // Use 7-1 SASS architecture
        'directories' => [
            'abstracts',
            'base',
            'components',
            'layout',
            'vendors',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | File Paths
    |--------------------------------------------------------------------------
    |
    | Configure where BS5 Kit files should be installed.
    |
    */

    'paths' => [
        'resources' => 'resources',
        'views' => 'resources/views',
        'sass' => 'resources/sass',
        'js' => 'resources/js',
    ],

    /*
    |--------------------------------------------------------------------------
    | Preset Configurations
    |--------------------------------------------------------------------------
    |
    | Pre-configured setups for different use cases.
    |
    */

    'presets' => [
        'minimal' => [
            'bootstrap' => true,
            'sass' => false,
            'auth' => false,
        ],
        'standard' => [
            'bootstrap' => true,
            'sass' => true,
            'auth' => false,
        ],
        'full' => [
            'bootstrap' => true,
            'sass' => true,
            'auth' => true,
        ],
    ],
];
