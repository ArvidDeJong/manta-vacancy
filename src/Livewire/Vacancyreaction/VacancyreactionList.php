<?php

namespace Darvis\MantaVacancy\Livewire\Vacancyreaction;

use Livewire\Component;
use Darvis\MantaVacancy\Models\Vacancyreaction;
use Darvis\MantaVacancy\Traits\VacancyreactionTrait;
use Manta\FluxCMS\Traits\SortableTrait;
use Manta\FluxCMS\Traits\MantaTrait;
use Manta\FluxCMS\Traits\WithSortingTrait;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use Darvis\MantaVacancy\Models\Vacancy;
use Livewire\Attributes\Layout;

#[Layout('manta-cms::layouts.app')]
class VacancyreactionList extends Component
{
    use VacancyreactionTrait;
    use WithPagination;
    use SortableTrait;
    use MantaTrait;
    use WithSortingTrait;

    public function mount(Request $request)
    {
        $vacancy_id = $request->input('vacancy_id');

        $this->vacancy = Vacancy::find($vacancy_id);

        $this->getBreadcrumb('list', [
            'parents' =>
            [
                ['url' => route('vacancy.reaction.list'), 'title' => $this->config['module_name']['multiple']]
            ]
        ]);
    }

    public function render()
    {
        $this->trashed = count(Vacancyreaction::whereNull('pid')->onlyTrashed()->get());

        $obj = Vacancyreaction::whereNull('pid');
        if ($this->tablistShow == 'trashed') {
            $obj->onlyTrashed();
        }
        $obj = $this->applySorting($obj);
        $obj = $this->applySearch($obj);
        $items = $obj->paginate(50);
        return view('manta-vacancy::livewire.vacancyreaction.vacancyreaction-list', ['items' => $items])->title($this->config['module_name']['multiple']);
    }
}
