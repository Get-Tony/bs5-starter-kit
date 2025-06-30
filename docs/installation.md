# Installation Guide

Complete installation options for BS5 Starter Kit - a pure Bootstrap 5 starter kit for Laravel.

## 📦 Installation Methods

### Quick Installation (Recommended)

For most projects, use the standard preset:

```bash
composer require get-tony/bs5-starter-kit
php artisan bs5:install --preset=standard
npm install && npm run build
```

### Preset Installations

Choose the preset that best fits your project:

```bash
# Minimal setup (Bootstrap only)
php artisan bs5:install --preset=minimal

# Standard setup (Bootstrap + SASS)
php artisan bs5:install --preset=standard

# Full setup (Everything + Authentication)
php artisan bs5:install --preset=full
```

### Individual Components

Install specific components as needed:

```bash
# Install specific components
php artisan bs5:install --bootstrap --sass
php artisan bs5:install --auth
php artisan bs5:install --bootstrap  # Bootstrap only
```

### Advanced Publishing

For advanced users who need granular control:

```bash
# Publish configuration file
php artisan bs5:publish --config

# Publish stub files for customization
php artisan bs5:publish --stubs

# Publish example components
php artisan bs5:publish --components

# List all available options
php artisan bs5:publish --list
```

### Laravel vendor:publish Support

Use Laravel's standard publishing system:

```bash
# Granular resource publishing
php artisan vendor:publish --tag=bs5-kit-sass      # SASS architecture only
php artisan vendor:publish --tag=bs5-kit-auth      # Authentication views only
php artisan vendor:publish --tag=bs5-kit-layouts   # Layout templates only
php artisan vendor:publish --tag=bs5-kit-components # Blade components only
php artisan vendor:publish --tag=bs5-kit-pages     # Example pages only
php artisan vendor:publish --tag=bs5-kit-js        # JavaScript files only
php artisan vendor:publish --tag=bs5-kit-vite      # Vite configuration only
php artisan vendor:publish --tag=bs5-kit-config    # Configuration only
php artisan vendor:publish --tag=bs5-kit-stubs     # All stub files for development

# Publish everything
php artisan vendor:publish --provider="LaravelBs5Kit\Bs5KitServiceProvider"
```

## 🔧 Requirements

### System Requirements

- **Laravel 10+ | 11+ | 12+**
- **PHP 8.2+**
- **Node.js 18+** and **NPM**
- **Composer 2.0+**

### Compatibility Matrix

| Laravel Version | PHP Version | Node.js Version | Status |
|----------------|-------------|-----------------|---------|
| 10.x           | 8.2+        | 18+             | ✅ Supported |
| 11.x           | 8.2+        | 18+             | ✅ Supported |
| 12.x           | 8.3+        | 18+             | ✅ Supported |

## 🚀 Step-by-Step Installation

### For New Projects

1. **Create Laravel Project**

   ```bash
   composer create-project laravel/laravel my-project
   cd my-project
   ```

2. **Install BS5 Starter Kit**

   ```bash
   composer require get-tony/bs5-starter-kit
   php artisan bs5:install --preset=full
   ```

3. **Install Frontend Dependencies**

   ```bash
   npm install
   npm run build
   ```

4. **Start Development**

   ```bash
   php artisan serve
   ```

### For Existing Projects

1. **Install Package**

   ```bash
   composer require get-tony/bs5-starter-kit
   ```

2. **Choose Installation Method**

   ```bash
   # For new frontend setup
   php artisan bs5:install --preset=standard

   # For minimal Bootstrap integration
   php artisan bs5:install --preset=minimal
   ```

3. **Install Dependencies**

   ```bash
   npm install
   npm run build
   ```

## 🎯 What Gets Installed

### Minimal Preset
- Bootstrap 5.3+ JavaScript and CSS
- Basic Vite configuration
- Essential Bootstrap utilities

### Standard Preset
- Everything from Minimal
- 7-1 SASS architecture
- Professional stylesheet organization
- Custom Bootstrap variables and mixins

### Full Preset
- Everything from Standard
- Complete authentication system
- Login, registration, and profile pages
- Professional dashboard layout

## ⚠️ Important Notes

- **Clean Installation** - BS5 Starter Kit provides a clean Bootstrap foundation
- **No Conflicts** - Designed to work with any JavaScript approach
- **Backup First** - Always backup existing projects before installation
- **Version Compatibility** - Ensure Laravel version compatibility

## 🔗 Next Steps

- [Configuration Guide](configuration.md) - Customize BS5 Starter Kit
- [Usage Examples](usage-examples.md) - Learn component usage
- [Customization Guide](customization.md) - Extend functionality
