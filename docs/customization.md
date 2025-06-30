# Customization Guide

Learn how to customize and extend BS5 Starter Kit to match your application's needs.

## 🎨 Bootstrap Customization

### Custom Variables

Override Bootstrap variables to match your brand:

```scss
// resources/sass/abstracts/_variables.scss

// Brand Colors
$primary: #007bff;
$secondary: #6c757d;
$success: #28a745;
$info: #17a2b8;
$warning: #ffc107;
$danger: #dc3545;

// Typography
$font-family-sans-serif: "Inter", system-ui, -apple-system, sans-serif;
$font-size-base: 1rem;
$line-height-base: 1.6;

// Grid System
$container-max-widths: (
  sm: 540px,
  md: 720px,
  lg: 960px,
  xl: 1140px,
  xxl: 1320px
);
```

### Custom Components

Create custom Bootstrap components:

```scss
// resources/sass/components/_custom.scss

// Gradient Cards
.card-gradient {
    background: linear-gradient(135deg, $primary, $info);
    color: white;
    border: none;

    .card-title {
        color: white;
    }

    .card-text {
        color: rgba(white, 0.9);
    }
}

// Hover Effects
.card-hover {
    transition: transform 0.2s ease-in-out;

    &:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(black, 0.15);
    }
}

// Custom Buttons
.btn-gradient {
    background: linear-gradient(45deg, $primary, $success);
    border: none;
    color: white;

    &:hover {
        background: linear-gradient(45deg, darken($primary, 10%), darken($success, 10%));
        color: white;
    }
}
```

## 🏗️ SASS Architecture

### 7-1 Structure

BS5 Starter Kit uses the 7-1 SASS architecture:

```
resources/sass/
├── abstracts/
│   ├── _variables.scss    # Custom variables
│   ├── _functions.scss    # SASS functions
│   └── _mixins.scss       # SASS mixins
├── base/
│   ├── _reset.scss        # CSS reset
│   ├── _typography.scss   # Typography rules
│   └── _helpers.scss      # Utility classes
├── components/
│   ├── _buttons.scss      # Button styles
│   ├── _cards.scss        # Card styles
│   ├── _alerts.scss       # Alert styles
│   └── _modal.scss        # Modal styles
├── layout/
│   ├── _header.scss       # Header styles
│   ├── _footer.scss       # Footer styles
│   ├── _sidebar.scss      # Sidebar styles
│   └── _forms.scss        # Form layouts
├── vendors/
│   └── _bootstrap.scss    # Bootstrap imports
└── app.scss               # Main file
```

### Adding Custom Sections

Extend the architecture for your needs:

```scss
// resources/sass/app.scss

// ... existing imports ...

// 6. Pages (new)
@import 'pages/home';
@import 'pages/dashboard';
@import 'pages/profile';

// 7. Themes (new)
@import 'themes/dark';
@import 'themes/light';

// 8. Utilities (new)
@import 'utilities/spacing';
@import 'utilities/colors';
```

## 🧩 Blade Components

### Custom Component Creation

Create reusable Blade components:

```php
// app/View/Components/CustomCard.php
<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CustomCard extends Component
{
    public function __construct(
        public string $title = '',
        public string $variant = 'default',
        public bool $shadow = true,
        public bool $hover = false
    ) {}

    public function render()
    {
        return view('components.custom-card');
    }
}
```

```blade
{{-- resources/views/components/custom-card.blade.php --}}
@props(['title' => '', 'variant' => 'default', 'shadow' => true, 'hover' => false])

@php
$classes = collect([
    'card',
    $shadow ? 'shadow' : '',
    $hover ? 'card-hover' : '',
    $variant !== 'default' ? 'card-' . $variant : ''
])->filter()->implode(' ');
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    @if($title)
        <div class="card-header">
            <h5 class="card-title mb-0">{{ $title }}</h5>
        </div>
    @endif
    <div class="card-body">
        {{ $slot }}
    </div>
</div>
```

### Component Registration

Register components in your service provider:

```php
// app/Providers/AppServiceProvider.php
public function boot()
{
    Blade::component('custom-card', \App\View\Components\CustomCard::class);
    Blade::component('data-table', \App\View\Components\DataTable::class);
    Blade::component('stats-widget', \App\View\Components\StatsWidget::class);
}
```

## ⚡ JavaScript Customization

### Extending BS5Kit Utilities

Customize the JavaScript utilities:

```javascript
// resources/js/custom.js

// Extend BS5Kit with custom methods
window.BS5Kit = {
    ...window.BS5Kit,

    // Custom notification
    notification(title, message, type = 'info') {
        const toast = this.createNotificationElement(title, message, type);
        const container = document.getElementById('toast-container') || this.createToastContainer();
        container.appendChild(toast);

        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
    },

    createNotificationElement(title, message, type) {
        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-white bg-${this.getBootstrapType(type)} border-0`;
        toast.setAttribute('role', 'alert');
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    <div class="fw-bold">${title}</div>
                    <div>${message}</div>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        return toast;
    },

    // Custom modal
    modal(content, title = 'Modal', size = 'md') {
        return new Promise((resolve) => {
            const modal = this.createModalElement(content, title, size, resolve);
            document.body.appendChild(modal);

            const bsModal = new bootstrap.Modal(modal);
            bsModal.show();

            modal.addEventListener('hidden.bs.modal', () => {
                modal.remove();
            });
        });
    }
};
```

### Custom Bootstrap Interactions

Add custom Bootstrap component behaviors:

```javascript
// resources/js/interactions.js

document.addEventListener('DOMContentLoaded', function() {
    // Auto-dismiss alerts after 5 seconds
    document.querySelectorAll('.alert-auto-dismiss').forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });

    // Enhanced dropdown behavior
    document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
        toggle.addEventListener('show.bs.dropdown', function() {
            this.classList.add('active');
        });

        toggle.addEventListener('hide.bs.dropdown', function() {
            this.classList.remove('active');
        });
    });

    // Form validation enhancements
    document.querySelectorAll('.needs-validation').forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();

                BS5Kit.toast('Please fix the errors in the form', 'warning');
            }
            form.classList.add('was-validated');
        });
    });
});
```

## 🎯 Layout Customization

### Custom Layouts

Create custom layout components:

```blade
{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="admin-layout">
    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="sidebar bg-dark text-white">
            <div class="sidebar-header p-3">
                <h4>Admin Panel</h4>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link text-white" href="/admin/dashboard">
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="/admin/users">
                        Users
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="content flex-grow-1">
            <div class="container-fluid p-4">
                {{ $slot }}
            </div>
        </main>
    </div>
</body>
</html>
```

### Layout Styling

Style your custom layouts:

```scss
// resources/sass/layout/_admin.scss

.admin-layout {
    height: 100vh;
    overflow: hidden;

    .sidebar {
        width: 250px;
        min-height: 100vh;
        flex-shrink: 0;

        .nav-link {
            padding: 0.75rem 1rem;
            border-radius: 0;

            &:hover {
                background-color: rgba(white, 0.1);
            }

            &.active {
                background-color: $primary;
            }
        }
    }

    .content {
        overflow-y: auto;
        background-color: $gray-100;
    }
}
```

## 🎨 Theming

### Dark Theme Implementation

Create a dark theme variant:

```scss
// resources/sass/themes/_dark.scss

[data-theme="dark"] {
    // Override Bootstrap variables for dark theme
    --bs-body-bg: #{$gray-900};
    --bs-body-color: #{$gray-100};
    --bs-border-color: #{$gray-700};

    // Card styling
    .card {
        background-color: $gray-800;
        border-color: $gray-700;
        color: $gray-100;

        .card-header {
            background-color: $gray-700;
            border-bottom-color: $gray-600;
        }
    }

    // Button variants
    .btn-light {
        background-color: $gray-700;
        border-color: $gray-600;
        color: $gray-100;

        &:hover {
            background-color: $gray-600;
            border-color: $gray-500;
        }
    }
}
```

### Theme Switcher

Add a theme switching mechanism:

```javascript
// resources/js/theme-switcher.js

class ThemeSwitcher {
    constructor() {
        this.theme = localStorage.getItem('theme') || 'light';
        this.applyTheme();
        this.bindEvents();
    }

    applyTheme() {
        document.documentElement.setAttribute('data-theme', this.theme);
        localStorage.setItem('theme', this.theme);
    }

    toggleTheme() {
        this.theme = this.theme === 'light' ? 'dark' : 'light';
        this.applyTheme();
        BS5Kit.toast(`Switched to ${this.theme} theme`, 'info');
    }

    bindEvents() {
        document.querySelectorAll('[data-theme-toggle]').forEach(toggle => {
            toggle.addEventListener('click', () => this.toggleTheme());
        });
    }
}

// Initialize theme switcher
document.addEventListener('DOMContentLoaded', () => {
    new ThemeSwitcher();
});
```

## 📱 Responsive Customization

### Custom Breakpoints

Define custom responsive breakpoints:

```scss
// resources/sass/abstracts/_variables.scss

// Custom breakpoints
$grid-breakpoints: (
  xs: 0,
  sm: 576px,
  md: 768px,
  lg: 992px,
  xl: 1200px,
  xxl: 1400px,
  xxxl: 1600px  // Custom extra large
);

// Custom container sizes
$container-max-widths: (
  sm: 540px,
  md: 720px,
  lg: 960px,
  xl: 1140px,
  xxl: 1320px,
  xxxl: 1520px  // Custom container
);
```

### Responsive Utilities

Create custom responsive utility classes:

```scss
// resources/sass/utilities/_responsive.scss

// Custom spacing for larger screens
@include media-breakpoint-up(xxxl) {
    .p-xxxl-5 { padding: 3rem !important; }
    .m-xxxl-5 { margin: 3rem !important; }
}

// Custom text sizes
.text-responsive {
    font-size: 1rem;

    @include media-breakpoint-up(md) {
        font-size: 1.25rem;
    }

    @include media-breakpoint-up(lg) {
        font-size: 1.5rem;
    }
}

// Container variations
.container-narrow {
    max-width: 800px;
    margin: 0 auto;
    padding: 0 15px;
}
```

## 🔧 Advanced Customization

### Custom Build Process

Customize the asset build process:

```javascript
// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/sass/admin.scss',  // Additional entry point
                'resources/js/app.js',
                'resources/js/admin.js'       // Additional entry point
            ],
            refresh: true,
        }),
    ],
    css: {
        preprocessorOptions: {
            scss: {
                additionalData: `@import "resources/sass/abstracts/variables";`
            }
        }
    }
});
```

### Environment-Specific Customization

Customize based on environment:

```scss
// resources/sass/abstracts/_variables.scss

// Development-specific styles
@if $env == 'development' {
    $enable-debug: true;
    $border-width: 2px;  // Thicker borders for debugging
}

// Production optimizations
@if $env == 'production' {
    $enable-rounded: true;
    $enable-shadows: true;
}
```

---

For more advanced customization techniques, see the [Usage Examples](usage-examples.md) or explore the Bootstrap 5 customization documentation.
