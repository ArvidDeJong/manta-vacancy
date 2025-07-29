<?php

namespace Darvis\MantaVacancy\Livewire\Vacancy;

use Livewire\Component;
use Darvis\MantaVacancy\Models\Vacancy;
use Darvis\MantaVacancy\Traits\VacancyTrait;
use Manta\FluxCMS\Traits\MantaTrait;
use Illuminate\Http\Request;

use Livewire\Attributes\Layout;

#[Layout('manta-cms::layouts.app')]
class VacancyRead extends Component
{
    use MantaTrait;
    use VacancyTrait;

    public function mount(Request $request, Vacancy $vacancy)
    {
        $this->item = $vacancy;
        $this->itemOrg = $vacancy;
        $this->locale = $vacancy->locale;
        if ($request->input('locale') && $request->input('locale') != getLocaleManta()) {
            $this->pid = $vacancy->id;
            $this->locale = $request->input('locale');
            $vacancy_translate = Vacancy::where(['pid' => $vacancy->id, 'locale' => $request->input('locale')])->first();
            $this->item = $vacancy_translate;
        }

        if ($vacancy) {
            $this->id = $vacancy->id;
        }
        $this->getLocaleInfo();
        $this->getTablist();
        $this->getBreadcrumb('read');
    }

    public function render()
    {
        return view('manta-cms::livewire.default.manta-default-read')->title($this->config['module_name']['single'] . ' bekijken');
    }
}
