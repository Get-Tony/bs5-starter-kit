# Changelog

All notable changes to BS5 Starter Kit will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.1.0] - 2025-06-30

### Fixed

- 🧪 **PHPUnit Compatibility** - Updated all test methods to use modern `#[Test]` attribute syntax
- ❌ **Deprecation Warnings** - Eliminated 19 PHPUnit deprecation warnings from `/** @test */` doc-comment syntax
- ⚙️ **Test Configuration** - Added `phpunit.xml` configuration file with proper test suite definitions
- 🔧 **Test Suite Organization** - Defined Feature and Unit test suites for targeted test execution
- ✅ **CI/CD Compatibility** - Resolved test script failures with `--testsuite=Feature` and `--testsuite=Unit` flags

### Enhanced

- 🎯 **Test Execution** - Improved test execution with proper configuration and suite organization
- 📊 **Test Coverage** - Maintained 100% test pass rate with 34 tests (19 Feature + 15 Unit)
- 🔧 **PHPUnit 11.5+ Support** - Full compatibility with latest PHPUnit versions
- 📚 **Test Documentation** - Updated testing documentation to reflect modern practices

### Technical Details

- **Breaking Issue**: `/** @test */` annotations deprecated in PHPUnit 11.5.25, causing test failures
- **Resolution**: Converted all test methods to use `#[Test]` attribute syntax
- **Added**: `phpunit.xml` configuration for proper test suite management
- **Impact**: Clean test execution without deprecation warnings, improved CI/CD reliability

### Changed

- 🔄 **Version Update** - Updated to version 1.1.0

## [1.0.9] - 2025-06-30

### Fixed

- 🏠 **Authentication Home Route** - Fixed root route (/) to redirect authenticated users to dashboard
- 🔄 **Smart Route Replacement** - Install command now automatically updates existing root routes

### Changed

- 🔄 **Version Update** - Updated to version 1.0.9

### Technical Details

- **Issue**: Root route always showed welcome page regardless of authentication status
- **Resolution**: Install command now replaces root routes with authentication-aware version
- **Impact**: Authenticated users are automatically redirected to dashboard when visiting home page

## [1.0.2] - 2025-06-30

### Fixed

- 🔧 **Critical ES Module Fix** - Convert build helper script from CommonJS to ES module syntax
- ❌ **Build Error Resolution** - Fix "require is not defined" error in ES module environments
- ⚡ **Node.js Compatibility** - Support modern Node.js setups with package.json "type": "module"

### Technical Details

- **Breaking Issue**: Build helper used `require()` syntax but package.json specified ES modules
- **Resolution**: Convert to `import` statements for full ES module compatibility
- **Impact**: Fixes immediate build failures in fresh Laravel installations

## [1.0.1] - 2025-06-30

### Added

- 🔇 **Smart SASS Warning Suppression** - Intelligent filtering of Bootstrap deprecation warnings
- 🎯 **User-friendly Build Scripts** - Clean build output with explanatory messages
- 🛠️ **Build Helper Script** - Automated warning filtering with professional feedback
- 📚 **SASS Warning Documentation** - Comprehensive troubleshooting guide

### Enhanced

- ⚡ **Vite Configuration** - Advanced SASS settings with `quietDeps` and `silenceDeprecations`
- 📋 **NPM Scripts** - Multiple build modes: `build`, `dev`, `build:raw`, `build:verbose`
- 🎨 **User Experience** - Clear explanation of Bootstrap 5 vs SASS compatibility issues
- 📖 **Documentation** - Added troubleshooting section for SASS deprecation warnings

### Technical

- 🔧 **Warning Filtering** - Suppress Bootstrap's internal SASS deprecation warnings while preserving user code warnings
- 🎛️ **Build Options** - Clean mode for production, verbose mode for debugging
- 📝 **Educational** - Explains that warnings come from Bootstrap 5's legacy SASS code, not user project

## [1.0.0] - 2025-01-15

### Added

- 🎉 **Initial Release** - Pure Bootstrap 5 starter kit for Laravel
- 🎨 **Bootstrap 5.3+ Integration** - Complete Bootstrap framework with all components
- 🏗️ **7-1 SASS Architecture** - Professional stylesheet organization
- 🔐 **Authentication System** - Complete login, registration, and user management
- ⚡ **JavaScript Utilities** - Custom utilities built on Bootstrap's JavaScript
- 🧩 **Blade Components** - Professional, reusable UI components
- 📦 **Multiple Presets** - Minimal, Standard, and Full installation options
- 🛠️ **Artisan Commands** - `bs5:install` and `bs5:publish` for easy setup
- 🧪 **Test Suite** - Comprehensive testing for quality assurance
- 📚 **Documentation** - Complete installation and usage guides
- 🎯 **Vite Integration** - Modern asset compilation and hot reload
- 🎨 **Responsive Design** - Mobile-first Bootstrap 5 responsive system

### Features

- **Pure Bootstrap Foundation** - No additional JavaScript frameworks required
- **Enterprise Ready** - Professional components and layouts
- **Zero Dependencies** - Clean foundation you can build upon
- **Production Tested** - Optimized for real-world applications
- **Laravel 10+, 11+ & 12+ Support** - Compatible with latest Laravel versions
- **PHP 8.2+ Support** - Modern PHP features and performance

### Components Included

- Professional layouts (app, guest, auth)
- Bootstrap 5 components (cards, buttons, alerts, modals)
- Authentication views (login, register, profile)
- Welcome page with Bootstrap showcase
- SASS architecture with organized partials
- JavaScript utilities (toasts, confirmations)
- Responsive navigation and footer
- Professional form styling

### Documentation

- Installation guide with multiple options
- Configuration documentation
- Usage examples and patterns
- Customization guidelines
- Testing documentation

---

**BS5 Starter Kit v1.0.0** - A clean, professional Bootstrap 5 foundation for Laravel applications.
