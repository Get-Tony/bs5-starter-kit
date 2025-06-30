# BS5 Starter Kit Testing

Comprehensive testing suite for BS5 Starter Kit quality assurance.

## 🧪 Test Overview

BS5 Starter Kit includes a comprehensive test suite to ensure quality and reliability:

- **Unit Tests**: 41 tests covering service provider and command functionality
- **Feature Tests**: Installation, publishing, and component integration
- **Integration Tests**: Real-world package installation and functionality validation

## 🚀 Running Tests

### Quick Test

Run all tests with the convenient wrapper script:

```bash
./test
```

### Specific Test Types

Run specific categories of tests:

```bash
./test phpunit          # PHPUnit tests only
./test composer         # Composer validation
./test frontend         # Frontend asset tests
```

### Manual PHPUnit

Run PHPUnit tests directly:

```bash
vendor/bin/phpunit
vendor/bin/phpunit --filter InstallCommandTest
vendor/bin/phpunit --coverage-html build/coverage
```

## 📋 Test Categories

### Unit Tests

**Service Provider Tests** (`tests/Unit/ServiceProviderTest.php`):
- Service provider registration
- Configuration merging
- Command registration

**Command Tests** (`tests/Unit/CommandsTest.php`):
- Command signature validation
- Command registration verification
- Command description accuracy

### Feature Tests

**Install Command Tests** (`tests/Feature/InstallCommandTest.php`):
- Preset installation (minimal, standard, full)
- Individual component installation
- Error handling and help messages

**Publish Command Tests** (`tests/Feature/PublishCommandTest.php`):
- Configuration publishing
- Stub file publishing
- Vendor publish integration

### Integration Tests

Real-world functionality validation:
- Complete Laravel application creation
- Package installation via Composer
- Asset compilation and building
- Server startup and basic functionality

## 🔧 Test Configuration

### PHPUnit Configuration

Tests are configured in `phpunit.xml`:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit bootstrap="vendor/autoload.php"
         colors="true"
         processIsolation="false"
         stopOnFailure="false">
    <testsuites>
        <testsuite name="BS5Kit Test Suite">
            <directory suffix="Test.php">./tests</directory>
        </testsuite>
    </testsuites>

    <coverage>
        <report>
            <html outputDirectory="build/coverage"/>
            <clover outputFile="build/logs/clover.xml"/>
        </report>
    </coverage>

    <source>
        <include>
            <directory suffix=".php">./src</directory>
        </include>
    </source>
</phpunit>
```

### Test Environment

Tests use Orchestra Testbench for Laravel integration:

```php
// tests/TestCase.php
<?php

namespace LaravelBs5Kit\Tests;

use LaravelBs5Kit\Bs5KitServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            Bs5KitServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
    }
}
```

## 📊 Test Coverage

Current test coverage includes:

### Commands
- ✅ `bs5:install` command with all presets
- ✅ `bs5:publish` command with all options
- ✅ Error handling and validation
- ✅ Help and usage information

### Service Provider
- ✅ Package registration
- ✅ Configuration merging
- ✅ Command registration
- ✅ Publishable resources

### Installation Process
- ✅ Bootstrap installation
- ✅ SASS architecture setup
- ✅ Authentication scaffolding
- ✅ Asset compilation

### File Generation
- ✅ JavaScript file creation
- ✅ SASS file structure
- ✅ Layout file generation
- ✅ Component publishing

## 🎯 Quality Standards

### Code Quality

All code must meet these standards:

- **PSR-12** coding standard compliance
- **PHPStan** level 8 static analysis
- **100% test coverage** for critical functionality
- **No deprecated** function usage

### Testing Standards

All tests must:

- **Be isolated** - No dependencies between tests
- **Be repeatable** - Same results every time
- **Be fast** - Complete test suite under 30 seconds
- **Be clear** - Descriptive test names and assertions

### Performance Standards

- **Installation time** - Under 60 seconds for full preset
- **Asset compilation** - Under 30 seconds for production build
- **Memory usage** - Under 128MB for test suite
- **File size** - Generated assets under 500KB total

## 🔍 Debugging Tests

### Verbose Output

Get detailed test output:

```bash
./test -v                           # Verbose output
vendor/bin/phpunit --verbose        # PHPUnit verbose
vendor/bin/phpunit --debug          # Debug mode
```

### Test Specific Issues

Debug specific test failures:

```bash
# Run single test method
vendor/bin/phpunit --filter=test_can_install_minimal_preset

# Run single test class
vendor/bin/phpunit tests/Feature/InstallCommandTest.php

# Stop on first failure
vendor/bin/phpunit --stop-on-failure
```

### Coverage Reports

Generate and view coverage reports:

```bash
vendor/bin/phpunit --coverage-html build/coverage
open build/coverage/index.html    # macOS
xdg-open build/coverage/index.html # Linux
```

## 🛠️ Contributing Tests

### Writing New Tests

When adding new features, include tests:

```php
<?php

namespace LaravelBs5Kit\Tests\Feature;

use LaravelBs5Kit\Tests\TestCase;

class NewFeatureTest extends TestCase
{
    /** @test */
    public function it_can_do_something_new()
    {
        // Arrange
        $input = 'test data';

        // Act
        $result = $this->performAction($input);

        // Assert
        $this->assertEquals('expected result', $result);
    }
}
```

### Test Naming

Follow these naming conventions:

- **Test methods**: `test_it_can_do_something` or `it_can_do_something`
- **Test classes**: `FeatureNameTest.php`
- **Descriptive names**: Clearly describe what is being tested

### Test Organization

Organize tests logically:

```
tests/
├── Feature/           # Feature tests (integration)
│   ├── InstallCommandTest.php
│   └── PublishCommandTest.php
├── Unit/              # Unit tests (isolated)
│   ├── ServiceProviderTest.php
│   └── CommandsTest.php
└── TestCase.php       # Base test class
```

## 📈 Continuous Integration

### GitHub Actions

Tests run automatically on:

- **Push to main** - Full test suite
- **Pull requests** - Full test suite
- **Daily schedule** - Compatibility checks

### Test Matrix

Tests run across:

- **PHP versions**: 8.2, 8.3, 8.4
- **Laravel versions**: 10.x, 11.x, 12.x
- **Dependencies**: lowest, stable

### Status Badges

Check current test status:

[![Tests](https://github.com/get-tony/bs5-starter-kit/workflows/tests/badge.svg)](https://github.com/get-tony/bs5-starter-kit/actions)

---

For more information about testing Laravel packages, see the [Laravel Testing Documentation](https://laravel.com/docs/testing) and [Orchestra Testbench](https://github.com/orchestral/testbench).
