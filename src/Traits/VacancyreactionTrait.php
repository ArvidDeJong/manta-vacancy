<?php

namespace Darvis\MantaVacancy\Traits;

use Darvis\MantaVacancy\Models\Vacancyreaction;
use Livewire\Attributes\Locked;
use Illuminate\Database\Eloquent\Builder;
use Darvis\MantaVacancy\Models\Vacancy;
use Manta\FluxCMS\Models\MantaModule;
use Manta\FluxCMS\Services\ModuleSettingsService;

trait VacancyreactionTrait
{
    public function __construct()
    {
        $this->module_routes = [
            'name' => 'vacancy',
            'list' => 'vacancy.reaction.list',
            'create' => 'vacancy.reaction.create',
            'update' => 'vacancy.reaction.update',
            'read' => 'vacancy.reaction.read',
            'upload' => 'vacancy.reaction.upload',
            'settings' => 'vacancy.reaction.settings',
            'maps' => null,
        ];

        $settings = ModuleSettingsService::ensureModuleSettings('vacancyreaction', 'darvis/manta-vacancy');
        $this->config = $settings;

        $this->fields = $settings['fields'] ?? [];
        $this->tab_title = $settings['tab_title'] ?? null;
        $this->moduleClass = 'Darvis\MantaVacancy\Models\Vacancyreaction';
    }

    public array $settingsVacancy = [];

    // * Model items
    public ?Vacancyreaction $item = null;
    public ?Vacancyreaction $itemOrg = null;



    #[Locked]
    public ?string $company_id = null;

    #[Locked]
    public ?string $host = null;

    public ?string $locale = null;
    public ?string $pid = null;


    public ?int $vacancy_id = null;
    public ?string $created_by = null;
    public ?string $updated_by = null;
    public ?string $deleted_by = null;
    public bool $active = true; // Kan ook als bool worden gebruikt indien gewenst
    public int $sort = 0;
    public ?string $company = null;
    public ?string $title = null;
    public ?string $sex = null;
    public ?string $firstname = null;
    public ?string $middlename = null;
    public ?string $lastname = null;
    public ?string $email = null;
    public ?string $phone = null;
    public ?string $address = null;
    public ?string $address_nr = null;
    public ?string $zipcode = null;
    public ?string $city = null;
    public ?string $country = null;
    public ?string $birthdate = null; // Alternatief: \DateTime of \Carbon voor betere datumvalidatie
    public ?string $subject = null;
    public ?string $comment = null;
    public ?string $internal_contact = null;
    public ?string $ip = null;
    public ?string $option_1 = null;
    public ?string $option_2 = null;
    public ?string $option_3 = null;
    public ?string $option_4 = null;
    public ?string $option_5 = null;
    public ?string $option_6 = null;


    public ?Vacancy $vacancy = null;

    public function rules()
    {
        $return = [];

        // Validatie voor alle velden
        $return['company'] = 'nullable|string|max:255';
        $return['title'] = 'required|string|max:255';
        $return['sex'] = 'nullable|string|max:10';
        $return['firstname'] = 'required|string|max:255';
        $return['middlename'] = 'nullable|string|max:255';
        $return['lastname'] = 'required|string|max:255';
        $return['email'] = 'required|email|max:255';
        $return['phone'] = 'nullable|string|max:15';
        $return['address'] = 'nullable|string|max:255';
        $return['address_nr'] = 'nullable|string|max:10';
        $return['zipcode'] = 'nullable|string|max:10';
        $return['city'] = 'nullable|string|max:255';
        $return['country'] = 'nullable|string|max:255';
        $return['birthdate'] = 'nullable|date';
        $return['subject'] = 'nullable|string|max:255';
        $return['comment'] = 'nullable|string|max:500';
        $return['internal_contact'] = 'nullable|string|max:255';
        $return['ip'] = 'nullable|ip';

        return $return;
    }

    public function messages()
    {
        $return = [];

        // Aangepaste foutmeldingen voor verplichte velden
        $return['title.required'] = 'De titel is verplicht.';
        $return['firstname.required'] = 'De voornaam is verplicht.';
        $return['lastname.required'] = 'De achternaam is verplicht.';
        $return['email.required'] = 'Het e-mailadres is verplicht.';
        $return['email.email'] = 'Het e-mailadres moet een geldig formaat hebben.';

        // Optionele velden met extra validatieberichten
        $return['birthdate.date'] = 'De geboortedatum moet een geldige datum zijn.';
        $return['ip.ip'] = 'Het IP-adres moet een geldig formaat hebben.';

        // Specifieke berichten voor string lengtebeperkingen
        $return['company.max'] = 'De bedrijfsnaam mag niet langer zijn dan 255 tekens.';
        $return['title.max'] = 'De titel mag niet langer zijn dan 255 tekens.';
        $return['sex.max'] = 'Het geslacht mag niet langer zijn dan 10 tekens.';
        $return['firstname.max'] = 'De voornaam mag niet langer zijn dan 255 tekens.';
        $return['middlename.max'] = 'De tussenvoegsel mag niet langer zijn dan 255 tekens.';
        $return['lastname.max'] = 'De achternaam mag niet langer zijn dan 255 tekens.';
        $return['email.max'] = 'Het e-mailadres mag niet langer zijn dan 255 tekens.';
        $return['phone.max'] = 'Het telefoonnummer mag niet langer zijn dan 15 tekens.';
        $return['address.max'] = 'Het adres mag niet langer zijn dan 255 tekens.';
        $return['address_nr.max'] = 'Het huisnummer mag niet langer zijn dan 10 tekens.';
        $return['zipcode.max'] = 'De postcode mag niet langer zijn dan 10 tekens.';
        $return['city.max'] = 'De stad mag niet langer zijn dan 255 tekens.';
        $return['country.max'] = 'Het land mag niet langer zijn dan 255 tekens.';
        $return['subject.max'] = 'Het onderwerp mag niet langer zijn dan 255 tekens.';
        $return['comment.max'] = 'De opmerking mag niet langer zijn dan 500 tekens.';
        $return['internal_contact.max'] = 'De interne contactpersoon mag niet langer zijn dan 255 tekens.';

        return $return;
    }


    protected function applySearch($query)
    {
        return $this->search === ''
            ? $query
            : $query->where(function (Builder $querysub) {
                $querysub->where('firstname', 'LIKE', "%{$this->search}%")
                    ->orWhere('lastname', 'LIKE', "%{$this->search}%");
            });
    }
}
