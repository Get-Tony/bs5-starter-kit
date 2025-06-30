<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="bs5-kit bg-light">
    <div class="min-vh-100 d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="text-center mb-4">
                        <h1 class="h3 text-primary">{{ config('app.name', 'Laravel') }}</h1>
                    </div>

                    <div class="card shadow">
                        <div class="card-body">
                            {{ $slot }}
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <small class="text-muted">
                            Powered by
                            <a href="https://github.com/Get-Tony/bs5-starter-kit"
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

    <!-- Toast container -->
    <div id="toast-container" class="toast-container position-fixed top-0 end-0 p-3"></div>
</body>
</html>
