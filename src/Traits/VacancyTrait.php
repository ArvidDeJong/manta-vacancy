<?php

namespace Darvis\MantaVacancy\Traits;

use Darvis\MantaVacancy\Models\Vacancy;
use Livewire\Attributes\Locked;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Manta\FluxCMS\Models\MantaModule;
use Manta\FluxCMS\Services\ModuleSettingsService;

trait VacancyTrait
{
    public function __construct()
    {
        $this->module_routes = [
            'name' => 'vacancy',
            'list' => 'vacancy.list',
            'create' => 'vacancy.create',
            'update' => 'vacancy.update',
            'read' => 'vacancy.read',
            'upload' => 'vacancy.upload',
            'settings' => 'vacancy.settings',
            'maps' => null,
        ];

        $settings = ModuleSettingsService::ensureModuleSettings('vacancy', 'darvis/manta-vacancy');
        $this->config = $settings;

        $this->fields = $settings['fields'] ?? [];
        $this->tab_title = $settings['tab_title'] ?? null;
        $this->moduleClass = 'Darvis\MantaVacancy\Models\Vacancy';
    }


    // * Model items
    public ?Vacancy $item = null;
    public ?Vacancy $itemOrg = null;



    #[Locked]
    public ?string $company_id = null;

    #[Locked]
    public ?string $host = null;

    public ?string $locale = null;
    public ?string $pid = null;


    public int $sort = 0;
    public ?string $title = null;
    public ?string $title_2 = null;
    public ?string $title_3 = null;
    public ?string $slug = null;

    public ?string $seo_title = null;
    public ?string $seo_description = null;
    public ?string $tags = null;
    public ?string $excerpt = null;
    public ?string $content = null;
    public ?string $summary_requirements = null;
    public ?string $show_from = null;
    public ?string $show_till = null;
    public ?string $email_receivers = null;
    public ?string $text_1 = null;
    public ?string $text_2 = null;
    public ?string $text_3 = null;
    public ?string $text_4 = null;
    public ?string $email_client = null;
    public ?string $email_webmaster = null;

    public function rules()
    {
        if ($this->title != null) {
            $this->slug = $this->slug == null ? Str::of($this->title)->slug('-') : $this->slug;
            $this->seo_title = $this->seo_title == null ? $this->title : $this->seo_title;
        }


        $return = [];
        if ($this->fields['title']) $return['title'] = 'required';
        // if ($this->fields['excerpt']) $return['excerpt'] = 'required';
        return $return;
    }

    public function messages()
    {
        $return = [];
        if ($this->fields['title']) $return['title.required'] = 'De titel is verplicht';
        if ($this->fields['excerpt']) $return['excerpt.required'] = 'De inleiding is verplicht';
        return $return;
    }

    protected function applySearch($query)
    {
        return $this->search === ''
            ? $query
            : $query->where(function (Builder $querysub) {
                $querysub->where('title', 'LIKE', "%{$this->search}%")
                    ->orWhere('content', 'LIKE', "%{$this->search}%");
            });
    }
}
