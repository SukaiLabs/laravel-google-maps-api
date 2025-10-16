# Changelog

All notable changes to the Google Maps Package will be documented in this file.

## [1.0.0] - 2024-01-01

### Added
- Initial release of Google Maps Package
- Google Maps Geocoding features:
  - Place autocomplete
  - Address geocoding
  - Reverse geocoding
  - Place details lookup
- Address History Management:
  - CRUD operations for user addresses
  - Automatic cleanup of old addresses
  - Policy-based authorization
  - Coordinate storage and management
- Multi-language Translation System:
  - Built-in translations for 3 languages (English, French, Arabic)
  - Publishable translation files via artisan command
  - Translated validation messages
  - Localized API responses and error messages
  - Easy customization through Laravel's translation system
- Auto-registering routes under `/api/v1`
- Configurable middleware and rate limiting
- Migration to remove address column from users table
- Comprehensive documentation (11 files including translation guide)
- Form request validation
- Resource transformers
- Support for multiple languages (en, fr, ar)
