<?php

namespace LaravelBs5Kit\Tests;

use LaravelBs5Kit\Bs5KitServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        // Additional setup if needed
    }

    /**
     * Get package providers.
     */
    protected function getPackageProviders($app): array
    {
        return [
            Bs5KitServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     */
    protected function getEnvironmentSetUp($app): void
    {
        // Setup test environment configuration
        config()->set('database.default', 'testing');

        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        // Setup application key for encryption
        $app['config']->set('app.key', 'base64:2fl+Ktvkfl+Fuz4Qp/A75G2RTiWVA/ZoKZvp6fiiM10=');

        // Setup view paths
        $app['config']->set('view.paths', [
            __DIR__.'/../src/Stubs/layouts',
            __DIR__.'/../src/Stubs/auth',
            __DIR__.'/../src/Stubs/pages',
            resource_path('views'),
        ]);
    }

    /**
     * Define package aliases.
     */
    protected function getPackageAliases($app): array
    {
        return [
            // Add any package aliases here
        ];
    }

    /**
     * Helper method to create a temporary Laravel app for testing installations.
     */
    protected function createTempApp(): string
    {
        $tempDir = sys_get_temp_dir().'/bs5-kit-test-'.uniqid();
        mkdir($tempDir, 0755, true);

        // Create basic Laravel structure
        mkdir($tempDir.'/app', 0755, true);
        mkdir($tempDir.'/config', 0755, true);
        mkdir($tempDir.'/resources/views', 0755, true);
        mkdir($tempDir.'/resources/sass', 0755, true);
        mkdir($tempDir.'/resources/js', 0755, true);
        mkdir($tempDir.'/public', 0755, true);

        return $tempDir;
    }

    /**
     * Clean up temporary directories.
     */
    protected function cleanupTempApp(string $path): void
    {
        if (is_dir($path)) {
            $this->deleteDirectory($path);
        }
    }

    /**
     * Recursively delete a directory.
     */
    private function deleteDirectory(string $dir): void
    {
        if (! is_dir($dir)) {
            return;
        }

        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            $path = $dir.'/'.$file;
            is_dir($path) ? $this->deleteDirectory($path) : unlink($path);
        }
        rmdir($dir);
    }
}
