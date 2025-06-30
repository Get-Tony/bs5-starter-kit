<x-app-layout>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Welcome Hero -->
                <div class="text-center mb-5">
                    <h1 class="display-4 fw-bold text-primary mb-3">
                        Welcome to BS5 Starter Kit!
                    </h1>
                    <p class="lead text-muted">
                        Your pure Bootstrap 5 application is ready to build.
                    </p>
                </div>

                <!-- Feature Cards -->
                <div class="row g-4 mb-5">
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <div class="text-primary mb-3">
                                    <svg width="48" height="48" fill="currentColor" class="mx-auto d-block" viewBox="0 0 16 16">
                                        <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z"/>
                                    </svg>
                                </div>
                                <h5 class="card-title">Bootstrap 5</h5>
                                <p class="card-text text-muted">
                                    Latest Bootstrap 5.3+ with all components, utilities, and responsive design system.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <div class="text-success mb-3">
                                    <svg width="48" height="48" fill="currentColor" class="mx-auto d-block" viewBox="0 0 16 16">
                                        <path d="M4.158 12.025a.5.5 0 0 1-.316-.07L.14 9.284a.5.5 0 0 1 .632-.791l3.1 2.48 7.26-8.441a.5.5 0 0 1 .758.653L4.474 11.96a.5.5 0 0 1-.316.065z"/>
                                    </svg>
                                </div>
                                <h5 class="card-title">SASS Architecture</h5>
                                <p class="card-text text-muted">
                                    Professional 7-1 SASS architecture for scalable and maintainable stylesheets.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Demo Section -->
                <div class="card mb-5">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Interactive Demo</h3>
                    </div>
                    <div class="card-body">
                        <p class="card-text mb-4">
                            Test the built-in JavaScript utilities and Bootstrap components:
                        </p>

                        <div class="d-flex gap-2 flex-wrap">
                            <button class="btn btn-primary" onclick="BS5Kit.toast('Welcome to BS5 Starter Kit!', 'success')">
                                Success Toast
                            </button>

                            <button class="btn btn-outline-warning" onclick="BS5Kit.toast('This is a warning message!', 'warning')">
                                Warning Toast
                            </button>

                            <button class="btn btn-outline-danger" onclick="showConfirmDialog()">
                                Confirm Dialog
                            </button>

                            <button class="btn btn-outline-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Bootstrap tooltips work perfectly!">
                                Hover for Tooltip
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Quick Start Guide -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Quick Start</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>🚀 Get Started</h5>
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <code>composer require get-tony/bs5-starter-kit</code>
                                    </li>
                                    <li class="mb-2">
                                        <code>php artisan bs5:install --preset=full</code>
                                    </li>
                                    <li class="mb-2">
                                        <code>npm install && npm run build</code>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h5>📚 Documentation</h5>
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <a href="https://getbootstrap.com/docs/5.3/" class="text-decoration-none" target="_blank">
                                            Bootstrap 5 Documentation
                                        </a>
                                    </li>
                                    <li class="mb-2">
                                        <a href="https://sass-lang.com/" class="text-decoration-none" target="_blank">
                                            SASS Documentation
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        async function showConfirmDialog() {
            const confirmed = await BS5Kit.confirm('Ready to start building with Bootstrap 5?', 'BS5 Starter Kit');
            if (confirmed) {
                BS5Kit.toast('Perfect! Let\'s build something amazing!', 'info');
            } else {
                BS5Kit.toast('No problem, take your time exploring!', 'warning');
            }
        }
    </script>
</x-app-layout>
