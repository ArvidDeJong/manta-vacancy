<?php

namespace Darvis\MantaVacancy\Livewire\Vacancy;

use Flux\Flux;
use Livewire\Component;
use Darvis\MantaVacancy\Models\Vacancy;
use Darvis\MantaVacancy\Traits\VacancyTrait;
use Manta\FluxCMS\Traits\MantaTrait;
use Illuminate\Http\Request;

use Livewire\Attributes\Layout;

#[Layout('manta-cms::layouts.app')]
class VacancyUpdate extends Component
{
    use MantaTrait;
    use VacancyTrait;

    public function mount(Request $request, Vacancy $vacancy)
    {
        $this->item = $vacancy;
        $this->itemOrg = translate($vacancy, 'nl')['org'];
        $this->id = $vacancy->id;

        $this->fill(
            $vacancy->only(
                'company_id',
                'locale',
                'pid',
                'sort',
                'title',
                'title_2',
                'title_3',
                'employment_type',
                'location',
                'slug',
                'seo_title',
                'seo_description',
                'tags',
                'excerpt',
                'content',
                'summary_requirements',
                'show_from',
                'show_till',

                'text_1',
                'text_2',
                'text_3',
                'text_4',
                'email_client',
                'email_webmaster',
            ),
        );

        $this->email_receivers = implode(PHP_EOL, (array)$vacancy->email_receivers);

        $this->getLocaleInfo();
        $this->getTablist();
        $this->getBreadcrumb('update');
    }

    public function render()
    {
        return view('manta-cms::livewire.default.manta-default-update')->title($this->config['module_name']['single'] . ' aanpassen');
    }

    public function save()
    {
        $this->validate();

        $row = $this->only(
            'company_id',
            'locale',
            'pid',
            'sort',
            'title',
            'title_2',
            'title_3',
            'employment_type',
            'location',
            'slug',
            'seo_title',
            'seo_description',
            'tags',
            'excerpt',
            'content',
            'summary_requirements',
            'show_from',
            'show_till',

            'text_1',
            'text_2',
            'text_3',
            'text_4',
            'email_client',
            'email_webmaster',
        );

        $row['email_receivers'] = explode(PHP_EOL,  $this->email_receivers);
        $row['updated_by'] = auth('staff')->user()->name;
        Vacancy::where('id', $this->id)->update($row);

        // return redirect()->to(route('vacancy.list'));
        Flux::toast('Opgeslagen', duration: 1000, variant: 'success');
    }
}
