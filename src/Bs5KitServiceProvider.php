<?php

namespace LaravelBs5Kit;

use Illuminate\Support\ServiceProvider;
use LaravelBs5Kit\Commands\InstallCommand;
use LaravelBs5Kit\Commands\PublishCommand;

/**
 * BS5 Starter Kit Service Provider
 *
 * Bootstrap 5 starter kit for Laravel
 * Provides installation commands and resource publishing
 *
 * @version {@see Version::VERSION}
 */
class Bs5KitServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Merge package configuration with application config
        $this->mergeConfigFrom(
            __DIR__.'/../config/bs5-kit.php', 'bs5-kit'
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->registerCommands();
            $this->registerPublishables();
        }
    }

    /**
     * Register Artisan commands.
     */
    protected function registerCommands(): void
    {
        $this->commands([
            InstallCommand::class,
            PublishCommand::class,
        ]);
    }

    /**
     * Register publishable resources.
     */
    protected function registerPublishables(): void
    {
        // Publish configuration
        $this->publishes([
            __DIR__.'/../config/bs5-kit.php' => config_path('bs5-kit.php'),
        ], 'bs5-kit-config');

        // Publish SASS files
        $this->publishes([
            __DIR__.'/Stubs/sass' => resource_path('sass'),
        ], 'bs5-kit-sass');

        // Publish JavaScript files
        $this->publishes([
            __DIR__.'/Stubs/js' => resource_path('js'),
        ], 'bs5-kit-js');

        // Publish layout templates
        $this->publishes([
            __DIR__.'/Stubs/layouts' => resource_path('views/layouts'),
        ], 'bs5-kit-layouts');

        // Publish component templates
        $this->publishes([
            __DIR__.'/Stubs/components' => resource_path('views/components'),
        ], 'bs5-kit-components');

        // Publish authentication views
        $this->publishes([
            __DIR__.'/Stubs/auth' => resource_path('views/auth'),
        ], 'bs5-kit-auth');

        // Publish example pages
        $this->publishes([
            __DIR__.'/Stubs/pages' => resource_path('views'),
        ], 'bs5-kit-pages');

        // Publish Vite configuration
        $this->publishes([
            __DIR__.'/Stubs/vite.config.js' => base_path('vite.config.js'),
        ], 'bs5-kit-vite');

        // Publish stub files for development
        $this->publishes([
            __DIR__.'/Stubs' => base_path('stubs/bs5-kit'),
        ], 'bs5-kit-stubs');

        // Publish everything
        $this->publishes([
            __DIR__.'/../config/bs5-kit.php' => config_path('bs5-kit.php'),
            __DIR__.'/Stubs' => base_path('stubs/bs5-kit'),
        ], 'bs5-kit');
    }
}
