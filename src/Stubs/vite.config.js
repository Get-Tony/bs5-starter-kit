import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/sass/app.scss', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    css: {
        preprocessorOptions: {
            scss: {
                api: 'modern-compiler', // Use modern Sass API
                quietDeps: true, // Suppress warnings from dependencies (Bootstrap)
                silenceDeprecations: [
                    'import',
                    'global-builtin',
                    'color-functions'
                ],
                logger: {
                    warn: function(message, options) {
                        // Filter out Bootstrap deprecation warnings
                        if (message.includes('node_modules/bootstrap') ||
                            message.includes('Global built-in functions are deprecated') ||
                            message.includes('color.channel') ||
                            message.includes('color.mix') ||
                            message.includes('math.unit')) {
                            return; // Suppress Bootstrap warnings
                        }
                        // Show other warnings (from user code)
                        console.warn('SASS Warning:', message);
                    }
                }
            }
        }
    },
    resolve: {
        alias: {
            '~bootstrap': 'bootstrap',
        }
    },
    // Custom build messages
    build: {
        rollupOptions: {
            onwarn(warning, warn) {
                // Suppress specific Bootstrap-related warnings
                if (warning.code === 'SASS_WARNING' ||
                    (warning.message && warning.message.includes('bootstrap'))) {
                    return;
                }
                warn(warning);
            }
        }
    }
});
