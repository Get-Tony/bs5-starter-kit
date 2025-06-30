<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

    <!-- BS5 Starter Kit Assets -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="bs5-kit bg-light">
    <div class="min-vh-100 d-flex align-items-center justify-content-center py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <!-- Logo -->
                    <div class="text-center mb-4">
                        <a href="/" class="text-decoration-none">
                            <h2 class="text-primary fw-bold">{{ config('app.name', 'Laravel') }}</h2>
                        </a>
                    </div>

                    <!-- Auth Card -->
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            {{ $slot }}
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="text-center mt-4">
                        <small class="text-muted">
                            Powered by <a href="https://github.com/Get-Tony/bs5-starter-kit"
                                          target="_blank"
                                          class="text-primary fw-semibold text-decoration-none">
                                          BS5 Starter Kit
                                       </a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
