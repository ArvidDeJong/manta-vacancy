<?php

namespace Darvis\MantaVacancy\Livewire\Vacancyreaction;

use Livewire\Component;
use Darvis\MantaVacancy\Traits\VacancyreactionTrait;
use Manta\FluxCMS\Traits\MantaTrait;

use Livewire\Attributes\Layout;

#[Layout('manta-cms::layouts.app')]
class VacancyreactionSettings extends Component
{
    use MantaTrait;
    use VacancyreactionTrait;

    public array $settingsArr = [];
    public array $settings = [];
    public array $emailcodes = [];

    public function mount()
    {

        $this->getSettings();
        $this->getBreadcrumb('settings');

        $this->settings = $this->config['settings'];
    }

    public function render()
    {
        return view('manta-cms::livewire.default.manta-default-settings')->title($this->config['module_name']['single'] . ' instellingen');
    }
}
