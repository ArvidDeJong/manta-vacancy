# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [0.1.1] - 2025-07-28

### Changed

- **Documentation Improvements** - Complete reorganization and translation of documentation
  - Translated all Markdown files from Dutch to English
  - Corrected module description from "Village of the Year" to contact form management
  - Restructured README.md to be more concise with references to detailed docs
  - Created comprehensive `/docs` directory with structured documentation:
    - `installation.md` - Complete installation guide
    - `configuration.md` - Configuration options and settings
    - `usage.md` - Usage guide with examples
    - `database.md` - Detailed database schema documentation (47 fields)
    - `troubleshooting.md` - Common issues and solutions
    - `api.md` - API documentation and programmatic usage
  - Updated database schema documentation to match actual migration fields
  - Enhanced troubleshooting section with practical solutions
  - Improved code examples and usage instructions

## [0.1.0] - 2025-01-27

### Added

- **Initial Release** - First stable version of the Manta Contact Form module
- **Livewire Components** - Complete CRUD functionality with FluxUI integration
  - `ContactForm` - Contact form component for frontend use
  - `ContactFormSettings` - Module configuration interface
  - `ContactFormSubmission` - View contact form submissions
  - `ContactFormSubmissionUpdate` - Edit existing contact form submissions
  - `ContactFormSubmissionUpload` - File management for contact form submissions
  - `ContactFormButtonEmail` - Email sending functionality
- **Database Migration** - Complete `manta_contact_form_submissions` table structure
  - CMS tracking fields (created_by, updated_by, deleted_by, company_id, host, pid, locale)
  - Contact form submission information (name, email, phone, message)
  - System fields (active, sort, timestamps, soft deletes)
- **ContactFormSubmission Model** - Eloquent model with proper relationships and casts
  - Custom table name: `manta_contact_form_submissions`
  - Soft deletes support
  - HasUploadsTrait integration
  - JSON data attribute handling
  - Email sending capability via service
- **ContactFormTrait** - Reusable trait for Livewire components
  - Dynamic validation rules based on field configuration
  - Comprehensive error messages in English
  - Search functionality across multiple fields
  - Field property definitions
- **ContactFormMailService** - Professional email handling
  - Template processing with placeholders
  - Multiple receiver support
  - Email validation
  - Comprehensive logging
  - Error handling with fallbacks
  - Reply-to functionality
- **Install Command** - `php artisan manta-contact-form:install`
  - Automatic configuration publishing
  - Migration publishing with optional execution
  - Interactive setup process
  - Post-installation instructions
- **Configuration System** - Comprehensive config file
  - Route prefix configuration
  - Database settings
  - Email configuration with environment variables
  - UI settings (pagination, breadcrumbs)
- **Service Provider** - Complete Laravel integration
  - All Livewire components registered
  - Configuration merging and publishing
  - Migration loading and publishing
  - View namespace registration
  - Route loading
  - Console command registration
- **Routing** - Protected admin routes
  - Middleware: `web` and `auth:staff`
  - Configurable route prefix
  - Named routes for all CRUD operations
- **Documentation** - Comprehensive project documentation
  - README with installation instructions
  - MODULE_TEMPLATE with development guidelines
  - Livewire component requirements
  - Database naming conventions
  - Code examples and best practices

### Technical Details

- **Laravel 12** compatibility
- **Livewire 3** with attribute-based layouts
- **FluxUI** integration for consistent styling
- **Tailwind CSS 4** support
- **PHP 8.2+** requirement
- **Manta CMS** integration with traits and layouts

### Database

- Table name: `manta_contact_form_submissions` (following Manta CMS naming convention)
- Comprehensive field structure for contact form submissions
- Proper indexing for performance
- Soft delete support for data integrity

### Security

- Staff authentication required for all routes
- Input validation with configurable rules
- Email validation and sanitization
- Protected against common vulnerabilities

### Developer Experience

- Automatic installation via composer scripts
- Comprehensive error messages
- Extensive logging for debugging
- Faker integration for development data
- Modular architecture for easy extension

---

## Future Releases

### Planned for 0.2.0

- Advanced email templates
- Export functionality
- API endpoints
- Enhanced search and filtering

### Planned for 0.3.0

- Multi-language support
- Advanced file attachments
- Contact categories
- Bulk operations
- Dashboard widgets

---

## Support

For support, please contact:

- **Email**: info@arvid.nl
- **Documentation**: See README.md and MODULE_TEMPLATE.md
- **Issues**: Create an issue in the repository

## License

This project is licensed under the MIT License.
