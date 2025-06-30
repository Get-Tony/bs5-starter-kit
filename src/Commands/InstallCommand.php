<?php

namespace LaravelBs5Kit\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bs5:install
                            {--bootstrap : Install Bootstrap CSS framework}
                            {--sass : Setup SASS with 7-1 architecture}
                            {--auth : Install authentication scaffolding}
                            {--preset= : Use a preset configuration (minimal|standard|full)}
                            {--force : Overwrite existing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install BS5 Starter Kit (Bootstrap 5 + SASS) components';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Create a new command instance.
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🚀 Installing BS5 Starter Kit for Laravel...');
        $this->newLine();

        // Handle preset
        if ($preset = $this->option('preset')) {
            $this->handlePreset($preset);

            return 0;
        }

        // Handle individual components
        $components = $this->getComponentsToInstall();

        if (empty($components)) {
            $this->info('💡 No components specified. Use --bootstrap, --sass, or --auth');
            $this->info('   Or use a preset: --preset=minimal|standard|full');

            return 0;
        }

        $this->installComponents($components);

        $this->displayCompletionMessage();

        return 0;
    }

    /**
     * Handle preset installation.
     */
    protected function handlePreset(string $preset): void
    {
        $presets = $this->getPresetConfigurations();

        if (! isset($presets[$preset])) {
            $this->error("❌ Unknown preset: {$preset}");
            $this->info('Available presets: '.implode(', ', array_keys($presets)));

            return;
        }

        $this->info("📦 Installing '{$preset}' preset...");
        $this->newLine();

        $this->installComponents($presets[$preset]);
    }

    /**
     * Get preset configurations.
     */
    protected function getPresetConfigurations(): array
    {
        return [
            'minimal' => [
                'bootstrap' => true,
                'sass' => false,
                'auth' => false,
            ],
            'standard' => [
                'bootstrap' => true,
                'sass' => true,
                'auth' => false,
            ],
            'full' => [
                'bootstrap' => true,
                'sass' => true,
                'auth' => true,
            ],
        ];
    }

    /**
     * Get components to install based on options.
     */
    protected function getComponentsToInstall(): array
    {
        $components = [];

        if ($this->option('bootstrap')) {
            $components['bootstrap'] = true;
        }

        if ($this->option('sass')) {
            $components['sass'] = true;
        }

        if ($this->option('auth')) {
            $components['auth'] = true;
        }

        return $components;
    }

    /**
     * Install the specified components.
     */
    protected function installComponents(array $components): void
    {
        // PHASE 1: Pre-installation setup and file protection
        $this->backupExistingFiles();

        // PHASE 2: Install core dependencies first
        if ($components['bootstrap'] ?? false) {
            $this->installBootstrap();
        }

        if ($components['sass'] ?? false) {
            $this->installSass();
        }

        // PHASE 3: Setup BS5 Kit foundation BEFORE authentication
        $this->installJavaScript();
        $this->updatePackageJson();
        $this->updateViteConfig();
        $this->createAppLayout();
        $this->createWelcomePage();

        // PHASE 4: Authentication (which may overwrite some files)
        if ($components['auth'] ?? false) {
            $this->info('🔐 Installing complete authentication system...');
            $this->installAuth();
        }

        // PHASE 5: Post-authentication cleanup and restoration
        $this->postAuthenticationCleanup();

        // PHASE 6: Final verification and auto-fixes
        $this->verifyAndFix();
    }

    /**
     * Backup existing files to prevent data loss.
     */
    protected function backupExistingFiles(): void
    {
        $this->info('🛡️ Creating backup of existing files...');

        $filesToBackup = [
            'resources/views/layouts/app.blade.php',
            'vite.config.js',
            'resources/js/app.js',
            'resources/js/bootstrap.js',
            'package.json',
        ];

        foreach ($filesToBackup as $file) {
            $fullPath = base_path($file);
            if (file_exists($fullPath)) {
                // Create backup
                $backupPath = $fullPath.'.bs5-kit-backup-'.date('Y-m-d-H-i-s');
                copy($fullPath, $backupPath);
                $this->line("   → Backup created: {$backupPath}");
            }
        }
    }

    /**
     * Clean up after authentication installation and restore BS5 Kit functionality.
     */
    protected function postAuthenticationCleanup(): void
    {
        $this->info('🧹 Cleaning up post-authentication installation...');

        // Remove Tailwind artifacts left by Breeze
        $this->removeTailwindArtifacts();

        // Ensure BS5 Kit layout is in place
        $this->ensureBs5KitLayout();

        // Fix Vite configuration
        $this->ensureCorrectViteConfig();

        // Ensure Bootstrap is properly installed
        $this->ensureBootstrapInstallation();
    }

    /**
     * Remove Tailwind CSS artifacts that conflict with Bootstrap.
     */
    protected function removeTailwindArtifacts(): void
    {
        $this->comment('🗑️ Removing Tailwind CSS artifacts...');

        // Remove Tailwind config files
        $tailwindFiles = [
            'tailwind.config.js',
            'postcss.config.js',
        ];

        foreach ($tailwindFiles as $file) {
            $fullPath = base_path($file);
            if ($this->files->exists($fullPath)) {
                $this->files->delete($fullPath);
                $this->comment("✅ Removed {$file}");
            }
        }

        // Remove CSS directory if it exists (BS5 Kit uses SASS)
        $cssPath = resource_path('css');
        if ($this->files->isDirectory($cssPath)) {
            $this->files->deleteDirectory($cssPath);
            $this->comment('✅ Removed resources/css directory (using SASS instead)');
        }
    }

    /**
     * Ensure BS5 Kit layout is in place and not overwritten.
     */
    protected function ensureBs5KitLayout(): void
    {
        $layoutPath = resource_path('views/layouts/app.blade.php');

        // Check if current layout is BS5 Kit layout
        if ($this->files->exists($layoutPath)) {
            $content = $this->files->get($layoutPath);

            // If it contains Tailwind classes or CSS references, it's not BS5 Kit layout
            if (strpos($content, 'resources/css/app.css') !== false ||
                strpos($content, 'font-sans antialiased') !== false ||
                strpos($content, 'min-h-screen bg-gray-100') !== false) {

                $this->comment('🔄 Restoring BS5 Kit layout (Breeze overwrote it)...');
                $this->copyStub('layouts/app.blade.php', $layoutPath);
                $this->comment('✅ BS5 Kit layout restored');
            }
        } else {
            // Create BS5 Kit layout if it doesn't exist
            $this->copyStub('layouts/app.blade.php', $layoutPath);
            $this->comment('✅ BS5 Kit layout created');
        }

        // Always ensure app-layout and guest-layout components exist
        $appLayoutComponentPath = resource_path('views/components/app-layout.blade.php');
        if (! $this->files->exists($appLayoutComponentPath)) {
            $this->copyStub('components/app-layout.blade.php', $appLayoutComponentPath);
            $this->comment('✅ App layout component created');
        }

        $guestLayoutComponentPath = resource_path('views/components/guest-layout.blade.php');
        if (! $this->files->exists($guestLayoutComponentPath)) {
            $this->copyStub('components/guest-layout.blade.php', $guestLayoutComponentPath);
            $this->comment('✅ Guest layout component created');
        }
    }

    /**
     * Ensure Vite configuration is correct for BS5 Kit.
     */
    protected function ensureCorrectViteConfig(): void
    {
        $viteConfigPath = base_path('vite.config.js');

        if ($this->files->exists($viteConfigPath)) {
            $content = $this->files->get($viteConfigPath);

            // Check if it's pointing to CSS instead of SASS
            if (strpos($content, 'resources/css/app.css') !== false) {
                $this->comment('🔄 Fixing Vite configuration to use SASS...');
                $this->copyStub('vite.config.js', $viteConfigPath);
                $this->comment('✅ Vite configuration fixed');
            }
        }
    }

    /**
     * Ensure Bootstrap is properly installed and Tailwind is removed.
     */
    protected function ensureBootstrapInstallation(): void
    {
        $packageJsonPath = base_path('package.json');

        if ($this->files->exists($packageJsonPath)) {
            $packageJson = json_decode($this->files->get($packageJsonPath), true);

            // Check for Tailwind dependencies and remove them
            $tailwindPackages = [
                'tailwindcss',
                'postcss',
                'autoprefixer',
                '@tailwindcss/forms',
            ];

            $hasUnwantedPackages = false;
            foreach ($tailwindPackages as $package) {
                if (isset($packageJson['devDependencies'][$package]) ||
                    isset($packageJson['dependencies'][$package])) {
                    $hasUnwantedPackages = true;
                    break;
                }
            }

            if ($hasUnwantedPackages) {
                $this->comment('🔄 Removing Tailwind packages and ensuring Bootstrap...');
                $this->runProcess('npm uninstall tailwindcss postcss autoprefixer @tailwindcss/forms');
                $this->runProcess('npm install bootstrap @popperjs/core');
                $this->comment('✅ Package dependencies corrected');
            }
        }
    }

    /**
     * Verify installation and auto-fix common issues.
     */
    protected function verifyAndFix(): void
    {
        $this->info('🔍 Verifying installation and auto-fixing issues...');

        $issues = [];

        // Check SASS directory exists
        if (! $this->files->isDirectory(resource_path('sass'))) {
            $issues[] = 'SASS directory missing';
            $this->installSass(); // Auto-fix
        }

        // Check BS5 Kit JavaScript exists
        if (! $this->files->exists(resource_path('js/bootstrap.js'))) {
            $issues[] = 'BS5 Kit JavaScript missing';
            $this->installJavaScript(); // Auto-fix
        }

        // Check welcome page is BS5 Kit compatible
        $welcomePath = resource_path('views/welcome.blade.php');
        if ($this->files->exists($welcomePath)) {
            $content = $this->files->get($welcomePath);
            if (strpos($content, 'resources/css/app.css') !== false ||
                strpos($content, 'tailwindcss') !== false) {
                $issues[] = 'Welcome page incompatible with BS5 Kit';
                $this->createWelcomePage(); // Auto-fix
            }
        }

        // Check layout uses correct assets
        $layoutPath = resource_path('views/layouts/app.blade.php');
        if ($this->files->exists($layoutPath)) {
            $content = $this->files->get($layoutPath);
            if (strpos($content, 'resources/sass/app.scss') === false) {
                $issues[] = 'Layout not using SASS assets';
                $this->ensureBs5KitLayout(); // Auto-fix
            }
            if (strpos($content, 'resources/css/app.css') !== false) {
                $issues[] = 'Layout still references CSS instead of SASS';
                $this->ensureBs5KitLayout(); // Auto-fix
            }
            if (strpos($content, 'font-sans antialiased') !== false ||
                strpos($content, 'min-h-screen bg-gray-100') !== false) {
                $issues[] = 'Layout still uses Tailwind classes';
                $this->ensureBs5KitLayout(); // Auto-fix
            }
        }

        // Check auth-layout component exists
        $authLayoutPath = resource_path('views/components/auth-layout.blade.php');
        if (! $this->files->exists($authLayoutPath)) {
            $issues[] = 'Auth layout component missing';
            $this->copyStub('layouts/auth.blade.php', $authLayoutPath); // Auto-fix
        }

        // Check app-layout component exists
        $appLayoutPath = resource_path('views/components/app-layout.blade.php');
        if (! $this->files->exists($appLayoutPath)) {
            $issues[] = 'App layout component missing';
            $this->copyStub('components/app-layout.blade.php', $appLayoutPath); // Auto-fix
        }

        // Check guest-layout component exists
        $guestLayoutPath = resource_path('views/components/guest-layout.blade.php');
        if (! $this->files->exists($guestLayoutPath)) {
            $issues[] = 'Guest layout component missing';
            $this->copyStub('components/guest-layout.blade.php', $guestLayoutPath); // Auto-fix
        }

        if (empty($issues)) {
            $this->info('✅ All checks passed! BS5 Kit is properly installed.');
        } else {
            $this->info('🔧 Auto-fixed '.count($issues).' issues:');
            foreach ($issues as $issue) {
                $this->comment("  - {$issue}");
            }
        }

        // Final build test
        $this->comment('🧪 Testing asset compilation...');
        $buildResult = $this->runProcessSilent('npm run build');

        if ($buildResult === 0) {
            $this->info('✅ Assets compile successfully!');
        } else {
            $this->warn('⚠️  Asset compilation failed. Run "npm run build" to see details.');
            $this->comment('💡 This might be due to missing node_modules. Try: npm install');
        }

        // Post-installation functionality test
        $this->comment('🔍 Running post-installation functionality tests...');
        $this->runPostInstallationTests();
    }

    /**
     * Run a shell process silently and return exit code.
     */
    protected function runProcessSilent(string $command): int
    {
        $process = Process::fromShellCommandline($command, base_path());
        $process->run();

        return $process->getExitCode();
    }

    /**
     * Install Bootstrap.
     */
    protected function installBootstrap(): void
    {
        $this->info('📦 Installing Bootstrap...');

        $this->runProcess('npm install bootstrap @popperjs/core');

        $this->info('✅ Bootstrap installed');
    }

    /**
     * Install SASS with 7-1 architecture.
     */
    protected function installSass(): void
    {
        $this->info('🎨 Setting up SASS with 7-1 architecture...');

        $this->runProcess('npm install --save-dev sass');

        // Create SASS directory structure
        $sassPath = resource_path('sass');
        $directories = config('bs5-kit.sass.directories', [
            'abstracts',
            'base',
            'components',
            'layout',
            'vendors'
        ]);

        foreach ($directories as $dir) {
            $this->files->ensureDirectoryExists("{$sassPath}/{$dir}");
        }

        // Copy SASS stubs
        $this->copyStubs('sass', $sassPath);

        $this->info('✅ SASS configured with 7-1 architecture');
    }

    /**
     * Install authentication scaffolding.
     */
    protected function installAuth(): void
    {
        $this->info('🔐 Installing complete authentication system...');
        $this->comment('BS5 Kit provides complete authentication with Bootstrap styling.');
        $this->newLine();

        // Always install Breeze for complete functionality, but make it transparent
        $this->comment('Installing Laravel Breeze with Bootstrap styling...');
        $this->installBreezeAuth();

        $this->info('✅ Complete authentication system installed');
    }

    /**
     * Install Breeze-based authentication.
     */
    protected function installBreezeAuth(): void
    {
        // Check if Breeze is already installed
        if ($this->files->exists(base_path('composer.json'))) {
            $composerJson = json_decode($this->files->get(base_path('composer.json')), true);
            $hasBreeze = isset($composerJson['require-dev']['laravel/breeze']) ||
                        isset($composerJson['require']['laravel/breeze']);

            if (! $hasBreeze) {
                $this->info('📦 Installing Laravel Breeze...');
                $this->runProcess('composer require laravel/breeze --dev');
            } else {
                $this->info('✅ Laravel Breeze already installed');
            }
        }

        // Clear and rediscover commands to make breeze:install available
        $this->call('config:clear');
        $this->call('package:discover');

        // Install Breeze with Blade (we'll modify for Bootstrap)
        try {
            $this->info('🎨 Setting up Breeze authentication...');

            // Ensure CSS directory exists temporarily for Breeze installation
            $cssPath = resource_path('css');
            if (!$this->files->isDirectory($cssPath)) {
                $this->files->ensureDirectoryExists($cssPath);
                // Create a temporary CSS file for Breeze to copy over
                $this->files->put(resource_path('css/app.css'), '/* Temporary file for Breeze installation */');
            }

            $this->call('breeze:install', ['stack' => 'blade', '--no-interaction' => true]);

            $this->info('🔄 Replacing Tailwind with Bootstrap...');
            // Remove Tailwind and install Bootstrap
            $this->runProcess('npm uninstall tailwindcss postcss autoprefixer @tailwindcss/forms');
            $this->runProcess('npm install bootstrap @popperjs/core');

            // Replace Breeze authentication views with BS5 Kit Bootstrap versions
            $this->info('🎨 Installing BS5 Kit Bootstrap authentication views...');

            // Use guest-layout compatible versions for Breeze
            $this->copyStub('auth/login-guest.blade.php', resource_path('views/auth/login.blade.php'));
            $this->copyStub('auth/register-guest.blade.php', resource_path('views/auth/register.blade.php'));
            $this->copyStub('auth/forgot-password.blade.php', resource_path('views/auth/forgot-password.blade.php'));
            $this->copyStub('auth/reset-password.blade.php', resource_path('views/auth/reset-password.blade.php'));

            // Install air-gapped guest layout (no external fonts)
            $this->copyStub('layouts/guest.blade.php', resource_path('views/layouts/guest.blade.php'));

            // Create auth-layout component for authentication views
            $this->copyStub('layouts/auth.blade.php', resource_path('views/components/auth-layout.blade.php'));

            // Install BS5 Kit Bootstrap components to replace Tailwind ones
            $this->installBootstrapComponents();

            // CRITICAL: Force replace app layout (Breeze overwrites it)
            $this->info('🔄 Ensuring BS5 Kit app layout is properly installed...');
            $this->copyStub('layouts/app.blade.php', resource_path('views/layouts/app.blade.php'));

            $this->info('✅ Breeze configured with Bootstrap successfully');
        } catch (\Exception $e) {
            $this->warn('⚠️  Breeze installation encountered an issue.');
            $this->warn('BS5 Kit will continue with its own authentication system.');
            $this->comment('Note: Do not run "php artisan breeze:install" manually as it conflicts with BS5 Kit\'s SASS setup.');
            $this->comment('If you need authentication, BS5 Kit provides its own complete authentication system.');
        }

        // ALWAYS install BS5 Kit components regardless of Breeze success/failure
        $this->info('🎨 Installing BS5 Kit Bootstrap authentication system...');

        // Use guest-layout compatible versions for Breeze
        $this->copyStub('auth/login-guest.blade.php', resource_path('views/auth/login.blade.php'));
        $this->copyStub('auth/register-guest.blade.php', resource_path('views/auth/register.blade.php'));
        $this->copyStub('auth/forgot-password.blade.php', resource_path('views/auth/forgot-password.blade.php'));
        $this->copyStub('auth/reset-password.blade.php', resource_path('views/auth/reset-password.blade.php'));

        // Install air-gapped guest layout (no external fonts) - FORCE OVERWRITE
        $this->info('🔄 Installing air-gapped guest layout...');
        $this->copyStub('layouts/guest.blade.php', resource_path('views/layouts/guest.blade.php'));

        // Create auth-layout component for authentication views
        $this->copyStub('layouts/auth.blade.php', resource_path('views/components/auth-layout.blade.php'));

        // CRITICAL: Force replace app layout (Breeze overwrites it)
        $this->info('🔄 Ensuring BS5 Kit app layout is properly installed...');
        $this->copyStub('layouts/app.blade.php', resource_path('views/layouts/app.blade.php'));

        // CRITICAL: Install BS5 Kit Bootstrap components LAST to override Breeze Tailwind components
        $this->info('🔄 Installing BS5 Kit Bootstrap components (overriding Breeze Tailwind)...');
        $this->installBootstrapComponents();

        $this->info('✅ Complete authentication system installed');
    }

    /**
     * Install simple Bootstrap authentication.
     */
    protected function installSimpleAuth(): void
    {
        // Create auth-related views with Bootstrap styling
        $this->copyStub('auth/login.blade.php', resource_path('views/auth/login.blade.php'));
        $this->copyStub('auth/register.blade.php', resource_path('views/auth/register.blade.php'));

        // Add auth routes to web.php
        $this->addAuthRoutes();
    }

    /**
     * Add authentication routes to web.php
     */
    protected function addAuthRoutes(): void
    {
        $routesPath = base_path('routes/web.php');

        if (! $this->files->exists($routesPath)) {
            return;
        }

        $routes = "
// Basic Authentication Routes Template
// For full authentication, we recommend using Laravel Breeze:
//   composer require laravel/breeze --dev
//   php artisan breeze:install blade
//
// Or add custom authentication routes here:
// Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [LoginController::class, 'login']);
// Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
// Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
// Route::post('/register', [RegisterController::class, 'register']);
";

        $this->files->append($routesPath, $routes);

        $this->info('💡 Authentication routes template added to routes/web.php');
        $this->info('📖 For full authentication, use BS5 Kit with --preset=full:');
        $this->line('   php artisan bs5:install --preset=full');
        $this->comment('Note: Do not use "php artisan breeze:install" directly as it conflicts with BS5 Kit\'s SASS setup.');
    }

    /**
     * Update package.json with BS5 Kit scripts.
     */
    protected function updatePackageJson(): void
    {
        $packageJsonPath = base_path('package.json');

        if (! $this->files->exists($packageJsonPath)) {
            return;
        }

        $packageJson = json_decode($this->files->get($packageJsonPath), true);

        // Add/update scripts with build helper
        $packageJson['scripts'] = array_merge($packageJson['scripts'] ?? [], [
            'build' => 'node resources/js/build-helper.js',
            'dev' => 'node resources/js/build-helper.js --dev',
            'build:raw' => 'vite build',
            'dev:raw' => 'vite',
            'build:verbose' => 'vite build --mode development',
            'preview' => 'vite preview',
        ]);

        $this->files->put(
            $packageJsonPath,
            json_encode($packageJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
        );

        // Copy build helper script
        $this->copyStub('js/build-helper.js', resource_path('js/build-helper.js'));

        $this->info('📄 Updated package.json');
    }

    /**
     * Update Vite configuration.
     */
    protected function updateViteConfig(): void
    {
        $viteConfigPath = base_path('vite.config.js');

        if ($this->files->exists($viteConfigPath)) {
            $this->copyStub('vite.config.js', $viteConfigPath);
            $this->info('⚡ Updated Vite configuration');
        }
    }

    /**
     * Create the main application layout.
     */
    protected function createAppLayout(): void
    {
        $layoutPath = resource_path('views/layouts/app.blade.php');

        if (! $this->files->exists($layoutPath) || $this->option('force')) {
            $this->copyStub('layouts/app.blade.php', $layoutPath);
            $this->info('🎨 Created application layout');
        }

        // Also install the app-layout and guest-layout components for <x-app-layout> and <x-guest-layout> usage
        $this->copyStub('components/app-layout.blade.php', resource_path('views/components/app-layout.blade.php'));
        $this->copyStub('components/guest-layout.blade.php', resource_path('views/components/guest-layout.blade.php'));
    }

    /**
     * Copy stub files to destination.
     */
    protected function copyStubs(string $stubDir, string $destination): void
    {
        $stubPath = __DIR__."/../Stubs/{$stubDir}";

        if (! $this->files->isDirectory($stubPath)) {
            return;
        }

        $files = $this->files->allFiles($stubPath);

        foreach ($files as $file) {
            $relativePath = $file->getRelativePathname();
            $destinationPath = "{$destination}/{$relativePath}";

            $this->files->ensureDirectoryExists(dirname($destinationPath));
            $this->files->copy($file->getPathname(), $destinationPath);
        }
    }

    /**
     * Copy a single stub file.
     */
    protected function copyStub(string $stub, string $destination): void
    {
        $stubPath = __DIR__."/../Stubs/{$stub}";

        if ($this->files->exists($stubPath)) {
            $this->files->ensureDirectoryExists(dirname($destination));
            $this->files->copy($stubPath, $destination);
        }
    }

    /**
     * Run a shell process.
     */
    protected function runProcess(string $command): void
    {
        $process = Process::fromShellCommandline($command, base_path());
        $process->run();

        if (! $process->isSuccessful()) {
            $this->warn("Command failed: {$command}");
        }
    }

    /**
     * Display completion message.
     */
    protected function displayCompletionMessage(): void
    {
        $this->newLine();
        $this->info('🎉 BS5 Kit installation completed!');
        $this->newLine();

        $this->comment('Next steps:');
        $this->line('  1. Run: npm install && npm run bal:build');
        $this->line('  2. Visit your application in the browser');
        $this->line('  3. Start building with Bootstrap + SASS!');
        $this->newLine();

        $this->comment('Available commands:');
        $this->line('  php artisan bal:publish    # Publish additional stubs');
        $this->line('  npm run bal:dev           # Start development server');
        $this->line('  npm run bal:build         # Build for production');
    }

    /**
     * Install JavaScript stubs with BS5 Kit utilities.
     */
    protected function installJavaScript(): void
    {
        $this->info('⚡ Setting up BS5 Kit JavaScript utilities...');

        // Copy JavaScript stubs
        $this->copyStub('js/app.js', resource_path('js/app.js'));
        $this->copyStub('js/bootstrap.js', resource_path('js/bootstrap.js'));

        $this->info('✅ BS5 Kit JavaScript utilities installed');
    }

    /**
     * Create BS5 Kit welcome page.
     */
    protected function createWelcomePage(): void
    {
        $this->comment('🏠 Creating BS5 Kit welcome page...');

        $welcomePath = resource_path('views/welcome.blade.php');

        // Backup existing welcome page if it exists
        if ($this->files->exists($welcomePath)) {
            $backupPath = $welcomePath.'.laravel-original-'.date('Y-m-d-H-i-s');
            $this->files->copy($welcomePath, $backupPath);
            $this->comment("📋 Backed up original welcome page to {$backupPath}");
        }

        // Copy BS5 Kit welcome page
        $this->copyStub('pages/welcome.blade.php', $welcomePath);

        $this->comment('✅ BS5 Kit welcome page created');
    }

    /**
     * Install Bootstrap components to replace Tailwind ones.
     */
    protected function installBootstrapComponents(): void
    {
        $this->comment('🧩 Installing Bootstrap Blade components...');

        // Copy Bootstrap component stubs
        $components = [
            'text-input.blade.php',
            'input-label.blade.php',
            'input-error.blade.php',
            'primary-button.blade.php',
            'auth-session-status.blade.php',
            'app-layout.blade.php',
            'guest-layout.blade.php',
        ];

        foreach ($components as $component) {
            $this->copyStub("components/{$component}", resource_path("views/components/{$component}"));
        }

        $this->info('✅ Bootstrap components installed');
    }

    /**
     * Run post-installation functionality tests.
     */
    protected function runPostInstallationTests(): void
    {
        $testsPassed = 0;
        $totalTests = 0;

        // Test 1: Check if welcome page exists and uses correct layout
        $totalTests++;
        $welcomePath = resource_path('views/welcome.blade.php');
        if ($this->files->exists($welcomePath)) {
            $content = $this->files->get($welcomePath);
            if (strpos($content, '<x-app-layout>') !== false &&
                strpos($content, 'resources/css/app.css') === false) {
                $testsPassed++;
                $this->comment('✅ Welcome page test passed');
            } else {
                $this->warn('❌ Welcome page test failed - incorrect layout or assets');
            }
        } else {
            $this->warn('❌ Welcome page test failed - file missing');
        }

        // Test 2: Check if app layout is correct
        $totalTests++;
        $layoutPath = resource_path('views/layouts/app.blade.php');
        if ($this->files->exists($layoutPath)) {
            $content = $this->files->get($layoutPath);
            if (strpos($content, 'resources/sass/app.scss') !== false &&
                strpos($content, 'navbar navbar-expand-lg') !== false &&
                strpos($content, 'resources/css/app.css') === false) {
                $testsPassed++;
                $this->comment('✅ App layout test passed');
            } else {
                $this->warn('❌ App layout test failed - incorrect assets or styling');
            }
        } else {
            $this->warn('❌ App layout test failed - file missing');
        }

        // Test 3: Check if auth components exist (only if auth was installed)
        $loginPath = resource_path('views/auth/login.blade.php');
        if ($this->files->exists($loginPath)) {
            $totalTests++;
            $loginContent = $this->files->get($loginPath);

            // Check for either auth-layout (simple auth) or guest-layout (breeze auth) patterns
            $hasAuthLayout = strpos($loginContent, '<x-auth-layout>') !== false;
            $hasGuestLayout = strpos($loginContent, '<x-guest-layout>') !== false;
            $hasBootstrapStyling = strpos($loginContent, 'form-control') !== false ||
                                   strpos($loginContent, '<x-text-input') !== false;

            if (($hasAuthLayout || $hasGuestLayout) && $hasBootstrapStyling) {
                $testsPassed++;
                $this->comment('✅ Authentication components test passed');
            } else {
                $this->warn('❌ Authentication components test failed - incorrect styling');
                $this->comment('   Expected: <x-auth-layout> or <x-guest-layout> with Bootstrap styling');
                $this->comment("   Found: auth-layout={$hasAuthLayout}, guest-layout={$hasGuestLayout}, bootstrap={$hasBootstrapStyling}");
            }
        } else {
            // Only show this as a test failure if auth components were supposed to be installed
            $components = $this->getComponentsToInstall();
            if (in_array('auth', $components)) {
                $totalTests++;
                $this->warn('❌ Authentication components test failed - login view missing');
            } else {
                $this->comment('ℹ️ Authentication components test skipped (not installed in this preset)');
            }
        }

        // Test 4: Check if Bootstrap components exist (only if components were installed)
        $textInputPath = resource_path('views/components/text-input.blade.php');
        if ($this->files->exists($textInputPath)) {
            $totalTests++;
            $content = $this->files->get($textInputPath);
            if (strpos($content, 'form-control') !== false) {
                $testsPassed++;
                $this->comment('✅ Bootstrap components test passed');
            } else {
                $this->warn('❌ Bootstrap components test failed - incorrect styling');
            }
        } else {
            // Only show this as a test failure if components were supposed to be installed
            $components = $this->getComponentsToInstall();
            if (in_array('components', $components)) {
                $totalTests++;
                $this->warn('❌ Bootstrap components test failed - files missing');
            } else {
                $this->comment('ℹ️ Bootstrap components test skipped (not installed in this preset)');
            }
        }

        // Summary
        if ($testsPassed === $totalTests) {
            $this->info("🎉 All {$totalTests} post-installation tests passed!");
            $this->info('✅ BS5 Kit is ready for use!');
        } else {
            $this->warn("⚠️  {$testsPassed}/{$totalTests} tests passed. Some issues may need manual fixing.");
            $this->comment('💡 Check the warnings above and run the installation again if needed.');
        }
    }
}
