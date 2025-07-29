<?php

namespace Darvis\MantaVacancy\Livewire\Vacancyreaction;

use Livewire\Component;
use Darvis\MantaVacancy\Models\Vacancyreaction;
use Darvis\MantaVacancy\Traits\VacancyreactionTrait;
use Manta\FluxCMS\Traits\MantaTrait;
use Illuminate\Http\Request;
use Darvis\MantaVacancy\Models\Vacancy;

use Livewire\Attributes\Layout;

#[Layout('manta-cms::layouts.app')]
class VacancyreactionRead extends Component
{
    use MantaTrait;
    use VacancyreactionTrait;

    public function mount(Request $request, Vacancyreaction $vacancyreaction)
    {
        $this->item = $vacancyreaction;
        $this->itemOrg = $vacancyreaction;
        $this->locale = $vacancyreaction->locale;

        $this->vacancy = Vacancy::find($this->item->vacancy_id);

        if (!$this->vacancy) {
            return abort(404);
        }

        // Controleer of een andere taal is opgegeven en niet dezelfde is als de standaard
        if ($request->filled('locale') && $request->input('locale') != getLocaleManta()) {
            $this->pid = $vacancyreaction->id;
            $this->locale = $request->input('locale');

            // Haal de vertaalde vacature reactie op
            $this->item = Vacancyreaction::where([
                'pid' => $vacancyreaction->id,
                'locale' => $this->locale
            ])->first() ?? $vacancyreaction; // Fallback naar origineel als vertaling niet bestaat
        }
        $this->getLocaleInfo();
        $this->getTablist();
        $this->getBreadcrumb('read', [
            'parents' =>
            [
                ['url' => route('vacancy.list'), 'title' => module_config('Vacancy')['module_name']['multiple']]
            ]
        ]);
    }

    public function render()
    {
        return view('manta-cms::livewire.default.manta-default-read')->title($this->config['module_name']['single'] . ' bekijken');
    }
}
