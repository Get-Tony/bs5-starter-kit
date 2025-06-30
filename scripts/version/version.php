#!/usr/bin/env php
<?php

/**
 * BS5 Starter Kit Version Helper
 *
 * Provides version information for scripts and CI/CD workflows
 *
 * Usage:
 *   php version.php              - Get current version
 *   php version.php constraint   - Get Composer constraint
 *   php version.php info         - Get detailed version info
 *   php version.php update       - Update version references in docs
 *
 * @version 1.0.0
 * @author Anthony Pagan <get-tony@outlook.com>
 */

require_once __DIR__ . '/../../vendor/autoload.php';

use LaravelBs5Kit\Version;

function showHelp() {
    echo "BS5 Starter Kit Version Helper\n\n";
    echo "Usage: php version.php [command]\n\n";
    echo "Commands:\n";
    echo "  (none)       Show current version\n";
    echo "  constraint   Show Composer version constraint\n";
    echo "  info         Show detailed version information\n";
    echo "  update       Update version references in documentation\n";
    echo "  help         Show this help message\n\n";
    echo "Examples:\n";
    echo "  php version.php                    # 1.0.0\n";
    echo "  php version.php constraint         # ^1.0\n";
    echo "  php version.php info               # Full version details\n";
    echo "  php version.php update             # Update all docs\n\n";
}

function getConstraint($version) {
    $parts = explode('.', $version);
    return '^' . $parts[0] . '.' . $parts[1];
}

function showVersionInfo() {
    $info = Version::getInfo();
    echo "BS5 Starter Kit Version Information:\n\n";
    echo "Version: " . $info['version'] . "\n";
    echo "Release Date: " . $info['release_date'] . "\n";
    echo "Name: " . $info['name'] . "\n";
    echo "Description: " . $info['description'] . "\n";
}

$command = $argv[1] ?? '';

switch ($command) {
    case 'help':
    case '--help':
    case '-h':
        showHelp();
        break;

    case 'constraint':
        echo getConstraint(Version::getVersion());
        break;

    case 'info':
        showVersionInfo();
        break;

    case 'update':
        echo "Version reference updating has been simplified.\n";
        echo "Version information is now centralized in src/Version.php\n";
        break;

    case '':
        echo Version::getVersion();
        break;

    default:
        echo "Unknown command: {$command}\n\n";
        showHelp();
        exit(1);
}

echo "\n";
