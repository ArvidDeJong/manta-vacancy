<?php

namespace Darvis\MantaVacancy\Console\Commands;

use Darvis\MantaVacancy\Models\Vacancy;
use Illuminate\Console\Command;

class SeedVacancyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'manta-vacancy:seed
                            {--force : Force seeding even if vacancies already exist}
                            {--fresh : Delete existing vacancies before seeding}
                            {--with-navigation : Also seed navigation items for vacancy management}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the database with sample vacancies';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🌱 Seeding Manta Vacancies...');
        $this->newLine();

        // Check if vacancies already exist
        $existingCount = Vacancy::count();

        if ($existingCount > 0 && !$this->option('force') && !$this->option('fresh')) {
            $this->warn("⚠️  Found {$existingCount} existing vacancies.");

            if (!$this->confirm('Do you want to continue seeding? This will add more items.', false)) {
                $this->info('Seeding cancelled.');
                return self::SUCCESS;
            }
        }

        // Handle fresh option
        if ($this->option('fresh')) {
            if ($this->confirm('This will delete ALL existing vacancies. Are you sure?', false)) {
                $this->info('🗑️  Deleting existing vacancies...');
                Vacancy::truncate();
                $this->line('   ✅ Existing vacancies deleted');
            } else {
                $this->info('Fresh seeding cancelled.');
                return self::SUCCESS;
            }
        }

        // Run the seeder
        $this->info('💼 Creating sample vacancies...');

        try {
            $this->seedVacancyItems();

            $totalCount = Vacancy::count();
            $this->newLine();
            $this->info("🎉 Vacancy seeding completed successfully!");
            $this->line("   📊 Total vacancies in database: {$totalCount}");
        } catch (\Exception $e) {
            $this->error('❌ Error during seeding: ' . $e->getMessage());
            return self::FAILURE;
        }

        // Seed navigation if requested
        if ($this->option('with-navigation')) {
            $this->seedNavigation();
        }

        $this->newLine();
        $this->comment('💡 Tips:');
        $this->line('• Use --fresh to start with a clean slate');
        $this->line('• Use --force to skip confirmation prompts');
        $this->line('• Use --with-navigation to also seed navigation items');
        $this->line('• Check your vacancy management interface to see the seeded items');

        return self::SUCCESS;
    }

    /**
     * Seed the vacancy items into the database
     */
    private function seedVacancyItems(): void
    {
        $vacancyItems = [
            [
                'company_id' => 1,
                'created_by' => 'Vacancy Seeder',
                'updated_by' => null,
                'deleted_by' => null,
                'locale' => 'nl',
                'pid' => null,
                'title' => 'Senior PHP Developer',
                'title_2' => null,
                'title_3' => null,
                'slug' => 'senior-php-developer',
                'seo_title' => 'Senior PHP Developer - Vacature',
                'seo_description' => 'Wij zoeken een ervaren Senior PHP Developer voor ons ontwikkelteam.',
                'excerpt' => 'Ervaren PHP developer gezocht voor uitdagend project.',
                'content' => '<h1>Senior PHP Developer</h1><p>Wij zijn op zoek naar een ervaren Senior PHP Developer die ons team komt versterken.</p><h2>Wat ga je doen?</h2><ul><li>Ontwikkelen van webapplicaties in PHP</li><li>Werken met Laravel framework</li><li>Code reviews uitvoeren</li><li>Mentoring van junior developers</li></ul><h2>Wat bieden wij?</h2><ul><li>Competitief salaris</li><li>Flexibele werktijden</li><li>Thuiswerkmogelijkheden</li><li>Doorgroeimogelijkheden</li></ul>',
                'summary_requirements' => 'Minimaal 5 jaar ervaring met PHP, Laravel kennis vereist, teamplayer',
                'tags' => 'PHP,Laravel,Senior,Development',
                'sort' => 1,
                'show_from' => now(),
                'show_till' => now()->addMonths(3),
                'email_receivers' => json_encode(['hr@company.com', 'tech@company.com']),
                'text_1' => 'Fulltime',
                'text_2' => '40 uur per week',
                'text_3' => 'Amsterdam',
                'text_4' => '€4000-6000',
                'email_client' => 'hr@company.com',
                'email_webmaster' => 'webmaster@company.com',
                'data' => json_encode([
                    'department' => 'IT',
                    'level' => 'Senior',
                    'contract_type' => 'Vast'
                ]),
            ],
            [
                'company_id' => 1,
                'created_by' => 'Vacancy Seeder',
                'updated_by' => null,
                'deleted_by' => null,
                'locale' => 'nl',
                'pid' => null,
                'title' => 'Frontend Developer',
                'title_2' => null,
                'title_3' => null,
                'slug' => 'frontend-developer',
                'seo_title' => 'Frontend Developer - Vacature',
                'seo_description' => 'Creatieve Frontend Developer gezocht voor moderne webprojecten.',
                'excerpt' => 'Creatieve frontend developer voor moderne webapplicaties.',
                'content' => '<h1>Frontend Developer</h1><p>Ben jij een creatieve Frontend Developer die graag werkt aan moderne webapplicaties?</p><h2>Wat ga je doen?</h2><ul><li>Ontwikkelen van responsive websites</li><li>Werken met moderne JavaScript frameworks</li><li>UI/UX implementatie</li><li>Cross-browser compatibility</li></ul><h2>Wat zoeken wij?</h2><ul><li>Ervaring met HTML, CSS, JavaScript</li><li>Kennis van Vue.js of React</li><li>Oog voor detail</li><li>Teamspeler</li></ul>',
                'summary_requirements' => 'HTML, CSS, JavaScript, Vue.js of React ervaring, oog voor detail',
                'tags' => 'Frontend,JavaScript,Vue,React,CSS',
                'sort' => 2,
                'show_from' => now(),
                'show_till' => now()->addMonths(2),
                'email_receivers' => json_encode(['hr@company.com']),
                'text_1' => 'Fulltime/Parttime',
                'text_2' => '32-40 uur per week',
                'text_3' => 'Amsterdam/Remote',
                'text_4' => '€3000-4500',
                'email_client' => 'hr@company.com',
                'email_webmaster' => 'webmaster@company.com',
                'data' => json_encode([
                    'department' => 'IT',
                    'level' => 'Medior',
                    'contract_type' => 'Vast'
                ]),
            ],
            [
                'company_id' => 1,
                'created_by' => 'Vacancy Seeder',
                'updated_by' => null,
                'deleted_by' => null,
                'locale' => 'nl',
                'pid' => null,
                'title' => 'Marketing Manager',
                'title_2' => null,
                'title_3' => null,
                'slug' => 'marketing-manager',
                'seo_title' => 'Marketing Manager - Vacature',
                'seo_description' => 'Ervaren Marketing Manager gezocht voor het leiden van ons marketingteam.',
                'excerpt' => 'Leid ons marketingteam en ontwikkel strategieën.',
                'content' => '<h1>Marketing Manager</h1><p>Wij zoeken een ervaren Marketing Manager die ons marketingteam kan leiden en inspireren.</p><h2>Verantwoordelijkheden</h2><ul><li>Ontwikkelen van marketingstrategieën</li><li>Leiden van het marketingteam</li><li>Budget beheer</li><li>Campagne ontwikkeling</li></ul><h2>Wat bieden wij?</h2><ul><li>Leidinggevende rol</li><li>Uitdagend werk</li><li>Goede arbeidsvoorwaarden</li><li>Professionele ontwikkeling</li></ul>',
                'summary_requirements' => 'Minimaal 3 jaar leidinggevende ervaring, marketing achtergrond, strategisch denken',
                'tags' => 'Marketing,Management,Strategy,Leadership',
                'sort' => 3,
                'show_from' => now(),
                'show_till' => now()->addMonths(2),
                'email_receivers' => json_encode(['hr@company.com', 'cmo@company.com']),
                'text_1' => 'Fulltime',
                'text_2' => '40 uur per week',
                'text_3' => 'Amsterdam',
                'text_4' => '€4500-6500',
                'email_client' => 'hr@company.com',
                'email_webmaster' => 'webmaster@company.com',
                'data' => json_encode([
                    'department' => 'Marketing',
                    'level' => 'Manager',
                    'contract_type' => 'Vast'
                ]),
            ],
            [
                'company_id' => 1,
                'created_by' => 'Vacancy Seeder',
                'updated_by' => null,
                'deleted_by' => null,
                'locale' => 'nl',
                'pid' => null,
                'title' => 'Junior Developer',
                'title_2' => null,
                'title_3' => null,
                'slug' => 'junior-developer',
                'seo_title' => 'Junior Developer - Vacature',
                'seo_description' => 'Startende developer gezocht voor ons ontwikkelteam.',
                'excerpt' => 'Start je carrière als developer in ons team.',
                'content' => '<h1>Junior Developer</h1><p>Ben je net afgestudeerd of heb je weinig ervaring? Wij bieden je de kans om je te ontwikkelen!</p><h2>Wat ga je leren?</h2><ul><li>Moderne ontwikkeltechnieken</li><li>Werken in een team</li><li>Best practices</li><li>Code reviews</li></ul><h2>Wat zoeken wij?</h2><ul><li>Afgeronde IT opleiding</li><li>Basis programmeerkennis</li><li>Leergierigheid</li><li>Teamspirit</li></ul>',
                'summary_requirements' => 'IT opleiding, basis programmeerkennis, leergierig, teamplayer',
                'tags' => 'Junior,Development,Learning,Entry-level',
                'sort' => 4,
                'show_from' => now(),
                'show_till' => now()->addMonths(6),
                'email_receivers' => json_encode(['hr@company.com']),
                'text_1' => 'Fulltime',
                'text_2' => '40 uur per week',
                'text_3' => 'Amsterdam',
                'text_4' => '€2500-3500',
                'email_client' => 'hr@company.com',
                'email_webmaster' => 'webmaster@company.com',
                'data' => json_encode([
                    'department' => 'IT',
                    'level' => 'Junior',
                    'contract_type' => 'Vast'
                ]),
            ],
        ];

        $created = 0;
        $existing = 0;

        foreach ($vacancyItems as $item) {
            // Check if vacancy already exists based on slug and locale
            $existingVacancy = Vacancy::where('slug', $item['slug'])
                ->where('locale', $item['locale'])
                ->first();

            if (!$existingVacancy) {
                Vacancy::create($item);
                $this->info("   ✅ Vacancy '{$item['title']}' created.");
                $created++;
            } else {
                $this->info("   ℹ️  Vacancy '{$item['title']}' already exists.");
                $existing++;
            }
        }

        $this->info("   📊 {$created} vacancies created, {$existing} vacancies already existed.");
    }

    /**
     * Seed navigation items by calling the manta:seed-navigation command
     */
    private function seedNavigation(): void
    {
        $this->info('🧭 Seeding navigation items...');

        try {
            // First, call the general manta:seed-navigation command from manta-laravel-flux-cms
            $exitCode = $this->call('manta:seed-navigation', [
                '--force' => true // Always force navigation seeding
            ]);

            if ($exitCode === 0) {
                $this->info('   ✅ General navigation items seeded successfully.');
            } else {
                $this->warn('   ⚠️  General navigation seeding completed with warnings.');
            }

            // Then seed vacancy-specific navigation items
            $this->seedVacancyNavigation();
        } catch (\Exception $e) {
            $this->warn('   ⚠️  Navigation seeding failed: ' . $e->getMessage());
            $this->warn('   💡 You can manually run "php artisan manta:seed-navigation" later.');
        }
    }

    /**
     * Seed vacancy-specific navigation items
     */
    private function seedVacancyNavigation(): void
    {
        $this->info('💼 Seeding vacancy navigation items...');

        try {
            // Check if MantaNav model exists
            if (!class_exists('\Manta\FluxCMS\Models\MantaNav')) {
                $this->warn('   ⚠️  MantaNav model not found. Skipping vacancy navigation seeding.');
                return;
            }

            $vacancyNavItems = [
                [
                    'title' => 'Vacatures',
                    'route' => 'vacancy.list',
                    'sort' => 15,
                    'type' => 'module',
                    'description' => 'Beheer vacatures'
                ],
                [
                    'title' => 'Vacature Reacties',
                    'route' => 'vacancy.reaction.list',
                    'sort' => 16,
                    'type' => 'module',
                    'description' => 'Beheer vacature reacties'
                ]
            ];

            $MantaNav = '\Manta\FluxCMS\Models\MantaNav';
            $created = 0;
            $existing = 0;

            foreach ($vacancyNavItems as $item) {
                // Check if navigation item already exists
                $existingNav = $MantaNav::where('route', $item['route'])
                    ->where('locale', 'nl')
                    ->first();

                if (!$existingNav) {
                    $MantaNav::create([
                        'created_by' => 'Vacancy Seeder',
                        'updated_by' => null,
                        'deleted_by' => null,
                        'company_id' => 1, // Default company
                        'host' => request()->getHost() ?? 'localhost',
                        'pid' => null,
                        'locale' => 'nl',
                        'active' => true,
                        'sort' => $item['sort'],
                        'title' => $item['title'],
                        'route' => $item['route'],
                        'url' => null,
                        'type' => $item['type'],
                        'rights' => null,
                        'data' => json_encode([
                            'description' => $item['description'],
                            'icon' => 'briefcase',
                            'module' => 'manta-vacancy'
                        ]),
                    ]);

                    $this->info("   ✅ Vacancy navigation item '{$item['title']}' created.");
                    $created++;
                } else {
                    $this->info("   ℹ️  Vacancy navigation item '{$item['title']}' already exists.");
                    $existing++;
                }
            }

            $this->info("   📊 {$created} items created, {$existing} items already existed.");
        } catch (\Exception $e) {
            $this->warn('   ⚠️  Vacancy navigation seeding failed: ' . $e->getMessage());
            $this->warn('   💡 This may be due to missing MantaNav model or database table.');
        }
    }
}
