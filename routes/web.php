<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Contact Routes
|--------------------------------------------------------------------------
|
| Hier definiëren we de routes voor de Contact package.
|
*/

Route::middleware(['web', 'auth:staff'])->prefix(config('manta-vacancy.route_prefix'))
    ->name('vacancy.')
    ->group(function () {
        Route::get("", \Darvis\MantaVacancy\Livewire\Vacancy\VacancyList::class)->name('list');
        Route::get("/toevoegen", \Darvis\MantaVacancy\Livewire\Vacancy\VacancyCreate::class)->name('create');
        Route::get("/aanpassen/{vacancy}", \Darvis\MantaVacancy\Livewire\Vacancy\VacancyUpdate::class)->name('update');
        Route::get("/lezen/{vacancy}", \Darvis\MantaVacancy\Livewire\Vacancy\VacancyRead::class)->name('read');
        Route::get("/bestanden/{vacancy}", \Darvis\MantaVacancy\Livewire\Vacancy\VacancyUpload::class)->name('upload');

        Route::get("/reaction", \Darvis\MantaVacancy\Livewire\Vacancyreaction\VacancyreactionList::class)->name('reaction.list');
        Route::get("/reaction/toevoegen/{vacancy}", \Darvis\MantaVacancy\Livewire\Vacancyreaction\VacancyreactionCreate::class)->name('reaction.create');
        Route::get("/reaction/aanpassen/{vacancyreaction}", \Darvis\MantaVacancy\Livewire\Vacancyreaction\VacancyreactionUpdate::class)->name('reaction.update');
        Route::get("/reaction/lezen/{vacancyreaction}", \Darvis\MantaVacancy\Livewire\Vacancyreaction\VacancyreactionRead::class)->name('reaction.read');
        Route::get("/reaction/bestanden/{vacancyreaction}", \Darvis\MantaVacancy\Livewire\Vacancyreaction\VacancyreactionUpload::class)->name('reaction.upload');
        Route::get("/reaction/instellingen", \Darvis\MantaVacancy\Livewire\Vacancyreaction\VacancyreactionSettings::class)->name('reaction.settings');
    });
