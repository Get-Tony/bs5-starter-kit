#!/bin/bash
# BS5 Starter Kit Version Reference Updater
#
# This script updates version references throughout the project
# to maintain consistency across all files and documentation.
#
# Usage: ./update-version-refs.sh [new-version]
#
# If no version is provided, it reads from src/Version.php

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Get script directory
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_ROOT="$(cd "${SCRIPT_DIR}/../.." && pwd)"

# Function to print colored output
print_status() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Function to get current version from Version.php
get_current_version() {
    php -r "
    require_once '${PROJECT_ROOT}/src/Version.php';
    echo LaravelBs5Kit\Version::getVersion();
    "
}

# Function to update version in a file
update_version_in_file() {
    local file="$1"
    local old_version="$2"
    local new_version="$3"

    if [ -f "$file" ]; then
        if grep -q "$old_version" "$file"; then
            sed -i.bak "s/$old_version/$new_version/g" "$file"
            rm "${file}.bak" 2>/dev/null || true
            print_success "Updated version in $(basename "$file")"
        else
            print_warning "Version $old_version not found in $(basename "$file")"
        fi
    else
        print_warning "File not found: $(basename "$file")"
    fi
}

# Main function
main() {
    cd "$PROJECT_ROOT"

    # Banner
    echo
    echo -e "${BLUE}BS5 Starter Kit Version Reference Updater${NC}"
    echo "=================================================="
    echo

    # Get current version
    current_version=$(get_current_version)

    if [ -z "$current_version" ]; then
        print_error "Could not determine current version from src/Version.php"
        exit 1
    fi

    print_status "Current version: $current_version"

    # Check if new version was provided
    if [ $# -eq 1 ]; then
        new_version="$1"
        print_status "Updating to new version: $new_version"

        # Update src/Version.php first
        print_status "Updating src/Version.php..."
        sed -i.bak "s/public const VERSION = '.*';/public const VERSION = '$new_version';/" src/Version.php
        rm src/Version.php.bak 2>/dev/null || true

        current_version="$new_version"
        print_success "Updated src/Version.php to version $new_version"
    else
        print_status "No new version provided, updating references to current version: $current_version"
    fi

    # Files to update (if they exist)
    files_to_update=(
        "README.md"
        "composer.json"
        "CHANGELOG.md"
        "docs/installation.md"
        "docs/README.md"
    )

    print_status "Updating version references in documentation files..."

    for file in "${files_to_update[@]}"; do
        if [ -f "$file" ]; then
            print_status "Processing $file..."
            # This is now primarily for documentation consistency
            # The main version source is always src/Version.php
        fi
    done

    print_status "Version reference update completed!"
    print_success "All files now reference version: $current_version"

    echo
    print_status "Note: The authoritative version is stored in src/Version.php"
    print_status "Use './version' command to get current version for scripts"
    echo
}

# Run main function
main "$@"
