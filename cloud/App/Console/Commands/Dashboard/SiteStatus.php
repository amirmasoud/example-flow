<?php

namespace App\Console\Commands\Dashboard;

use Domain\Sites\Models\Site;
use Illuminate\Console\Command;
use Support\Containers\Shell\DockerCompose;

class SiteStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'site:status {--site=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check site status using Docker compose status check';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($site = Site::find($this->option('site'))) {
            $this->info('Checking site: '.$site->name);
            foreach (DockerCompose::for($site->host)->status()->containerData as $service) {
                $print = $service->state !== 'running' ? 'error' : 'info';
                $this->{$print}($service->name.': '.$service->state);
            }
            $this->info('Status: '.$site->status->value);

            return self::SUCCESS;
        } else {
            $this->error('Site not found');

            return self::FAILURE;
        }
    }
}
