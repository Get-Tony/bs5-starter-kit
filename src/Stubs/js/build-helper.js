#!/usr/bin/env node

/**
 * BS5 Starter Kit - Build Helper
 *
 * This script provides user-friendly feedback about SASS deprecation warnings
 * that occur during the build process with Bootstrap 5.
 */

const { spawn } = require('child_process');
const path = require('path');

// ANSI color codes for terminal output
const colors = {
    reset: '\x1b[0m',
    bright: '\x1b[1m',
    green: '\x1b[32m',
    yellow: '\x1b[33m',
    blue: '\x1b[34m',
    cyan: '\x1b[36m',
};

function printHeader() {
    console.log(`${colors.cyan}${colors.bright}🚀 BS5 Starter Kit - Building Assets${colors.reset}\n`);
}

function printWarningNotice() {
    console.log(`${colors.yellow}${colors.bright}📋 SASS Deprecation Notice${colors.reset}`);
    console.log(`${colors.yellow}┌─────────────────────────────────────────────────────────────────────┐${colors.reset}`);
    console.log(`${colors.yellow}│ You may see deprecation warnings during the build process.         │${colors.reset}`);
    console.log(`${colors.yellow}│ These are from Bootstrap 5's internal SASS code, not your project. │${colors.reset}`);
    console.log(`${colors.yellow}│                                                                     │${colors.reset}`);
    console.log(`${colors.yellow}│ ✅ Your build will complete successfully                            │${colors.reset}`);
    console.log(`${colors.yellow}│ ✅ These warnings don't affect functionality                        │${colors.reset}`);
    console.log(`${colors.yellow}│ ✅ Bootstrap 6 will resolve these warnings                          │${colors.reset}`);
    console.log(`${colors.yellow}└─────────────────────────────────────────────────────────────────────┘${colors.reset}`);
    console.log('');
}

function filterOutput(data) {
    const output = data.toString();
    const lines = output.split('\n');

    // Filter out Bootstrap-related warnings but keep important information
    const filteredLines = lines.filter(line => {
        // Keep build progress and success messages
        if (line.includes('transforming') ||
            line.includes('✓') ||
            line.includes('modules transformed') ||
            line.includes('built in') ||
            line.includes('gzip:') ||
            line.includes('public/build/')) {
            return true;
        }

        // Skip Bootstrap deprecation warnings
        if (line.includes('Deprecation Warning') ||
            line.includes('node_modules/bootstrap') ||
            line.includes('Global built-in functions are deprecated') ||
            line.includes('color.channel') ||
            line.includes('color.mix') ||
            line.includes('math.unit') ||
            line.includes('repetitive deprecation warnings omitted')) {
            return false;
        }

        // Keep other content
        return line.trim() !== '';
    });

    return filteredLines.join('\n');
}

function runBuild(isDev = false) {
    printHeader();
    printWarningNotice();

    const command = isDev ? 'dev' : 'build';
    console.log(`${colors.green}🔨 Running: npm run ${command}${colors.reset}\n`);

    const child = spawn('npm', ['run', command], {
        stdio: ['inherit', 'pipe', 'pipe']
    });

    // Filter and display stdout
    child.stdout.on('data', (data) => {
        const filtered = filterOutput(data);
        if (filtered.trim()) {
            process.stdout.write(filtered);
        }
    });

    // Display stderr as-is (for important errors)
    child.stderr.on('data', (data) => {
        process.stderr.write(data);
    });

    child.on('close', (code) => {
        if (code === 0) {
            console.log(`\n${colors.green}${colors.bright}✅ Build completed successfully!${colors.reset}`);
            console.log(`${colors.green}Your Bootstrap 5 application is ready.${colors.reset}\n`);
        } else {
            console.log(`\n${colors.yellow}❌ Build failed with code ${code}${colors.reset}\n`);
            process.exit(code);
        }
    });
}

// Parse command line arguments
const args = process.argv.slice(2);
const isDev = args.includes('--dev') || args.includes('-d');

runBuild(isDev);