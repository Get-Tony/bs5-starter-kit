<?php

namespace LaravelBs5Kit\Tests\Unit;

use LaravelBs5Kit\Tests\TestCase;
use LaravelBs5Kit\Bs5KitServiceProvider;
use LaravelBs5Kit\Commands\InstallCommand;
use LaravelBs5Kit\Commands\PublishCommand;
use PHPUnit\Framework\Attributes\Test;

class ServiceProviderTest extends TestCase
{
    #[Test]
    public function it_registers_the_service_provider()
    {
        $this->assertTrue($this->app->getProvider(Bs5KitServiceProvider::class) instanceof Bs5KitServiceProvider);
    }

    #[Test]
    public function it_registers_install_command()
    {
        $this->assertTrue($this->app->make(InstallCommand::class) instanceof InstallCommand);
    }

    #[Test]
    public function it_registers_publish_command()
    {
        $this->assertTrue($this->app->make(PublishCommand::class) instanceof PublishCommand);
    }

    #[Test]
    public function it_merges_configuration()
    {
        $this->assertIsArray(config('bs5-kit'));
        $this->assertArrayHasKey('bootstrap', config('bs5-kit.install'));
    }

    #[Test]
    public function it_has_correct_preset_configurations()
    {
        $config = $this->app['config']->get('bs5-kit.presets');

        $this->assertIsArray($config);
        $this->assertArrayHasKey('minimal', $config);
        $this->assertArrayHasKey('standard', $config);
        $this->assertArrayHasKey('full', $config);
    }

    #[Test]
    public function it_registers_service_provider()
    {
        // Test that the service provider is loaded
        $providers = $this->app->getLoadedProviders();
        $this->assertArrayHasKey('LaravelBs5Kit\Bs5KitServiceProvider', $providers);
    }

    #[Test]
    public function it_uses_correct_namespace()
    {
        $reflection = new \ReflectionClass('LaravelBs5Kit\Bs5KitServiceProvider');
        $this->assertEquals('LaravelBs5Kit', $reflection->getNamespaceName());
    }

    #[Test]
    public function it_can_resolve_commands_from_container()
    {
        // Test that we can resolve the command classes
        $installCommand = $this->app->make(InstallCommand::class);
        $publishCommand = $this->app->make(PublishCommand::class);

        $this->assertInstanceOf(InstallCommand::class, $installCommand);
        $this->assertInstanceOf(PublishCommand::class, $publishCommand);
    }
}
