<?php

namespace Darvis\MantaVacancy\Livewire\Vacancyreaction;

use Livewire\Component;
use Darvis\MantaVacancy\Models\Vacancy;
use Darvis\MantaVacancy\Models\Vacancyreaction;
use Darvis\MantaVacancy\Traits\VacancyreactionTrait;
use Manta\FluxCMS\Traits\MantaTrait;

use Livewire\Attributes\Layout;

#[Layout('manta-cms::layouts.app')]
class VacancyreactionUpload extends Component
{
    use MantaTrait;
    use VacancyreactionTrait;

    public function mount(Vacancyreaction $vacancyreaction)
    {
        $this->item = $vacancyreaction;
        $this->itemOrg = $vacancyreaction;
        $this->id = $vacancyreaction->id;
        $this->locale = $vacancyreaction->locale;

        $this->vacancy = Vacancy::find($this->item->vacancy_id);

        if (!$this->vacancy) {
            return abort(404);
        }

        $this->getLocaleInfo();
        $this->getTablist();
        $this->getBreadcrumb('upload', [
            'parents' =>
            [
                ['url' => route('vacancy.list'), 'title' => module_config('Vacancy')['module_name']['multiple']]
            ]
        ]);
    }

    public function render()
    {
        return view('manta-cms::livewire.default.manta-default-upload')->title($this->config['module_name']['single'] . ' bestanden');
    }
}
