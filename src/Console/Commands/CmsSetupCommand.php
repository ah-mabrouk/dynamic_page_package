<?php

namespace SolutionPlus\Cms\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CmsSetupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install and Publish CMS Package';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Publishing configuration...');

        if (! $this->configExists('cms.php')) {
            $this->publishConfiguration();
            $this->info('Published configuration');
        } else {
            if ($this->shouldOverwriteConfig()) {
                $this->info('Overwriting configuration file...');
                $this->publishConfiguration(true);
            } else {
                $this->info('Existing configuration is not overwritten');
            }
        }

        $this->info('Caching configs...');
        $this->call('config:cache');

        if ($this->confirm('Do you want to run migrate command now?', false)) {
            $this->runMigration();
        }

        return Command::SUCCESS;
    }

    private function configExists($fileName)
    {
        return File::exists(config_path($fileName));
    }

    private function shouldOverwriteConfig()
    {
        return $this->confirm(
            'Config file already exists. Do you want to overwrite it?',
            false
        );
    }

    private function publishConfiguration($forcePublish = false)
    {
        $params = [
            '--provider' => 'SolutionPlus\Cms\CmsServiceProvider',
        ];

        if ($forcePublish === true) {
            $params['--force'] = true;
        }

       $this->call('vendor:publish', $params);
    }

    public function runMigration()
    {
        $this->info('Running migrate command...');
        $this->call('migrate');
        $this->info('Migration completed successfully.');
    }
}
