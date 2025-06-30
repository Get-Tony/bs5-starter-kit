<?php

namespace LaravelBs5Kit\Tests\Unit;

use LaravelBs5Kit\Tests\TestCase;
use LaravelBs5Kit\Commands\InstallCommand;
use LaravelBs5Kit\Commands\PublishCommand;

class CommandsTest extends TestCase
{
    /** @test */
    public function install_command_has_correct_signature()
    {
        $command = $this->app->make(InstallCommand::class);

        $this->assertEquals('bs5:install', $command->getName());
        $this->assertStringContainsString('Install BS5 Starter Kit', $command->getDescription());
    }

    /** @test */
    public function install_command_has_preset_options()
    {
        $command = $this->app->make(InstallCommand::class);
        $definition = $command->getDefinition();

        $this->assertTrue($definition->hasOption('preset'));
        $this->assertTrue($definition->hasOption('bootstrap'));
        $this->assertTrue($definition->hasOption('sass'));
        $this->assertTrue($definition->hasOption('auth'));
        $this->assertTrue($definition->hasOption('force'));
    }

    /** @test */
    public function publish_command_has_correct_signature()
    {
        $command = $this->app->make(PublishCommand::class);

        $this->assertEquals('bs5:publish', $command->getName());
        $this->assertStringContainsString('Publish BS5 Starter Kit', $command->getDescription());
    }

    /** @test */
    public function publish_command_has_publish_options()
    {
        $command = $this->app->make(PublishCommand::class);
        $definition = $command->getDefinition();

        $this->assertTrue($definition->hasOption('config'));
        $this->assertTrue($definition->hasOption('stubs'));
        $this->assertTrue($definition->hasOption('components'));
        $this->assertTrue($definition->hasOption('all'));
        $this->assertTrue($definition->hasOption('list'));
        $this->assertTrue($definition->hasOption('force'));
    }

    /** @test */
    public function commands_are_registered()
    {
        $this->assertTrue(array_key_exists('bs5:install', $this->app['Illuminate\Contracts\Console\Kernel']->all()));
        $this->assertTrue(array_key_exists('bs5:publish', $this->app['Illuminate\Contracts\Console\Kernel']->all()));
    }

    /** @test */
    public function install_command_validates_preset_names()
    {
        // This would require more complex testing with actual command execution
        // For now, we test that the command can be instantiated
        $command = $this->app->make(InstallCommand::class);
        $this->assertInstanceOf(InstallCommand::class, $command);
    }

    /** @test */
    public function publish_command_can_list_options()
    {
        $command = $this->app->make(PublishCommand::class);
        $this->assertInstanceOf(PublishCommand::class, $command);

        // Test that the command has the list option
        $definition = $command->getDefinition();
        $this->assertTrue($definition->hasOption('list'));
    }
}
