<?php

return [
    "name" => "vacancy",
    "title" => "Vacatures",
    "description" => "Vacatures module",
    "module_name" => [
        "single" => "Vacature",
        "multiple" => "Vacatures"
    ],
    "tabtitle" => "firstname",
    "type" => "module",
    "active" => true,
    "locale" => "nl",
    "data" => [],
    "sort" => 999,
    "route" => null,
    "url" => null,
    "icon" => null,
    "rights" => null,
    "tab_title" => "firstname",
    "ereg" => [],
    "settings" => [],
    "fields" => [
        "uploads" => [
            "active" => true,
            "type" => "",
            "title" => "Uploads",
            "read" => false,
            "required" => false,
            "edit" => true
        ],
        "locale" => [
            "active" => false,
            "type" => "text",
            "title" => "Taal",
            "read" => true,
            "required" => false,
            "edit" => true
        ],
        "sort" => [
            "active" => false,
            "type" => "number",
            "title" => "Sorteer Volgorde",
            "read" => true,
            "step" => 1,
            "required" => false,
            "edit" => true
        ],
        "show_from" => [
            "active" => true,
            "type" => "datetime-local",
            "title" => "Zichtbaar vanaf",
            "read" => true,
            "required" => false,
            "edit" => true
        ],
        "show_till" => [
            "active" => true,
            "type" => "datetime-local",
            "title" => "Zichtbaar tot",
            "read" => true,
            "required" => false,
            "edit" => true
        ],
        "title" => [
            "active" => true,
            "type" => "text",
            "title" => "Titel",
            "read" => true,
            "required" => true,
            "edit" => true
        ],
        "title_2" => [
            "active" => false,
            "type" => "text",
            "title" => "Titel 2",
            "read" => true,
            "required" => false,
            "edit" => true
        ],
        "title_3" => [
            "active" => false,
            "type" => "text",
            "title" => "Titel 3",
            "read" => true,
            "required" => false,
            "edit" => true
        ],
        "slug" => [
            "active" => true,
            "type" => "text",
            "title" => "Slug",
            "read" => true,
            "required" => false,
            "edit" => true
        ],
        "seo_title" => [
            "active" => true,
            "type" => "text",
            "title" => "SEO Titel",
            "read" => true,
            "required" => false,
            "edit" => true
        ],
        "seo_description" => [
            "active" => true,
            "type" => "textarea",
            "title" => "SEO Omschrijving",
            "read" => true,
            "required" => false,
            "edit" => true
        ],
        "email_receivers" => [
            "active" => true,
            "type" => "textarea",
            "title" => "Email ontvanger(s)",
            "read" => true,
            "required" => false,
            "edit" => true
        ],
        "tags" => [
            "active" => false,
            "type" => "text",
            "title" => "Tags",
            "read" => true,
            "required" => false,
            "edit" => true
        ],
        "summary_requirements" => [
            "active" => true,
            "type" => "textarea",
            "title" => "Opsomming",
            "read" => true,
            "required" => false,
            "edit" => true
        ],
        "text_1" => [
            "active" => false,
            "type" => "textarea",
            "title" => "text_1",
            "read" => true,
            "required" => false,
            "edit" => true
        ],
        "text_2" => [
            "active" => false,
            "type" => "textarea",
            "title" => "text_2",
            "read" => true,
            "required" => false,
            "edit" => true
        ],
        "text_3" => [
            "active" => false,
            "type" => "textarea",
            "title" => "text_3",
            "read" => true,
            "required" => false,
            "edit" => true
        ],
        "text_4" => [
            "active" => false,
            "type" => "textarea",
            "title" => "text_4",
            "read" => true,
            "required" => false,
            "edit" => true
        ],
        "excerpt" => [
            "active" => true,
            "type" => "textarea",
            "title" => "Functieomschrijving",
            "read" => true,
            "required" => false,
            "edit" => true
        ],
        "content" => [
            "active" => true,
            "type" => "editor",
            "title" => "Hoofdtekst",
            "read" => true,
            "required" => false,
            "edit" => true
        ],
        "email_client" => [
            "active" => false,
            "type" => "tinymce-email",
            "title" => "Email",
            "read" => true,
            "required" => false,
            "edit" => true
        ],
        "email_webmaster" => [
            "active" => false,
            "type" => "tinymce-email",
            "title" => "Email webmaster",
            "read" => true,
            "required" => false,
            "edit" => true
        ],
    ]
];
