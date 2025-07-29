<?php

namespace Darvis\MantaVacancy\Livewire\Vacancy;

use Livewire\Component;
use Darvis\MantaVacancy\Models\Vacancy;
use Darvis\MantaVacancy\Traits\VacancyTrait;
use Manta\FluxCMS\Traits\MantaTrait;

use Livewire\Attributes\Layout;

#[Layout('manta-cms::layouts.app')]
class VacancyUpload extends Component
{
    use MantaTrait;
    use VacancyTrait;

    public function mount(Vacancy $vacancy)
    {
        $this->item = $vacancy;
        $this->itemOrg = $vacancy;
        $this->id = $vacancy->id;
        $this->locale = $vacancy->locale;



        $this->getLocaleInfo();
        $this->getTablist();
        $this->getBreadcrumb('upload');
    }

    public function render()
    {
        return view('manta-cms::livewire.default.manta-default-upload')->title($this->config['module_name']['single'] . ' bestanden');
    }
}
