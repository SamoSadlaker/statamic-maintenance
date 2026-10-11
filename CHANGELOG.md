# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- Support for Statamic 6 (requires `statamic/cms` `^6.0`).
- Use default maintenance page toggle, with a **Custom Maintenance Page** field that appears when it is disabled.

### Changed
- Settings page is now rendered with Statamic 6's built-in publish form, so the addon ships no Control Panel assets and requires no `npm` build step.
- Maintenance page bypasses Control Panel users (super users or users with the `access cp` permission).

## [1.2.0] - 2025-04-06

### Fixed
- Corrected the Statamic super user check.

## [1.1.0] - 2025-03-29

### Added
- Named routes for the Control Panel settings page and the frontend maintenance page.

### Fixed
- Fixed a typo.

## [1.0.0] - 2025-03-16

### Changed
- Updated README.

## [0.0.1] - 2025-03-16

### Added
- Initial release.

[Unreleased]: https://github.com/samosadlaker/statamic-maintenance/compare/v1.2.0...HEAD
[1.2.0]: https://github.com/samosadlaker/statamic-maintenance/compare/v1.1.0...v1.2.0
[1.1.0]: https://github.com/samosadlaker/statamic-maintenance/compare/v1.0.0...v1.1.0
[1.0.0]: https://github.com/samosadlaker/statamic-maintenance/compare/v0.0.1...v1.0.0
[0.0.1]: https://github.com/samosadlaker/statamic-maintenance/releases/tag/v0.0.1
