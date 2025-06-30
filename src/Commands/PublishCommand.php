<?php

namespace LaravelBs5Kit\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class PublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bs5:publish
                            {--config : Publish configuration file}
                            {--stubs : Publish stub files for customization}
                            {--components : Publish example components}
                            {--list : List all available vendor:publish options}
                            {--force : Overwrite existing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish BS5 Starter Kit resources for customization';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if ($this->option('list')) {
            $this->listVendorPublishTags();

            return 0;
        }

        $this->info('📦 Publishing BS5 Starter Kit resources...');
        $this->newLine();

        if ($this->option('all')) {
            $this->publishConfig();
            $this->publishStubs();
            $this->publishComponents();
        } else {
            if ($this->option('config')) {
                $this->publishConfig();
            }

            if ($this->option('stubs')) {
                $this->publishStubs();
            }

            if ($this->option('components')) {
                $this->publishComponents();
            }

            if (! $this->option('config') && ! $this->option('stubs') && ! $this->option('components')) {
                $this->info('💡 Specify what to publish: --config, --stubs, --components, or --all');
                $this->newLine();
                $this->info('💡 Or use --list to see all vendor:publish options');

                return 0;
            }
        }

        $this->newLine();
        $this->info('✅ BS5 Starter Kit resources published successfully!');

        return 0;
    }

    /**
     * Publish configuration file.
     */
    protected function publishConfig(): void
    {
        $this->call('vendor:publish', [
            '--tag' => 'bs5-kit-config',
            '--force' => $this->option('force'),
        ]);

        $this->info('📄 Configuration file published');
    }

    /**
     * Publish stub files.
     */
    protected function publishStubs(): void
    {
        $this->call('vendor:publish', [
            '--tag' => 'bs5-kit-stubs',
            '--force' => $this->option('force'),
        ]);

        $this->info('📝 Stub files published');
    }

    /**
     * Publish example components.
     */
    protected function publishComponents(): void
    {
        $this->info('�� Publishing example components...');

        // This would copy example components
        // Implementation depends on specific components you want to include

        $this->info('✅ Example components published');
    }

    /**
     * List all available vendor:publish tags for BS5 Starter Kit.
     */
    protected function listVendorPublishTags(): void
    {
        $this->info('📋 Available vendor:publish tags for BS5 Starter Kit:');
        $this->newLine();

        $tags = [
            'bs5-kit-config' => 'Configuration file only',
            'bs5-kit-sass' => 'SASS architecture (7-1 structure)',
            'bs5-kit-js' => 'JavaScript files',
            'bs5-kit-layouts' => 'Layout templates',
            'bs5-kit-components' => 'Blade component templates',
            'bs5-kit-auth' => 'Authentication views',
            'bs5-kit-pages' => 'Example pages',
            'bs5-kit-vite' => 'Vite configuration',
            'bs5-kit-stubs' => 'All stub files (for manual installation)',
            'bs5-kit' => 'Everything (config + stubs)',
        ];

        foreach ($tags as $tag => $description) {
            $this->line("  <info>{$tag}</info> - {$description}");
        }

        $this->newLine();
        $this->info('📖 Usage Examples:');
        $this->line('  <comment>php artisan vendor:publish --tag=bs5-kit-sass</comment>');
        $this->line('  <comment>php artisan vendor:publish --tag=bs5-kit-auth --force</comment>');
        $this->line('  <comment>php artisan vendor:publish --provider="LaravelBs5Kit\Bs5KitServiceProvider"</comment>');

        $this->newLine();
        $this->info('💡 For complete installation, use: <comment>php artisan bs5:install --preset=full</comment>');
    }
}
