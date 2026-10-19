# Changelog - Version 6.0

## Overview

Version 6.0 introduces modernization of the development infrastructure, enhanced testing, comprehensive documentation, and updated dependency support while maintaining backward compatibility with the core API.

## New Features

### Documentation
- **Comprehensive Documentation Structure**: Added detailed documentation covering all aspects of the library:
  - `docs/getting-started.md` - Introduction and basic usage guide
  - `docs/methods.md` - Complete method reference
  - `docs/custom-maps.md` - Guide for creating custom encoding maps
- **Updated README**: Restructured README.md to reference new documentation structure with quick start examples

### Testing
- **Enhanced Test Coverage**: Added comprehensive test cases for `ShortId` with custom encoding maps
- **Composer Scripts**: Added convenience scripts for running tests and Psalm
  ```bash
  composer test   # Run PHPUnit tests
  composer psalm  # Run Psalm static analysis
  ```

### Development Workflow
- **GitHub Actions**: Migrated from Travis CI to GitHub Actions for CI/CD
- **Improved PHPUnit Workflow**: Enhanced workflow with better container options and updated actions
- **Psalm Integration**: Added comprehensive Psalm static analysis configuration with cache directory support

## Bug Fixes

- **Type Safety**: Fixed potential issue with `unpack()` returning false by adding proper validation in `fromUuid()` method
- **Workflow Improvements**: Refined GitHub Actions workflows for better reliability and performance

## Breaking Changes

| Before (5.x) | After (6.0) | Description |
|--------------|-------------|-------------|
| PHP >= 8.1 < 8.4 | PHP >= 8.3 < 8.6 | Minimum PHP version raised to 8.3; Added support for PHP 8.4 and 8.5 |
| PHPUnit ^9.6 | PHPUnit ^10.5\|^11.5 | Updated to PHPUnit 10 or 11 for modern testing features |
| Psalm ^5.9 | Psalm ^5.9\|^6.13 | Added support for Psalm 6.x |
| Travis CI | GitHub Actions | Migrated CI/CD pipeline to GitHub Actions (.travis.yml removed) |
| `$map = null` | `?string $map = null` | Type hints made explicit with nullable type syntax (no runtime impact) |

## Migration Path from 5.x to 6.0

### Step 1: Check PHP Version
Ensure you're running PHP 8.3 or higher:
```bash
php -v
```

If you're on PHP 8.1 or 8.2, you need to upgrade to PHP 8.3+ before migrating to version 6.0.

### Step 2: Update composer.json
Update your composer.json to use version 6.0:
```json
{
  "require": {
    "byjg/shortid": "^6.0"
  }
}
```

### Step 3: Update Dependencies
Run composer update:
```bash
composer update byjg/shortid
```

### Step 4: Code Review (Optional)
While the API remains compatible, review any usages of the following methods if you're using strict type checking:
- `ShortId::fromNumber()`
- `ShortId::fromHex()`
- `ShortId::fromUuid()`
- `ShortId::fromRandom()`
- `ShortId::get()`

The `$map` parameter now uses explicit nullable type syntax (`?string $map = null`), but this is backward compatible.

### Step 5: Test Your Application
Run your test suite to ensure everything works as expected:
```bash
vendor/bin/phpunit
```

### Step 6: Update CI/CD (if using Travis CI)
If you were using Travis CI configuration from this package as a reference, migrate to GitHub Actions. See `.github/workflows/phpunit.yml` for the new workflow configuration.

## Additional Changes

### Configuration Updates
- Added `prefer-stable: true` and `minimum-stability: dev` to composer.json
- Added Psalm cache directory configuration in psalm.xml
- Updated .gitignore to exclude phpunit coverage/report files and backup files

### Repository Maintenance
- Removed deprecated Travis CI configuration (.travis.yml)
- Enhanced GitHub Actions workflows with better PHP version matrix testing
- Added .idea/runConfigurations for improved IDE integration

## Upgrade Summary

**Low Risk Migration**: This upgrade is low risk for most users. The main requirement is upgrading to PHP 8.3+. All public API methods remain compatible, and the library continues to work exactly as before from a functionality perspective.

**Recommended For**: Projects that have already upgraded to PHP 8.3 or higher and want to benefit from:
- Modern PHP features and performance improvements
- Updated development tools (PHPUnit 10/11, Psalm 6)
- Better documentation and test coverage
- Active CI/CD pipeline on GitHub Actions

**Not Recommended For**: Projects still running on PHP 8.1 or 8.2 should remain on version 5.x until they can upgrade their PHP version.
