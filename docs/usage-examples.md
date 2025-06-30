# Usage Examples

Practical code examples and patterns for BS5 Starter Kit.

## 🎨 Bootstrap Components

### Cards

Professional card components with Bootstrap styling:

```blade
{{-- Basic Card --}}
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Card Title</h5>
    </div>
    <div class="card-body">
        <p class="card-text">Some quick example text to build on the card title.</p>
        <a href="#" class="btn btn-primary">Go somewhere</a>
    </div>
</div>

{{-- Card with Image --}}
<div class="card" style="width: 18rem;">
    <img src="..." class="card-img-top" alt="...">
    <div class="card-body">
        <h5 class="card-title">Card title</h5>
        <p class="card-text">Some quick example text.</p>
        <a href="#" class="btn btn-primary">Go somewhere</a>
    </div>
</div>

{{-- Card Group --}}
<div class="card-group">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">This is a wider card with supporting text.</p>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">This card has supporting text below.</p>
        </div>
    </div>
</div>
```

### Buttons

Professional button styling with Bootstrap:

```blade
{{-- Button Variants --}}
<button type="button" class="btn btn-primary">Primary</button>
<button type="button" class="btn btn-secondary">Secondary</button>
<button type="button" class="btn btn-success">Success</button>
<button type="button" class="btn btn-danger">Danger</button>
<button type="button" class="btn btn-warning">Warning</button>
<button type="button" class="btn btn-info">Info</button>

{{-- Button Sizes --}}
<button type="button" class="btn btn-primary btn-lg">Large button</button>
<button type="button" class="btn btn-secondary btn-sm">Small button</button>

{{-- Button with Icons --}}
<button type="button" class="btn btn-primary">
    <i class="bi bi-download"></i> Download
</button>

{{-- Loading Button --}}
<button class="btn btn-primary" type="button" disabled>
    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
    Loading...
</button>
```

### Forms

Professional form styling:

```blade
<form>
    <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="email" placeholder="name@example.com">
        <div class="form-text">We'll never share your email with anyone else.</div>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password">
    </div>

    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="remember">
        <label class="form-check-label" for="remember">
            Remember me
        </label>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
```

### Alerts

Bootstrap alert components:

```blade
{{-- Basic Alerts --}}
<div class="alert alert-primary" role="alert">
    A simple primary alert—check it out!
</div>

{{-- Dismissible Alert --}}
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Holy guacamole!</strong> You should check in on some of those fields below.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

{{-- Alert with Icon --}}
<div class="alert alert-success d-flex align-items-center" role="alert">
    <i class="bi bi-check-circle-fill me-2"></i>
    <div>
        An example success alert with an icon
    </div>
</div>
```

### Modals

Bootstrap modal implementation:

```blade
{{-- Modal Trigger --}}
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Launch demo modal
</button>

{{-- Modal --}}
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Modal body content goes here.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
```

## 🎯 JavaScript Utilities

### Toast Notifications

Using BS5Kit JavaScript utilities:

```javascript
// Basic toast
BS5Kit.toast('Operation completed successfully!', 'success');

// Different types
BS5Kit.toast('This is an info message', 'info');
BS5Kit.toast('Warning: Please check your input', 'warning');
BS5Kit.toast('Error: Something went wrong', 'error');

// Custom usage in Blade templates
```

```blade
<button class="btn btn-success" onclick="BS5Kit.toast('Welcome to BS5 Starter Kit!', 'success')">
    Show Success Toast
</button>
```

### Confirm Dialogs

Interactive confirmation dialogs:

```javascript
// Basic confirm dialog
async function deleteItem() {
    const confirmed = await BS5Kit.confirm('Are you sure you want to delete this item?', 'Confirm Delete');
    if (confirmed) {
        // Proceed with deletion
        BS5Kit.toast('Item deleted successfully!', 'success');
    }
}
```

```blade
<button class="btn btn-danger" onclick="deleteItem()">
    Delete Item
</button>
```

### Tooltips and Popovers

Bootstrap tooltips and popovers (auto-initialized):

```blade
{{-- Tooltips --}}
<button type="button" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Tooltip on top">
    Tooltip on top
</button>

{{-- Popovers --}}
<button type="button" class="btn btn-lg btn-danger" data-bs-toggle="popover" title="Popover title"
        data-bs-content="And here's some amazing content. It's very engaging. Right?">
    Click to toggle popover
</button>
```

## 🏗️ Layout Examples

### Application Layout

Using the main application layout:

```blade
<x-app-layout>
    <div class="container my-5">
        <div class="row">
            <div class="col-md-8">
                <h1>Page Title</h1>
                <p>Main content goes here.</p>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Sidebar</h5>
                    </div>
                    <div class="card-body">
                        Sidebar content
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
```

### Guest Layout

For authentication pages:

```blade
<x-guest-layout>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">Login</h4>
        </div>
        <div class="card-body">
            <form>
                <!-- Login form content -->
            </form>
        </div>
    </div>
</x-guest-layout>
```

## 📊 Dashboard Examples

### Statistics Cards

Professional dashboard statistics:

```blade
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Earnings (Monthly)
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- More cards... -->
</div>
```

### Data Tables

Professional data table styling:

```blade
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">DataTable Example</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Office</th>
                        <th>Age</th>
                        <th>Start date</th>
                        <th>Salary</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Tiger Nixon</td>
                        <td>System Architect</td>
                        <td>Edinburgh</td>
                        <td>61</td>
                        <td>2011/04/25</td>
                        <td>$320,800</td>
                    </tr>
                    <!-- More rows... -->
                </tbody>
            </table>
        </div>
    </div>
</div>
```

## 🎨 SASS Customization

### Custom Variables

Customize Bootstrap variables in `resources/sass/abstracts/_variables.scss`:

```scss
// Custom brand colors
$primary: #007bff;
$secondary: #6c757d;
$success: #28a745;
$info: #17a2b8;
$warning: #ffc107;
$danger: #dc3545;

// Custom spacing
$spacer: 1rem;
$spacers: (
  0: 0,
  1: ($spacer * .25),
  2: ($spacer * .5),
  3: $spacer,
  4: ($spacer * 1.5),
  5: ($spacer * 3),
  6: ($spacer * 4),
  7: ($spacer * 5)
);

// Custom typography
$font-family-sans-serif: "Inter", system-ui, -apple-system, sans-serif;
$font-size-base: 1rem;
$line-height-base: 1.6;
```

### Custom Components

Create custom component styles in `resources/sass/components/_custom.scss`:

```scss
// Custom card variants
.card-gradient {
    background: linear-gradient(135deg, $primary, $info);
    color: white;

    .card-title, .card-text {
        color: white;
    }
}

// Custom button styles
.btn-outline-gradient {
    border: 2px solid transparent;
    background: linear-gradient(white, white) padding-box,
                linear-gradient(135deg, $primary, $info) border-box;
    color: $primary;

    &:hover {
        background: linear-gradient(135deg, $primary, $info);
        color: white;
    }
}

// Utility classes
.shadow-soft {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
}

.border-radius-lg {
    border-radius: 0.5rem !important;
}
```

## 🔧 Best Practices

### Component Organization

Organize your Blade components:

```php
// app/View/Components/Card.php
<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Card extends Component
{
    public function __construct(
        public string $title = '',
        public string $variant = 'default',
        public bool $shadow = true
    ) {}

    public function render()
    {
        return view('components.card');
    }
}
```

```blade
{{-- resources/views/components/card.blade.php --}}
<div class="card {{ $shadow ? 'shadow' : '' }} {{ $variant !== 'default' ? 'bg-'.$variant : '' }}">
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

### Form Validation

Bootstrap form validation styling:

```blade
<form class="needs-validation" novalidate>
    <div class="mb-3">
        <label for="validationCustom01" class="form-label">First name</label>
        <input type="text" class="form-control" id="validationCustom01" required>
        <div class="valid-feedback">
            Looks good!
        </div>
        <div class="invalid-feedback">
            Please provide a valid first name.
        </div>
    </div>

    <button class="btn btn-primary" type="submit">Submit form</button>
</form>

<script>
// Bootstrap form validation
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();
</script>
```

---

For more examples and advanced usage, check out the [Customization Guide](customization.md) or explore the Bootstrap 5 documentation.
