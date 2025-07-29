# Manta Vacancy Package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/darvis/manta-vacancy.svg?style=flat-square)](https://packagist.org/packages/darvis/manta-vacancy)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

Een Laravel package voor het beheren van vacatures en sollicitaties. Deze module integreert naadloos met het **darvis/manta-laravel-flux-cms** systeem en biedt een complete oplossing voor vacaturebeheer.

## Features

- 💼 **Vacature Beheer**: Volledige CRUD functionaliteit voor vacatures
- 📝 **Sollicitatie Beheer**: Uitgebreid systeem voor het beheren van sollicitaties
- 🌍 **Meertalig**: Ondersteuning voor meerdere talen via Manta CMS
- 📁 **Bestandsbeheer**: Geïntegreerde upload functionaliteit voor CV's en motivatiebrieven
- 🔍 **Zoek & Filter**: Geavanceerde zoek- en filtermogelijkheden
- 📊 **Rapportage**: Overzichten en statistieken van vacatures en sollicitaties

## Installatie

### Stap 1: Package installeren

```bash
composer require darvis/manta-vacancy:@dev
```

### Stap 2: Package configureren

```bash
php artisan manta-vacancy:install
```

### Stap 3: Module settings importeren

```bash
# Vacancy module importeren
php artisan manta:import-module-settings darvis/manta-vacancy --settings-file=export/settings-vacancy.php

# Vacancyreaction module importeren
php artisan manta:import-module-settings darvis/manta-vacancy --settings-file=export/settings-vacancyreaction.php
```

### Stap 4: Database migraties uitvoeren

```bash
php artisan migrate
```

## Beschikbare Routes

Na installatie zijn de volgende routes beschikbaar:

### Vacature Beheer
- `GET /cms/vacancy` - Overzicht van vacatures
- `GET /cms/vacancy/toevoegen` - Nieuwe vacature aanmaken
- `GET /cms/vacancy/aanpassen/{id}` - Vacature bewerken
- `GET /cms/vacancy/lezen/{id}` - Vacature bekijken
- `GET /cms/vacancy/bestanden/{id}` - Bestanden beheer

### Sollicitatie Beheer
- `GET /cms/vacancy/vacancyreaction` - Overzicht van sollicitaties
- `GET /cms/vacancy/vacancyreaction/instellingen` - Sollicitatie instellingen

### Basis Gebruik

```php
use Darvis\MantaVacancy\Models\Vacancy;
use Darvis\MantaVacancy\Models\Vacancyreaction;

// Nieuwe vacature aanmaken
$vacancy = Vacancy::create([
    'title' => 'Senior Laravel Developer',
    'description' => 'We zoeken een ervaren Laravel developer...',
    'location' => 'Amsterdam',
    'salary_min' => 4000,
    'salary_max' => 6000,
    'active' => true
]);

// Sollicitatie aanmaken
$application = Vacancyreaction::create([
    'vacancy_id' => $vacancy->id,
    'firstname' => 'Jan',
    'lastname' => 'Jansen',
    'email' => 'jan@example.com',
    'phone' => '06-12345678',
    'motivation' => 'Ik ben zeer geïnteresseerd in deze functie...'
]);
```

## Documentation

For detailed documentation, please see the `/docs` directory:

- 📚 **[Installation Guide](docs/installation.md)** - Complete installation instructions
- ⚙️ **[Configuration](docs/configuration.md)** - Configuration options and settings
- 🚀 **[Usage Guide](docs/usage.md)** - How to use the package
- 🗄️ **[Database Schema](docs/database.md)** - Complete database documentation
- 🔧 **[Troubleshooting](docs/troubleshooting.md)** - Common issues and solutions
- 🔌 **[API Documentation](docs/api.md)** - Programmatic usage and API endpoints

## Requirements

- PHP ^8.2
- Laravel ^12.0
- darvis/manta-laravel-flux-cms

## Integration with Manta CMS

This module is specifically designed for integration with the Manta Laravel Flux CMS:

- **Livewire v3**: All UI components are Livewire components
- **FluxUI**: Consistent design with the CMS
- **Manta Traits**: Reuse of CMS functionality
- **Multi-tenancy**: Support for multiple companies
- **Audit Trail**: Complete logging of changes
- **Soft Deletes**: Safe data deletion

## Support

For support and questions:

- 📧 Email: info@arvid.nl
- 🌐 Website: [arvid.nl](https://arvid.nl)
- 📖 Documentation: See the `/docs` directory for comprehensive guides
- 🐛 Issues: Create an issue in the repository

## Contributing

Contributions are welcome! See [CONTRIBUTING.md](CONTRIBUTING.md) for guidelines.

## Security

If you discover a security issue, please send an email to info@arvid.nl.

## License

The MIT License (MIT). See [License File](LICENSE.md) for more information.

## Credits

- [Darvis](https://github.com/darvis)
- [All contributors](../../contributors)
