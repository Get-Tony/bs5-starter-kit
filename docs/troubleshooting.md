# Troubleshooting Guide

Common issues and solutions for BS5 Starter Kit.

## 🔧 Installation Issues

### Package Not Found

**Problem**: `composer require get-tony/bs5-starter-kit` fails.

**Solutions**:

```bash
# Clear Composer cache
composer clear-cache

# Update Composer to latest version
composer self-update

# Check minimum requirements
composer check-platform-reqs
```

### NPM Installation Failures

**Problem**: `npm install` fails with dependency errors.

**Solutions**:

```bash
# Clear npm cache
npm cache clean --force

# Delete node_modules and package-lock.json
rm -rf node_modules package-lock.json

# Reinstall dependencies
npm install

# Alternative: Use npm ci for clean install
npm ci
```

### Command Not Found

**Problem**: `php artisan bs5:install` command not recognized.

**Solutions**:

```bash
# Clear Laravel cache
php artisan config:clear
php artisan cache:clear

# Rediscover packages
composer dump-autoload
php artisan package:discover

# Check if package is properly installed
composer show get-tony/bs5-starter-kit
```

## 🎨 Asset Compilation Issues

### Vite Build Failures

**Problem**: `npm run build` fails with errors.

**Solutions**:

```bash
# Check Vite configuration
cat vite.config.js

# Clear Vite cache
npx vite --force

# Check Node.js version (requires 18+)
node --version

# Update dependencies
npm update
```

### SASS Compilation Errors

**Problem**: SASS compilation fails with import errors.

**Solutions**:

```scss
// Check import paths in resources/sass/app.scss
@import 'abstracts/variables';  // ✓ Correct
@import '~bootstrap';            // ✓ Correct
@import './variables';           // ✗ Incorrect path
```

**Fix missing variables**:

```scss
// resources/sass/abstracts/_variables.scss
$primary: #0d6efd !default;
$secondary: #6c757d !default;
// ... other Bootstrap variables
```

### Missing Bootstrap Icons

**Problem**: Bootstrap icons not displaying.

**Solutions**:

```bash
# Install Bootstrap Icons
npm install bootstrap-icons

# Include in SASS
@import '~bootstrap-icons/font/bootstrap-icons';
```

## 🚀 Runtime Issues

### JavaScript Errors

**Problem**: `BS5Kit is not defined` error.

**Solutions**:

```javascript
// Check if app.js is properly loaded
console.log(window.BS5Kit); // Should show object

// Ensure Vite assets are included in layout
@vite(['resources/sass/app.scss', 'resources/js/app.js'])

// Check browser console for loading errors
```

### Bootstrap Components Not Working

**Problem**: Dropdowns, modals, or tooltips not functioning.

**Solutions**:

```javascript
// Check if Bootstrap JavaScript is loaded
console.log(window.bootstrap); // Should show Bootstrap object

// Manually initialize components if needed
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
```

### Toast Notifications Not Appearing

**Problem**: `BS5Kit.toast()` doesn't show notifications.

**Solutions**:

```javascript
// Check if toast container exists
const container = document.getElementById('toast-container');
console.log(container); // Should exist

// Manually create container if missing
if (!container) {
    const toastContainer = document.createElement('div');
    toastContainer.id = 'toast-container';
    toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
    document.body.appendChild(toastContainer);
}
```

## 🔒 Authentication Issues

### Views Not Found

**Problem**: Authentication views return 404 errors.

**Solutions**:

```bash
# Check if auth views are published
ls -la resources/views/auth/

# Republish auth views
php artisan bs5:install --auth --force

# Clear view cache
php artisan view:clear
```

### Styling Issues

**Problem**: Authentication forms look unstyled.

**Solutions**:

```blade
<!-- Check if layout includes BS5 styles -->
@vite(['resources/sass/app.scss', 'resources/js/app.js'])

<!-- Ensure forms use Bootstrap classes -->
<form class="needs-validation" novalidate>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" required>
    </div>
</form>
```

### Route Issues

**Problem**: Authentication routes not working.

**Solutions**:

```bash
# Check route list
php artisan route:list | grep auth

# Clear route cache
php artisan route:clear

# Check middleware
php artisan route:list --middleware=auth
```

## 📱 Layout Issues

### Responsive Design Problems

**Problem**: Layout doesn't work on mobile devices.

**Solutions**:

```html
<!-- Ensure viewport meta tag is present -->
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Use Bootstrap responsive classes -->
<div class="col-12 col-md-6 col-lg-4">
    <!-- Content -->
</div>

<!-- Check responsive utilities -->
<div class="d-none d-md-block">Desktop only</div>
<div class="d-block d-md-none">Mobile only</div>
```

### CSS Conflicts

**Problem**: Custom styles conflict with Bootstrap.

**Solutions**:

```scss
// Use !important sparingly
.custom-class {
    color: red !important;
}

// Better: Use more specific selectors
.my-app .custom-class {
    color: red;
}

// Override Bootstrap variables instead
$primary: #custom-color;
@import '~bootstrap';
```

## 🛠️ Development Issues

### Hot Reload Not Working

**Problem**: Changes don't reflect during development.

**Solutions**:

```bash
# Restart Vite dev server
npm run dev

# Check if files are being watched
# Look for file paths in terminal output

# Clear browser cache
# Hard refresh (Ctrl+F5 or Cmd+Shift+R)
```

### Performance Issues

**Problem**: Slow asset compilation or loading.

**Solutions**:

```javascript
// Optimize Vite config
export default defineConfig({
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ['bootstrap', '@popperjs/core'],
                }
            }
        }
    }
});
```

```bash
# Enable production optimizations
npm run build

# Serve from dist folder
npm run preview
```

## 🧪 Testing Issues

### Tests Not Running

**Problem**: PHPUnit tests fail to execute.

**Solutions**:

```bash
# Check PHPUnit installation
vendor/bin/phpunit --version

# Run tests with verbose output
vendor/bin/phpunit --verbose

# Check test configuration
cat phpunit.xml
```

### Test Environment Issues

**Problem**: Tests fail due to environment setup.

**Solutions**:

```php
// Check test case setup
class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            \LaravelBs5Kit\Bs5KitServiceProvider::class,
        ];
    }
}
```

## 📊 Debugging Tips

### Enable Debug Mode

```bash
# Set debug mode in .env
APP_DEBUG=true

# Clear config cache
php artisan config:clear
```

### Check Logs

```bash
# View Laravel logs
tail -f storage/logs/laravel.log

# View web server logs
tail -f /var/log/apache2/error.log
# or
tail -f /var/log/nginx/error.log
```

### Browser Developer Tools

```javascript
// Check console for JavaScript errors
console.log('Debug info:', window.BS5Kit);

// Check network tab for failed requests
// Check elements tab for CSS issues
```

## 🔍 Getting Help

### Before Reporting Issues

1. **Check Documentation**: Review relevant documentation sections
2. **Search Issues**: Look through existing GitHub issues
3. **Minimal Reproduction**: Create a minimal example that reproduces the issue
4. **Environment Details**: Include Laravel, PHP, and Node.js versions

### Useful Commands for Bug Reports

```bash
# System information
php --version
node --version
npm --version
composer --version

# Laravel information
php artisan --version
php artisan about

# Package information
composer show get-tony/bs5-starter-kit
```

### Support Channels

- **GitHub Issues**: [https://github.com/Get-Tony/bs5-starter-kit/issues](https://github.com/Get-Tony/bs5-starter-kit/issues)
- **Email Support**: [get-tony@outlook.com](mailto:get-tony@outlook.com)

---

For additional help, check the [Usage Examples](usage-examples.md) or [Configuration Guide](configuration.md).

## SASS Deprecation Warnings

### Issue: Seeing deprecation warnings during `npm run build`

**Symptoms:**

```bash
Deprecation Warning [import]: Sass @import rules are deprecated...
Deprecation Warning [global-builtin]: Global built-in functions are deprecated...
Warning: 288 repetitive deprecation warnings omitted.
```

**Explanation:**
These warnings come from Bootstrap 5's internal SASS code, not your project. Bootstrap 5 still uses the legacy `@import` syntax and older SASS functions that will be deprecated in SASS 3.0.

**Why This Happens:**

- **Bootstrap 5.3.x** hasn't migrated to the new `@use/@forward` SASS module system
- **SASS 1.80+** shows deprecation warnings for legacy syntax
- These are **dependency warnings**, not errors in your code

**Solutions:**

#### ✅ Recommended: Use BS5 Kit's Smart Build Scripts

BS5 Starter Kit includes intelligent build scripts that filter these warnings:

```bash
# Clean build output (warnings filtered)
npm run build
npm run dev

# See all warnings (verbose mode)
npm run build:verbose
npm run build:raw
```

#### ✅ Manual Vite Configuration

If you need custom configuration, update your `vite.config.js`:

```javascript
export default defineConfig({
    css: {
        preprocessorOptions: {
            scss: {
                api: 'modern-compiler',
                quietDeps: true, // Suppress dependency warnings
                silenceDeprecations: [
                    'import',
                    'global-builtin',
                    'color-functions'
                ]
            }
        }
    }
});
```

#### ✅ Alternative: Use Legacy SASS

If warnings become problematic, temporarily use SASS 1.77.x:

```bash
npm install --save-dev sass@1.77.8
```

**Important Notes:**

- ✅ **These warnings don't affect functionality**
- ✅ **Your build will complete successfully**
- ✅ **Bootstrap 6 will resolve these warnings**
- ❌ **Don't modify Bootstrap's SASS files directly**

**When to Worry:**
Only worry if you see:

- **Actual build failures** (not warnings)
- **SASS errors** from your own code
- **Missing CSS** in the final build

**Future Resolution:**
Bootstrap 6 will adopt the modern SASS module system and eliminate these warnings.
