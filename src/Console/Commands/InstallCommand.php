<?php

namespace Darvis\MantaVacancy\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'manta-vacancy:install 
                            {--force : Overwrite existing files}
                            {--migrate : Run migrations after installation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Manta Vacancy package';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Installing Manta Vacancy Package...');
        $this->newLine();

        // Step 1: Publish configuration
        $this->publishConfiguration();

        // Step 2: Publish migrations
        $this->publishMigrations();

        // Step 3: Run migrations if requested
        if ($this->option('migrate')) {
            $this->runMigrations();
        }

        // Step 4: Create default configuration
        $this->createDefaultConfiguration();

        // Step 5: Show completion message
        $this->showCompletionMessage();

        return self::SUCCESS;
    }

    /**
     * Publish configuration files
     */
    protected function publishConfiguration(): void
    {
        $this->info('📝 Publishing configuration files...');

        $params = [
            '--provider' => 'Darvis\MantaVacancy\VacancyServiceProvider',
            '--tag' => 'manta-vacancy-config'
        ];

        if ($this->option('force')) {
            $params['--force'] = true;
        }

        Artisan::call('vendor:publish', $params);

        $this->line('   ✅ Configuration published to config/manta-vacancy.php');
    }

    /**
     * Publish migration files
     */
    protected function publishMigrations(): void
    {
        $this->info('📦 Publishing migration files...');

        $params = [
            '--provider' => 'Darvis\MantaVacancy\VacancyServiceProvider',
            '--tag' => 'manta-vacancy-migrations'
        ];

        if ($this->option('force')) {
            $params['--force'] = true;
        }

        Artisan::call('vendor:publish', $params);

        $this->line('   ✅ Migrations published to database/migrations/');
    }

    /**
     * Run database migrations
     */
    protected function runMigrations(): void
    {
        $this->info('🗄️  Running database migrations...');

        if ($this->confirm('This will run the database migrations. Continue?', true)) {
            Artisan::call('migrate');
            $this->line('   ✅ Migrations completed successfully');
        } else {
            $this->warn('   ⚠️  Migrations skipped. Run "php artisan migrate" manually later.');
        }
    }

    /**
     * Create default configuration if it doesn't exist
     */
    protected function createDefaultConfiguration(): void
    {
        $this->info('⚙️  Setting up default configuration...');

        $configPath = config_path('manta-vacancy.php');

        if (File::exists($configPath)) {
            $config = include $configPath;
            
            // Check if configuration needs updating
            if (!isset($config['route_prefix'])) {
                $this->warn('   ⚠️  Configuration file exists but may need manual updates');
            } else {
                $this->line('   ✅ Configuration file is ready');
            }
        } else {
            $this->error('   ❌ Configuration file not found. Please run the install command again.');
        }
    }

    /**
     * Show completion message with next steps
     */
    protected function showCompletionMessage(): void
    {
        $this->newLine();
        $this->info('🎉 Manta Vacancy Package installed successfully!');
        $this->newLine();

        $this->comment('Next steps:');
        $this->line('1. Configure your settings in config/manta-vacancy.php');
        
        if (!$this->option('migrate')) {
            $this->line('2. Run migrations: php artisan migrate');
        }
        
        $this->line('3. Access the vacancy management at: /cms/vacancy (or your configured route)');
        $this->newLine();

        $this->comment('Available routes:');
        $this->line('• GET /cms/vacancy - Vacancy list');
        $this->line('• GET /cms/vacancy/toevoegen - Create new vacancy');
        $this->line('• GET /cms/vacancy/aanpassen/{id} - Edit vacancy');
        $this->line('• GET /cms/vacancy/lezen/{id} - View vacancy');
        $this->line('• GET /cms/vacancy/bestanden/{id} - Manage vacancy files');
        $this->line('• GET /cms/vacancy/vacancyreaction - Vacancy reactions');
        $this->line('• GET /cms/vacancy/vacancyreaction/instellingen - Vacancy reaction settings');
        $this->newLine();

        $this->info('📚 For more information, check the README.md file.');
    }
}
