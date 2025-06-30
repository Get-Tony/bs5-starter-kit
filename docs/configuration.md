# Configuration Guide

Comprehensive configuration options for BS5 Starter Kit.

## 🎛️ Configuration File

BS5 Starter Kit uses a configuration file to manage settings and behavior.

### Publishing Configuration

```bash
php artisan bs5:publish --config
```

This creates `config/bs5-kit.php` with all available options.

### Default Configuration

```php
<?php

return [
    /*
    |--------------------------------------------------------------------------
    | BS5 Starter Kit Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration options for BS5 Starter Kit.
    | You can customize these settings to match your application's needs.
    |
    */

    'version' => '1.0.9',

    /*
    |--------------------------------------------------------------------------
    | Installation Components
    |--------------------------------------------------------------------------
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
```

## ⚙️ Configuration Options

### Bootstrap Settings

Configure Bootstrap installation and features:

```php
'bootstrap' => [
    'version' => '^5.3',              // Bootstrap version constraint
    'include_icons' => true,          // Include Bootstrap Icons
    'include_popper' => true,         // Include Popper.js for dropdowns/tooltips
],
```

### SASS Architecture

Configure SASS compilation and organization:

```php
'sass' => [
    'architecture' => '7-1',          // Use 7-1 SASS architecture
    'directories' => [               // SASS directory structure
        'abstracts',                 // Variables, functions, mixins
        'base',                      // Reset, typography, helpers
        'components',                // Buttons, cards, alerts, etc.
        'layout',                    // Header, footer, navigation
        'vendors',                   // Bootstrap, third-party
    ],
],
```

### Installation Presets

Customize the preset configurations:

```php
'presets' => [
    'minimal' => [
        'bootstrap' => true,
        'sass' => false,
        'auth' => false,
    ],
    'custom' => [                    // Add your own preset
        'bootstrap' => true,
        'sass' => true,
        'auth' => true,
        // Add custom options here
    ],
],
```

## 🛠️ Environment Variables

### Asset Configuration

Configure asset compilation in your `.env` file:

```env
# Vite Configuration
VITE_APP_NAME="${APP_NAME}"

# Asset Compilation
MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

### Bootstrap Customization

Create custom Bootstrap variables in `resources/sass/abstracts/_variables.scss`:

```scss
// Custom Bootstrap Variables
$primary: #0d6efd;                  // Primary color
$secondary: #6c757d;                // Secondary color
$success: #198754;                  // Success color
$info: #0dcaf0;                     // Info color
$warning: #ffc107;                  // Warning color
$danger: #dc3545;                   // Danger color

// Typography
$font-family-sans-serif: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
$font-size-base: 1rem;
$line-height-base: 1.5;

// Spacing
$spacer: 1rem;
$spacers: (
  0: 0,
  1: $spacer * .25,
  2: $spacer * .5,
  3: $spacer,
  4: $spacer * 1.5,
  5: $spacer * 3,
);

// Grid breakpoints
$grid-breakpoints: (
  xs: 0,
  sm: 576px,
  md: 768px,
  lg: 992px,
  xl: 1200px,
  xxl: 1400px
);
```

## 📦 Package Configuration

### Composer Configuration

Configure package dependencies in `composer.json`:

```json
{
    "require": {
        "get-tony/bs5-starter-kit": "^1.0"
    },
    "config": {
        "optimize-autoloader": true,
        "preferred-install": "dist",
        "sort-packages": true
    }
}
```

### NPM Configuration

Configure frontend dependencies in `package.json`:

```json
{
    "devDependencies": {
        "bootstrap": "^5.3.0",
        "@popperjs/core": "^2.11.6",
        "sass": "^1.69.0",
        "vite": "^4.0.0",
        "laravel-vite-plugin": "^0.8.0"
    },
    "scripts": {
        "dev": "vite",
        "build": "vite build",
        "preview": "vite preview"
    }
}
```

## 🎨 Vite Configuration

Customize asset compilation in `vite.config.js`:

```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/sass/app.scss', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    css: {
        preprocessorOptions: {
            scss: {
                api: 'modern-compiler' // Use modern Sass API
            }
        }
    },
    resolve: {
        alias: {
            '~bootstrap': 'bootstrap',
        }
    },
});
```

## 🔧 Advanced Configuration

### Custom Components

Register custom components in a service provider:

```php
// In your AppServiceProvider.php
public function boot()
{
    Blade::component('custom-card', \App\View\Components\CustomCard::class);
    Blade::component('data-table', \App\View\Components\DataTable::class);
}
```

### SASS Customization

Extend the SASS architecture in `resources/sass/app.scss`:

```scss
// BS5 Starter Kit - Main SASS Entry Point
// 1. Configuration and helpers
@import 'abstracts/variables';
@import 'abstracts/functions';
@import 'abstracts/mixins';

// 2. Vendors
@import 'vendors/bootstrap';

// 3. Base stuff
@import 'base/reset';
@import 'base/typography';
@import 'base/helpers';

// 4. Layout-related sections
@import 'layout/header';
@import 'layout/footer';
@import 'layout/forms';

// 5. Components
@import 'components/buttons';
@import 'components/cards';
@import 'components/alerts';

// 6. Custom additions
@import 'custom/components';
@import 'custom/utilities';
```

### JavaScript Configuration

Customize JavaScript utilities in `resources/js/app.js`:

```javascript
// Custom BS5Kit configuration
window.BS5Kit = {
    // Override default toast position
    toastPosition: 'top-center',

    // Custom toast types
    toastTypes: {
        info: 'primary',
        success: 'success',
        warning: 'warning',
        error: 'danger',
        // Add custom types
        custom: 'info'
    },

    // Extend existing functionality
    toast(message, type = 'info') {
        // Your custom toast implementation
    }
};
```

## 📊 Performance Configuration

### Production Optimization

Optimize for production environments:

```bash
# Optimize Composer autoloader
composer install --optimize-autoloader --no-dev

# Build production assets
npm run build

# Cache Laravel configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Asset Optimization

Configure asset optimization in `vite.config.js`:

```javascript
export default defineConfig({
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ['bootstrap', '@popperjs/core'],
                    app: ['./resources/js/app.js']
                }
            }
        }
    }
});
```

---

For more configuration options, see the [Customization Guide](customization.md) or check the published configuration file after running `php artisan bs5:publish --config`.
