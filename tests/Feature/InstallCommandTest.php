<?php

namespace LaravelBs5Kit\Tests\Feature;

use LaravelBs5Kit\Tests\TestCase;
use Illuminate\Support\Facades\File;
use PHPUnit\Framework\Attributes\Test;

class InstallCommandTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Clean up any existing files
        $this->cleanupTestFiles();
    }

    protected function tearDown(): void
    {
        $this->cleanupTestFiles();
        parent::tearDown();
    }

    #[Test]
    public function it_can_install_minimal_preset()
    {
        $this->artisan('bs5:install --preset=minimal')
            ->expectsOutput('🚀 Installing BS5 Starter Kit for Laravel...')
            ->assertExitCode(0);
    }

    #[Test]
    public function it_can_install_standard_preset()
    {
        $this->artisan('bs5:install --preset=standard')
            ->expectsOutput('🚀 Installing BS5 Starter Kit for Laravel...')
            ->assertExitCode(0);
    }

    #[Test]
    public function it_can_install_individual_components()
    {
        $this->artisan('bs5:install --bootstrap')
            ->expectsOutput('🚀 Installing BS5 Starter Kit for Laravel...')
            ->assertExitCode(0);
    }

    #[Test]
    public function it_shows_help_when_no_options_provided()
    {
        $this->artisan('bs5:install')
            ->expectsOutput('💡 No components specified. Use --bootstrap, --sass, or --auth')
            ->assertExitCode(0);
    }

    protected function cleanupTestFiles(): void
    {
        // Clean up test files if they exist
        $files = [
            resource_path('js/app.js'),
            resource_path('sass/app.scss'),
            resource_path('views/welcome.blade.php'),
        ];

        foreach ($files as $file) {
            if (File::exists($file)) {
                File::delete($file);
            }
        }
    }
}
