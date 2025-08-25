<?php

namespace Darvis\MantaVacancy;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class VacancyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register package services
        $this->mergeConfigFrom(
            __DIR__ . '/../config/manta-vacancy.php',
            'manta-vacancy'
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Publiceer configuratie
        $this->publishes([
            __DIR__ . '/../config/manta-vacancy.php' => config_path('manta-vacancy.php'),
        ], 'manta-vacancy-config');

        // Publiceer migrations
        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'manta-vacancy-migrations');

        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Load views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'manta-vacancy');

        // Register console commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Darvis\MantaVacancy\Console\Commands\InstallCommand::class,
                \Darvis\MantaVacancy\Console\Commands\SeedVacancyCommand::class,
            ]);
        }

        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        // Register Livewire components
        $this->registerLivewireComponents();
    }

    /**
     * Register all Livewire components
     */
    private function registerLivewireComponents(): void
    {
        // Vacancy components
        Livewire::component('vacancy.vacancy-create', \Darvis\MantaVacancy\Livewire\Vacancy\VacancyCreate::class);
        Livewire::component('vacancy.vacancy-list', \Darvis\MantaVacancy\Livewire\Vacancy\VacancyList::class);
        Livewire::component('vacancy.vacancy-read', \Darvis\MantaVacancy\Livewire\Vacancy\VacancyRead::class);
        Livewire::component('vacancy.vacancy-update', \Darvis\MantaVacancy\Livewire\Vacancy\VacancyUpdate::class);
        Livewire::component('vacancy.vacancy-upload', \Darvis\MantaVacancy\Livewire\Vacancy\VacancyUpload::class);

        // Vacancyreaction components
        Livewire::component('vacancyreaction.vacancyreaction-create', \Darvis\MantaVacancy\Livewire\Vacancyreaction\VacancyreactionCreate::class);
        Livewire::component('vacancyreaction.vacancyreaction-list', \Darvis\MantaVacancy\Livewire\Vacancyreaction\VacancyreactionList::class);
        Livewire::component('vacancyreaction.vacancyreaction-read', \Darvis\MantaVacancy\Livewire\Vacancyreaction\VacancyreactionRead::class);
        Livewire::component('vacancyreaction.vacancyreaction-settings', \Darvis\MantaVacancy\Livewire\Vacancyreaction\VacancyreactionSettings::class);
        Livewire::component('vacancyreaction.vacancyreaction-update', \Darvis\MantaVacancy\Livewire\Vacancyreaction\VacancyreactionUpdate::class);
        Livewire::component('vacancyreaction.vacancyreaction-upload', \Darvis\MantaVacancy\Livewire\Vacancyreaction\VacancyreactionUpload::class);
    }
}
