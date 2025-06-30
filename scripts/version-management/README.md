# Version Management Scripts

Automated tools for managing version numbers across the BS5 Starter Kit project.

## 📝 Overview

The version management scripts ensure consistent version numbering across all project files, preventing missed references that could cause issues.

## 🚀 Quick Usage

### Update Version

```bash
# From project root
./scripts/version-management/update-version.sh 1.0.2

# Preview changes without applying them
./scripts/version-management/update-version.sh 1.0.1 --dry-run

# Get help
./scripts/version-management/update-version.sh --help
```

### From Project Root

For convenience, you can run the script from the project root:

```bash
# From project root (recommended)
./scripts/version-management/update-version.sh 1.0.2

# Or navigate to the scripts directory
cd scripts/version-management
./update-version.sh 1.0.2
```

## 🔧 What Gets Updated

The script automatically updates version references in:

### Core Version Files
- **`src/Version.php`** - Main version constants (VERSION and RELEASE_DATE)

### Documentation
- **`README.md`** - Version badge URL and GitHub release link
- **`docs/configuration.md`** - Configuration example version

### Change Tracking
- **`CHANGELOG.md`** - Adds new version entry with current date

### Detection
- **Scans entire project** for any additional version references you might have missed

## 📋 Features

### ✅ **Safety Features**
- **Semantic Version Validation** - Ensures proper version format (e.g., 1.0.2)
- **Dry Run Mode** - Preview changes before applying them
- **Confirmation Prompt** - Requires confirmation for actual changes
- **Current Version Detection** - Automatically reads current version from source

### 📊 **Comprehensive Updates**
- **Badge URLs** - Updates README.md version badge and release links
- **Documentation** - Updates configuration examples
- **Change Log** - Adds new entry with current date
- **Missed Reference Detection** - Scans for any overlooked version references

### 🎯 **User-Friendly Output**
- **Colored Output** - Clear visual feedback with status colors
- **Progress Tracking** - Shows what's being updated
- **Summary Report** - Detailed summary of all changes made
- **Next Steps** - Guides you through post-update tasks

## 🔄 Workflow Example

```bash
# 1. Preview the changes
./scripts/version-management/update-version.sh 1.0.2 --dry-run

# 2. Apply the updates
./scripts/version-management/update-version.sh 1.0.2

# 3. Review changes
git diff

# 4. Test the updated version
./test

# 5. Commit changes
git add .
git commit -m "chore: bump version to 1.0.2"

# 6. Create git tag
git tag v1.0.2
```

## ⚙️ Options

| Option | Description |
|--------|-------------|
| `--dry-run` | Preview changes without applying them |
| `--verbose` | Show detailed information (future feature) |
| `--help` | Display help message |

## 🔍 Version Detection

The script automatically detects missed references by scanning:

- **File Types**: `.md`, `.php`, `.json`, `.yml`, `.yaml`
- **Exclusions**: `.git/`, `vendor/`, `node_modules/`, test workspace
- **Smart Detection**: Finds version patterns and reports locations

## 📁 File Structure

```
scripts/version-management/
├── update-version.sh          # Main version update script
└── README.md                  # This documentation
```

## 🚨 Important Notes

- **Always use semantic versioning** (MAJOR.MINOR.PATCH)
- **Test after updating** to ensure everything works correctly
- **Review changes** before committing to catch any issues
- **Use dry-run first** to preview changes on important updates

## 🔗 Related

- [Main Project README](../../README.md)
- [CHANGELOG](../../CHANGELOG.md)
- [Version Class](../../src/Version.php)