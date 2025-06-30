# Laravel BS5 Starter Kit

[![Latest Version on Packagist](https://img.shields.io/packagist/v/get-tony/bs5-starter-kit.svg?style=flat-square)](https://packagist.org/packages/get-tony/bs5-starter-kit)
[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](https://opensource.org/licenses/MIT)
[![Laravel](https://img.shields.io/badge/Laravel-10%2B%20%7C%2011%2B%20%7C%2012%2B-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-blue.svg)](https://php.net)
[![Version](https://img.shields.io/badge/Version-1.0.2%20Release-green.svg)](https://github.com/get-tony/bs5-starter-kit/releases/tag/v1.0.2)

A modern, production-ready Laravel starter kit built exclusively with **Bootstrap 5** and **SASS architecture**. Clean, professional, and dependency-free.

## ✨ What is BS5 Starter Kit?

**BS5 Starter Kit** is a pure Bootstrap 5 foundation for Laravel applications, designed for developers who want:

- 🎨 **Bootstrap 5.3+** - Latest Bootstrap with all components and utilities
- 🏗️ **7-1 SASS Architecture** - Professional, maintainable stylesheet organization
- 🔐 **Authentication System** - Complete login, registration, and user management
- 🧩 **Reusable Components** - Professional Blade components ready for production
- ⚡ **JavaScript Utilities** - Custom utilities built on Bootstrap's JavaScript
- 🎯 **Zero Dependencies** - No additional JavaScript frameworks required

## 🚀 Quick Start

### New Project

```bash
composer create-project laravel/laravel my-app
cd my-app
composer require get-tony/bs5-starter-kit
php artisan bs5:install --preset=full
npm install && npm run build
php artisan serve
```

### Existing Project

```bash
composer require get-tony/bs5-starter-kit
php artisan bs5:install --preset=standard
npm install && npm run build
```

## 🎯 What You Get

- **Complete Authentication** - Login, registration, password reset, and profile management
- **Professional UI Components** - Cards, buttons, alerts, modals, forms with Bootstrap styling
- **Responsive Design** - Mobile-first, Bootstrap 5 responsive grid and components
- **SASS Architecture** - Organized 7-1 SASS structure for scalable stylesheets
- **JavaScript Utilities** - Toast notifications, confirm dialogs, and component helpers
- **Production Ready** - Optimized for enterprise and professional applications

## 🔧 System Requirements

- **Laravel 10+ | 11+ | 12+**
- **PHP 8.2+**
- **Node.js 18+** and **NPM**
- **Composer 2.0+**

## 📚 Installation Options

### Preset Installations

```bash
# Minimal (Bootstrap only)
php artisan bs5:install --preset=minimal

# Standard (Bootstrap + SASS)
php artisan bs5:install --preset=standard

# Full (Bootstrap + SASS + Authentication)
php artisan bs5:install --preset=full
```

### Individual Components

```bash
# Install specific components
php artisan bs5:install --bootstrap --sass
php artisan bs5:install --auth
```

## 🎨 Your First Component

```blade
<x-app-layout>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Welcome to BS5 Starter Kit!</h3>
                    </div>
                    <div class="card-body">
                        <p class="lead">Your Bootstrap 5 application is ready to build.</p>

                        <button class="btn btn-primary" onclick="BS5Kit.toast('Hello World!', 'success')">
                            Show Toast
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
```

## 🧪 Testing & Quality Assurance

```bash
# Run all tests
./test

# Test specific components
./test phpunit
./test frontend
./test composer
```

## 📖 Documentation

### 🎯 For Developers
- **[Installation Guide](docs/installation.md)** - Complete installation options
- **[Configuration](docs/configuration.md)** - Customize settings and behavior
- **[Usage Examples](docs/usage-examples.md)** - Code examples and patterns
- **[Customization](docs/customization.md)** - Extend and modify components

### 🌟 For Users & Community
- **[GitHub Wiki](https://github.com/get-tony/bs5-starter-kit/wiki)** - Tutorials, examples, and community guides
- **[Video Tutorials](https://github.com/get-tony/bs5-starter-kit/wiki/Video-Tutorials)** - Visual walkthroughs
- **[Community Examples](https://github.com/get-tony/bs5-starter-kit/wiki/Community-Examples)** - User implementations

## 🌟 Key Features

### ✅ Production Ready
- Comprehensive test suite for quality assurance
- Enterprise-grade authentication system
- Professional UI components and layouts
- Optimized asset compilation with Vite

### ⚡ Modern Stack
- Bootstrap 5.3+ with latest features
- SASS with 7-1 architecture
- Modern JavaScript utilities
- Laravel 10+, 11+, and 12+ support

### 🎯 Pure Bootstrap Foundation
- No conflicting JavaScript frameworks
- Clean, maintainable codebase
- Professional enterprise styling
- Fully responsive design system

## ⚠️ Important Notes

- **Pure Bootstrap 5** - No additional JavaScript frameworks required
- **Enterprise Ready** - Perfect for professional and secure environments
- **Dependency Free** - Clean foundation you can build upon
- **Production Tested** - Used in real-world applications

## 📄 License

BS5 Starter Kit is open-sourced software licensed under the [MIT license](LICENSE).

## 🔗 Links

- **[Packagist](https://packagist.org/packages/get-tony/bs5-starter-kit)** - Official package
- **[GitHub](https://github.com/get-tony/bs5-starter-kit)** - Source code
- **[Email Support](mailto:get-tony@outlook.com)** - Direct support

---

**Ready to get started?** Check out the [Installation Guide](docs/installation.md) and build your next Laravel application with Bootstrap 5!
