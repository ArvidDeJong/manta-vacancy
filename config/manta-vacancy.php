<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Manta Vacancy Configuration
    |--------------------------------------------------------------------------
    |
    | Hier kan je de configuratie voor de Manta Vacancy package aanpassen.
    |
    */

    // Route prefix voor de vacancy module
    'route_prefix' => 'cms/vacatures',

    // Database instellingen
    'database' => [
        'table_name' => 'vacancies',
        'reactions_table_name' => 'vacancyreactions',
    ],

    // Email instellingen
    'email' => [
        'from' => [
            'address' => env('MAIL_FROM_ADDRESS', 'noreply@example.com'),
            'name' => env('MAIL_FROM_NAME', 'Manta Vacancy'),
        ],
        'enabled' => true,
        'default_subject' => 'Nieuwe vacature reactie',
        'default_receivers' => env('MAIL_TO_ADDRESS', 'admin@example.com'),
    ],

    // UI instellingen
    'ui' => [
        'items_per_page' => 25,
        'show_breadcrumbs' => true,
    ],


];
