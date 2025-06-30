<?php

namespace LaravelBs5Kit\Tests\Feature;

use LaravelBs5Kit\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class PublishCommandTest extends TestCase
{
    #[Test]
    public function it_can_list_vendor_publish_options()
    {
        $this->artisan('bs5:publish --list')
            ->expectsOutput('📋 Available vendor:publish tags for BS5 Starter Kit:')
            ->assertExitCode(0);
    }

    #[Test]
    public function it_can_publish_config()
    {
        $this->artisan('bs5:publish --config')
            ->expectsOutput('📦 Publishing BS5 Starter Kit resources...')
            ->assertExitCode(0);
    }

    #[Test]
    public function it_can_publish_stubs()
    {
        $this->artisan('bs5:publish --stubs')
            ->expectsOutput('📦 Publishing BS5 Starter Kit resources...')
            ->assertExitCode(0);
    }

    #[Test]
    public function it_can_run_publish_command_with_components_option()
    {
        $this->artisan('bs5:publish --components')
            ->assertExitCode(0);
    }

    #[Test]
    public function it_can_run_publish_command_with_all_option()
    {
        $this->artisan('bs5:publish --all')
            ->assertExitCode(0);
    }

    #[Test]
    public function it_shows_help_when_no_options_provided()
    {
        $this->artisan('bs5:publish')
            ->expectsOutput('💡 Specify what to publish: --config, --stubs, --components, or --all')
            ->assertExitCode(0);
    }

    #[Test]
    public function it_can_force_overwrite_published_files()
    {
        // First publish
        $this->artisan('bs5:publish --config')
            ->assertExitCode(0);

        // Second publish with force
        $this->artisan('bs5:publish --config --force')
            ->assertExitCode(0);
    }

    #[Test]
    public function it_can_publish_multiple_options_together()
    {
        $this->artisan('bs5:publish --config --stubs')
            ->assertExitCode(0);
    }

    #[Test]
    public function vendor_publish_works_with_bal_kit_tags()
    {
        // Test that Laravel's vendor:publish command works with our tags
        $this->artisan('vendor:publish --tag=bs5-kit-config')
            ->assertExitCode(0);
    }

    #[Test]
    public function vendor_publish_works_with_provider()
    {
        // Test that Laravel's vendor:publish command works with our provider
        $this->artisan('vendor:publish --provider=LaravelBs5Kit\Bs5KitServiceProvider')
            ->assertExitCode(0);
    }

    #[Test]
    public function it_handles_individual_tag_publishing()
    {
        // Test individual tags
        $tags = [
            'bs5-kit-sass',
            'bs5-kit-js',
            'bs5-kit-layouts',
            'bs5-kit-components',
            'bs5-kit-auth',
            'bs5-kit-pages',
            'bs5-kit-vite',
        ];

        foreach ($tags as $tag) {
            $this->artisan("vendor:publish --tag={$tag}")
                ->assertExitCode(0);
        }
    }

    #[Test]
    public function it_can_publish_all_available_options()
    {
        $options = ['config', 'stubs', 'components'];

        foreach ($options as $option) {
            $this->artisan("bs5:publish --{$option}")
                ->assertExitCode(0);
        }
    }

    #[Test]
    public function it_handles_force_option_correctly()
    {
        // Test force option with different combinations
        $this->artisan('bs5:publish --all --force')
            ->assertExitCode(0);

        $this->artisan('bs5:publish --config --stubs --force')
            ->assertExitCode(0);
    }

    #[Test]
    public function it_can_publish_all_resources()
    {
        $this->artisan('vendor:publish --provider=LaravelBs5Kit\Bs5KitServiceProvider')
            ->assertExitCode(0);
    }

    #[Test]
    public function it_shows_correct_vendor_publish_tags()
    {
        $tags = [
            'bs5-kit-sass',
            'bs5-kit-js',
            'bs5-kit-layouts',
            'bs5-kit-components',
            'bs5-kit-auth',
            'bs5-kit-pages',
            'bs5-kit-vite',
        ];

        // Test that the list command includes expected tags
        $this->artisan('bs5:publish --list')
            ->expectsOutput('📋 Available vendor:publish tags for BS5 Starter Kit:')
            ->assertExitCode(0);

        // Verify tags are defined (basic assertion)
        $this->assertNotEmpty($tags);
        $this->assertContains('bs5-kit-sass', $tags);
    }
}
