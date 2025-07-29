<?php

namespace Darvis\MantaVacancy\Livewire\Vacancy;

use Livewire\Component;
use Darvis\MantaVacancy\Models\Vacancy;
use Darvis\MantaVacancy\Traits\VacancyTrait;
use Manta\FluxCMS\Traits\SortableTrait;
use Manta\FluxCMS\Traits\MantaTrait;
use Manta\FluxCMS\Traits\WithSortingTrait;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('manta-cms::layouts.app')]
class VacancyList extends Component
{
    use VacancyTrait;
    use WithPagination;
    use SortableTrait;
    use MantaTrait;
    use WithSortingTrait;

    public function mount()
    {
        $this->getBreadcrumb();
    }

    public function render()
    {
        $this->trashed = count(Vacancy::whereNull('pid')->onlyTrashed()->get());

        $obj = Vacancy::whereNull('pid');
        if ($this->tablistShow == 'trashed') {
            $obj->onlyTrashed();
        }
        $obj = $this->applySorting($obj);
        $obj = $this->applySearch($obj);
        $items = $obj->paginate(50);
        return view('manta-vacancy::livewire.vacancy.vacancy-list', ['items' => $items])->title($this->config['module_name']['multiple']);
    }
}
