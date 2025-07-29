<?php

namespace Darvis\MantaVacancy\Livewire\Vacancyreaction;

use Darvis\MantaVacancy\Models\Vacancyreaction;
use Darvis\MantaVacancy\Traits\VacancyreactionTrait;
use Manta\FluxCMS\Traits\MantaTrait;
use Illuminate\Http\Request;
use Livewire\Component;
use Faker\Factory as Faker;
use Darvis\MantaVacancy\Models\Vacancy;

use Livewire\Attributes\Layout;

#[Layout('manta-cms::layouts.app')]
class VacancyreactionCreate extends Component
{
    use MantaTrait;
    use VacancyreactionTrait;

    public function mount(Request $request, Vacancy $vacancy)
    {
        if (!$this->vacancy) {
            return abort(404);
        }

        $this->locale = getLocaleManta();
        if ($request->input('locale') && $request->input('pid')) {
            $vacancyreaction = Vacancyreaction::find($request->input('pid'));
            $this->pid = $vacancyreaction->id;
            $this->locale = $request->input('locale');
            $this->itemOrg = $vacancyreaction;
        }


        if (class_exists(Faker::class) && env('USE_FAKER') == true) {
            $faker = Faker::create('NL_nl');

            $this->company = $faker->company();
            $this->title = $faker->jobTitle();
            $this->sex = $faker->randomElement(['male', 'female']); // Of 'M'/'F'
            $this->firstname = $faker->firstName();
            $this->middlename = $faker->randomElement(['van', 'de', 'van der']); // Of 'M'/'F'
            $this->lastname = $faker->lastName();
            $this->email = $faker->safeEmail();
            $this->phone = $faker->phoneNumber();
            $this->address = $faker->streetAddress();
            $this->address_nr = $faker->buildingNumber();
            $this->zipcode = $faker->postcode();
            $this->city = $faker->city();
            $this->country = $faker->country();
            $this->birthdate = $faker->date('Y-m-d'); // Voor consistentie, 'Y-m-d' formaat
            $this->subject = $faker->sentence();
            $this->comment = $faker->paragraph();
            $this->internal_contact = $faker->name();
            $this->ip = $faker->ipv4();
        }

        $this->getLocaleInfo();
        $this->getTablist();
        $this->getBreadcrumb('create', [
            'parents' =>
            [
                ['url' => route('vacancy.list'), 'title' => module_config('Vacancy')['module_name']['multiple']]
            ]
        ]);
    }

    public function render()
    {
        return view('manta-cms::livewire.default.manta-default-create')->title($this->config['module_name']['single'] . ' toevoegen');
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
        $row['created_by'] = auth('staff')->user()->name;
        $row['host'] = request()->host();
        $row['vacancy_id'] = $this->vacancy->id;;
        $vacancyreaction = Vacancyreaction::create($row);

        return $this->redirect(route('vacancyreaction.read', ['vacancyreaction' => $vacancyreaction]));
    }
}
