<?php

namespace Darvis\MantaVacancy\Livewire\Vacancy;

use Darvis\MantaVacancy\Models\Vacancy;
use Darvis\MantaVacancy\Traits\VacancyTrait;
use Manta\FluxCMS\Traits\MantaTrait;
use Illuminate\Http\Request;
use Livewire\Component;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

use Livewire\Attributes\Layout;

#[Layout('manta-cms::layouts.app')]
class VacancyCreate extends Component
{
    use MantaTrait;
    use VacancyTrait;

    public function mount(Request $request)
    {
        $this->locale = getLocaleManta();
        if ($request->input('locale') && $request->input('pid')) {
            $vacancy = Vacancy::find($request->input('pid'));
            $this->pid = $vacancy->id;
            $this->locale = $request->input('locale');
            $this->itemOrg = $vacancy;
        }

        if (class_exists(Faker::class) && env('USE_FAKER') == true) {
            $faker = Faker::create('NL_nl');

            $this->sort = (string) $faker->numberBetween(1, 100); // Verondersteld als string, aanpassen als nodig.
            $this->title = $faker->sentence(4);
            $this->title_2 = $faker->sentence(4);
            $this->title_3 = $faker->sentence(4);
            $this->slug = Str::of($this->title)->slug('-');
            $this->seo_title = $this->title;
            $this->seo_description = $faker->text(300);
            $this->tags = implode(',', $faker->words(5)); // Verondersteld als comma separated string.
            $this->excerpt = $faker->text(500);
            $this->content = $faker->text(500);
            $this->summary_requirements = $faker->text(200);
            $this->show_from = $faker->dateTimeThisYear->format('Y-m-d H:i');
            $this->show_till = $faker->dateTimeThisYear('+1 month')->format('Y-m-d H:i');
        }

        $this->getLocaleInfo();
        $this->getTablist();
        $this->getBreadcrumb('create');
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
        $row['created_by'] = auth('staff')->user()->name;
        $row['host'] = request()->host();
        $row['slug'] = $this->slug ? $this->slug : Str::of($this->title)->slug('-');
        $vacancy = Vacancy::create($row);

        return $this->redirect(route('vacancy.read', ['vacancy' => $vacancy]));
    }
}
