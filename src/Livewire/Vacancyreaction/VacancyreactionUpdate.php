<?php

namespace Darvis\MantaVacancy\Livewire\Vacancyreaction;

use Flux\Flux;
use Livewire\Component;
use Darvis\MantaVacancy\Models\Vacancyreaction;
use Darvis\MantaVacancy\Traits\VacancyreactionTrait;
use Manta\FluxCMS\Traits\MantaTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Darvis\MantaVacancy\Models\Vacancy;

use Livewire\Attributes\Layout;

#[Layout('manta-cms::layouts.app')]
class VacancyreactionUpdate extends Component
{
    use MantaTrait;
    use VacancyreactionTrait;

    public function mount(Request $request, Vacancyreaction $vacancyreaction)
    {
        $this->item = $vacancyreaction;
        $this->itemOrg = translate($vacancyreaction, 'nl')['org'];
        $this->id = $vacancyreaction->id;

        $this->vacancy = Vacancy::find($this->item->vacancy_id);

        if (!$this->vacancy) {
            return abort(404);
        }


        $this->fill(
            $vacancyreaction->only(
                'company_id',
                'host',
                'pid',
                'locale',
                'active',
                'sort',
                'company',
                'title',
                'sex',
                'firstname',
                'middlename',
                'lastname',
                'email',
                'phone',
                'address',
                'address_nr',
                'zipcode',
                'city',
                'country',
                'birthdate',
                'subject',
                'comment',
                'internal_contact',
                'ip',
                'option_1',
                'option_2',
                'option_3',
                'option_4',
                'option_5',
                'option_6',
            ),
        );
        $this->getLocaleInfo();
        $this->getTablist();
        $this->getBreadcrumb('update', [
            'parents' =>
            [
                ['url' => route('vacancy.list'), 'title' => module_config('Vacancy')['module_name']['multiple']]
            ]
        ]);
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
            'host',
            'pid',
            'locale',
            'active',
            'sort',
            'company',
            'title',
            'sex',
            'firstname',
            'middlename',
            'lastname',
            'email',
            'phone',
            'address',
            'address_nr',
            'zipcode',
            'city',
            'country',
            'birthdate',
            'subject',
            'comment',
            'internal_contact',
            'ip',
            'option_1',
            'option_2',
            'option_3',
            'option_4',
            'option_5',
            'option_6',
        );
        $row['updated_by'] = auth('staff')->user()->name;
        Vacancyreaction::where('id', $this->id)->update($row);

        Flux::toast('Opgeslagen', duration: 1000, variant: 'success');
    }
}
