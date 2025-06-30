#!/bin/bash

# ===================================================================
# BS5 Starter Kit Version Update Script
# ===================================================================
#
# Automatically updates version numbers across the entire project
# to ensure consistency and prevent missed references.
#
# Usage: ./update-version.sh <new-version> [--dry-run]
#
# Examples:
#   ./update-version.sh 1.0.2
#   ./update-version.sh 1.0.1 --dry-run
#   ./update-version.sh 2.0.0
#
# ===================================================================

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
PURPLE='\033[0;35m'
CYAN='\033[0;36m'
NC='\033[0m' # No Color

# Configuration
DRY_RUN=false
VERBOSE=false
NEW_VERSION=""
NEW_DATE=$(date +%Y-%m-%d)

# Get script directory and project root
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_ROOT="$(cd "${SCRIPT_DIR}/../.." && pwd)"

# Ensure we're in the project root
cd "$PROJECT_ROOT"

# Function to print colored output
print_header() {
    echo
    echo -e "${BLUE}╔══════════════════════════════════════════════════════════════╗${NC}"
    echo -e "${BLUE}║${NC} $1 ${BLUE}║${NC}"
    echo -e "${BLUE}╚══════════════════════════════════════════════════════════════╝${NC}"
    echo
}

print_info() {
    echo -e "${BLUE}ℹ${NC} $1"
}

print_success() {
    echo -e "${GREEN}✅${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}⚠${NC} $1"
}

print_error() {
    echo -e "${RED}❌${NC} $1"
}

print_change() {
    echo -e "${CYAN}🔄${NC} $1"
}

# Show usage information
show_usage() {
    echo "BS5 Starter Kit Version Update Script"
    echo ""
    echo "Usage: $0 <new-version> [options]"
    echo ""
    echo "Arguments:"
    echo "  new-version      New semantic version (e.g., 1.0.2, 1.1.0, 2.0.0)"
    echo ""
    echo "Options:"
    echo "  --dry-run       Show what would be changed without making changes"
    echo "  --verbose       Show detailed information"
    echo "  --help          Show this help message"
    echo ""
    echo "Examples:"
    echo "  $0 1.0.2                    # Update to version 1.0.2"
    echo "  $0 1.0.1 --dry-run         # Preview changes for version 1.0.1"
    echo "  $0 2.0.0 --verbose         # Update with detailed output"
    echo ""
    echo "What gets updated:"
    echo "  • src/Version.php (VERSION constant and RELEASE_DATE)"
    echo "  • README.md (version badge URL)"
    echo "  • CHANGELOG.md (adds new version entry)"
    echo "  • docs/configuration.md (example version)"
    echo ""
}

# Validate semantic version format
validate_version() {
    local version="$1"

    if [[ ! $version =~ ^[0-9]+\.[0-9]+\.[0-9]+$ ]]; then
        print_error "Invalid version format: $version"
        print_error "Version must follow semantic versioning (e.g., 1.0.2, 1.1.0, 2.0.0)"
        exit 1
    fi
}

# Get current version from src/Version.php
get_current_version() {
    if [[ -f "src/Version.php" ]]; then
        grep "public const VERSION" src/Version.php | sed "s/.*'\([^']*\)'.*/\1/"
    else
        print_error "src/Version.php not found!"
        exit 1
    fi
}

# Update src/Version.php
update_version_class() {
    local file="src/Version.php"
    local old_version="$1"
    local new_version="$2"
    local new_date="$3"

    print_info "Updating $file..."

    if [[ "$DRY_RUN" == "true" ]]; then
        print_change "Would update VERSION: '$old_version' → '$new_version'"
        print_change "Would update RELEASE_DATE: → '$new_date'"
    else
        # Update version
        sed -i "s/public const VERSION = '$old_version';/public const VERSION = '$new_version';/" "$file"

        # Update release date
        sed -i "s/public const RELEASE_DATE = '[^']*';/public const RELEASE_DATE = '$new_date';/" "$file"

        print_success "Updated $file"
    fi
}

# Update README.md badge
update_readme_badge() {
    local file="README.md"
    local old_version="$1"
    local new_version="$2"

    print_info "Updating $file badge..."

    local old_badge="Version-${old_version}%20Release"
    local new_badge="Version-${new_version}%20Release"
    local old_tag="v${old_version}"
    local new_tag="v${new_version}"

    if [[ "$DRY_RUN" == "true" ]]; then
        print_change "Would update badge: $old_badge → $new_badge"
        print_change "Would update tag link: $old_tag → $new_tag"
    else
        sed -i "s/$old_badge/$new_badge/g" "$file"
        sed -i "s/releases\/tag\/$old_tag/releases\/tag\/$new_tag/g" "$file"
        print_success "Updated $file"
    fi
}

# Update docs/configuration.md
update_docs_config() {
    local file="docs/configuration.md"
    local old_version="$1"
    local new_version="$2"

    print_info "Updating $file..."

    if [[ "$DRY_RUN" == "true" ]]; then
        print_change "Would update config example: '$old_version' → '$new_version'"
    else
        sed -i "s/'version' => '$old_version',/'version' => '$new_version',/" "$file"
        print_success "Updated $file"
    fi
}

# Add new entry to CHANGELOG.md
update_changelog() {
    local file="CHANGELOG.md"
    local new_version="$1"
    local new_date="$2"

    print_info "Updating $file..."

    if [[ "$DRY_RUN" == "true" ]]; then
        print_change "Would add new changelog entry: [$new_version] - $new_date"
    else
        # Create temp file with new entry
        local temp_file=$(mktemp)

        # Read the file and insert new version after the header
        awk -v version="$new_version" -v date="$new_date" '
        /^## \[.*\] - / && !inserted {
            print "## [" version "] - " date
            print ""
            print "### Changed"
            print "- 🔄 **Version Update** - Updated to version " version
            print ""
            inserted = 1
        }
        { print }
        ' "$file" > "$temp_file"

        mv "$temp_file" "$file"
        print_success "Updated $file"
    fi
}

# Scan for any missed version references
scan_for_missed_references() {
    local old_version="$1"
    local new_version="$2"

    print_info "Scanning for any missed version references..."

    # Files to exclude from scanning
    local exclude_pattern="\./\(\.git\|vendor\|node_modules\|test-workspace\|\.phpunit\.result\.cache\)"

    # Find any remaining references to old version
    local found_files=$(find . -type f -name "*.md" -o -name "*.php" -o -name "*.json" -o -name "*.yml" -o -name "*.yaml" | \
                       grep -v "$exclude_pattern" | \
                       xargs grep -l "$old_version" 2>/dev/null || true)

    if [[ -n "$found_files" ]]; then
        print_warning "Found additional references to version $old_version in:"
        for file in $found_files; do
            local line_numbers=$(grep -n "$old_version" "$file" | head -3)
            echo -e "${YELLOW}  📄 $file${NC}"
            echo "$line_numbers" | while read -r line; do
                echo -e "${YELLOW}    → $line${NC}"
            done
        done
        echo
        print_warning "Please review these files manually to ensure they should be updated."
    else
        print_success "No additional version references found"
    fi
}

# Generate summary report
generate_summary() {
    local old_version="$1"
    local new_version="$2"
    local new_date="$3"

    print_header "VERSION UPDATE SUMMARY"

    echo -e "${BLUE}Version Change:${NC}"
    echo -e "  📦 Old Version: ${old_version}"
    echo -e "  📦 New Version: ${new_version}"
    echo -e "  📅 Release Date: ${new_date}"
    echo

    echo -e "${BLUE}Files Updated:${NC}"
    echo -e "  ✅ src/Version.php - Main version constants"
    echo -e "  ✅ README.md - Version badge and release link"
    echo -e "  ✅ CHANGELOG.md - New version entry"
    echo -e "  ✅ docs/configuration.md - Configuration example"
    echo

    if [[ "$DRY_RUN" == "true" ]]; then
        echo -e "${YELLOW}ℹ This was a DRY RUN - no files were actually modified${NC}"
        echo -e "${YELLOW}ℹ Run without --dry-run to apply these changes${NC}"
    else
        echo -e "${GREEN}✅ All version references updated successfully!${NC}"
        echo
        echo -e "${BLUE}Next steps:${NC}"
        echo -e "  1. Review the changes: ${CYAN}git diff${NC}"
        echo -e "  2. Test the updated version: ${CYAN}./test${NC}"
        echo -e "  3. Commit the changes: ${CYAN}git add . && git commit -m \"chore: bump version to ${new_version}\"${NC}"
        echo -e "  4. Create a git tag: ${CYAN}git tag v${new_version}${NC}"
    fi
}

# Parse command line arguments
while [[ $# -gt 0 ]]; do
    case $1 in
        --dry-run)
            DRY_RUN=true
            shift
            ;;
        --verbose)
            VERBOSE=true
            shift
            ;;
        --help|-h)
            show_usage
            exit 0
            ;;
        -*)
            print_error "Unknown option: $1"
            show_usage
            exit 1
            ;;
        *)
            if [[ -z "$NEW_VERSION" ]]; then
                NEW_VERSION="$1"
            else
                print_error "Too many arguments"
                show_usage
                exit 1
            fi
            shift
            ;;
    esac
done

# Validate arguments
if [[ -z "$NEW_VERSION" ]]; then
    print_error "Missing required argument: new-version"
    show_usage
    exit 1
fi

# Validate version format
validate_version "$NEW_VERSION"

# Get current version
CURRENT_VERSION=$(get_current_version)

print_header "BS5 STARTER KIT VERSION UPDATE"

echo -e "${BLUE}Current Version:${NC} $CURRENT_VERSION"
echo -e "${BLUE}New Version:${NC} $NEW_VERSION"
echo -e "${BLUE}Release Date:${NC} $NEW_DATE"
echo -e "${BLUE}Dry Run:${NC} $DRY_RUN"
echo

# Confirm if not dry run
if [[ "$DRY_RUN" == "false" ]]; then
    echo -e "${YELLOW}This will update version references throughout the project.${NC}"
    read -p "Continue? (y/N): " -n 1 -r
    echo
    if [[ ! $REPLY =~ ^[Yy]$ ]]; then
        print_info "Operation cancelled"
        exit 0
    fi
    echo
fi

# Update all version references
update_version_class "$CURRENT_VERSION" "$NEW_VERSION" "$NEW_DATE"
update_readme_badge "$CURRENT_VERSION" "$NEW_VERSION"
update_docs_config "$CURRENT_VERSION" "$NEW_VERSION"
update_changelog "$NEW_VERSION" "$NEW_DATE"

# Scan for missed references
scan_for_missed_references "$CURRENT_VERSION" "$NEW_VERSION"

# Generate summary
generate_summary "$CURRENT_VERSION" "$NEW_VERSION" "$NEW_DATE"