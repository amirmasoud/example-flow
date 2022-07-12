<?php

namespace Domain\Sites\Jobs;

use Domain\Sites\Enums\SiteStatusEnum;
use Domain\Sites\Models\Site;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUniqueUntilProcessing;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Support\Containers\Shell\DockerCompose;

class ContainerStatusJob implements ShouldQueue, ShouldBeUniqueUntilProcessing
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Site $site)
    {
        //
    }

    public function handle()
    {
        $containers = DockerCompose::for($this->site)->status();

        foreach ($containers as $container) {
            logger('hey');
            if ($container->state !== 'running') {
                $this->site->update([
                    'status' => SiteStatusEnum::STOPPED,
                ]);
            }
        }
    }
}
