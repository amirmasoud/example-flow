<?php

namespace Domain\Sites\Subscribers;

use Domain\Sites\ChangeSiteStatus;
use Domain\Sites\Models\Site;
use Illuminate\Contracts\Queue\ShouldBeUniqueUntilProcessing;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Bus;
use Support\Containers\Services\TraefikService;
use Support\Containers\Services\WordPressService;
use Throwable;

class SiteSubscriber implements ShouldQueue, ShouldBeUniqueUntilProcessing
{
    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 60 * 10;

    /**
     * Indicate if the job should be marked as failed on timeout.
     *
     * @var bool
     */
    public $failOnTimeout = true;

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $backoff = 60;

    /**
     * @throws \Support\Containers\Exceptions\DockerComposePathNotDirectoryException
     * @throws \Support\Containers\Exceptions\DockerComposeMissingException
     * @throws \Support\Certificates\Exceptions\MkcertMissingException
     * @throws \Support\Containers\Exceptions\DockerSwarmServiceMissingException
     * @throws \Support\Containers\Exceptions\DockerComposeFailedException
     * @throws \Support\Containers\Exceptions\CommandExecutionFailed
     */
    public function handleSiteCreated(Site $site)
    {
        $site->load('stack');

        $email = $site->user->email;
        $url = "https://$site->host";
        $title = "$site->name WordPress Site";
        $password = 'secret';

        $plugins = implode(' ', $site->stack->properties->plugins);
        $theme = $site->stack->properties->theme;

        $commands = preg_split('/\r\n|\r|\n/', Site::first()->stack->properties->commands); // @todo Not good
        $commands = implode(' && ', $commands);

        Bus::chain([
            ChangeSiteStatus::installing($site),
            // TraefikService::deploySwarm(),
            TraefikService::install(force: true),
            TraefikService::deployCompose(),
            WordPressService::install($site->host),
            // WordPressService::deploySwarm($site->host),
            WordPressService::deployCompose($site->host),
            sleep(32), // Handle it better (waiting for MariaDB to start)
            // WordPressService::execSwarm($site->host, "wp core install --url=$url --title=\"$title\" --admin_user='admin' --admin_email=$email --admin_password=\"$password\""),
            // WordPressService::execSwarm($site->host, "wp core update"),
            // WordPressService::execSwarm($site->host, "wp theme install $theme --activate"),
            // WordPressService::execSwarm($site->host, "wp plugin install $plugins --activate"),
            WordPressService::execCompose($site->host, "wp core install --url=$url --title=\"$title\" --admin_user='admin' --admin_email=$email --admin_password=\"$password\""),
            WordPressService::execCompose($site->host, 'wp core update'),
            WordPressService::execCompose($site->host, "wp theme install $theme --activate"),
            WordPressService::execCompose($site->host, "wp plugin install $plugins --activate"),
            WordPressService::execCompose($site->host, line($commands)),
            ChangeSiteStatus::up($site),
        ])->catch(function (Throwable $e) use ($site) {
            ChangeSiteStatus::failed($site);
        });
    }

    /**
     * @throws \Support\Containers\Exceptions\DockerComposePathNotDirectoryException
     * @throws \Support\Containers\Exceptions\DockerComposeMissingException
     * @throws \Support\Containers\Exceptions\DockerSwarmServiceMissingException
     */
    public function handleSiteDeleted(Site $site)
    {
        Bus::chain([
            ChangeSiteStatus::stopped($site),
            // WordPressService::noReplicaSwarm($site->host),
            WordPressService::stopCompose($site->host),
            ChangeSiteStatus::stopped($site),
        ]);
    }

    /**
     * @throws \Support\Containers\Exceptions\DockerComposePathNotDirectoryException
     * @throws \Support\Containers\Exceptions\DockerComposeMissingException
     * @throws \Support\Containers\Exceptions\DockerSwarmServiceMissingException
     */
    public function handleSiteStarted(Site $site)
    {
        Bus::chain([
            // WordPressService::oneReplicaSwarm($site->host),
            WordPressService::startCompose($site->host),
        ]);
    }

    /**
     * @throws \Support\Containers\Exceptions\DockerComposePathNotDirectoryException
     * @throws \Support\Containers\Exceptions\DockerComposeMissingException
     * @throws \Support\Containers\Exceptions\DockerSwarmServiceMissingException
     */
    public function handleSiteRestored(Site $site)
    {
        Bus::chain([
            ChangeSiteStatus::starting($site),
            // WordPressService::oneReplicaSwarm($site->host),
            WordPressService::startCompose($site->host),
            ChangeSiteStatus::up($site),
        ]);
    }

    public function handleSiteStopped(Site $site)
    {
        Bus::chain([
            ChangeSiteStatus::stopping($site),
            // WordPressService::noReplicaSwarm($site->host),
            WordPressService::stopCompose($site->host),
            ChangeSiteStatus::stopped($site),
        ])->catch(function (Throwable $e) use ($site) {
            ChangeSiteStatus::failed($site);
        });
    }

    public function handleSiteForceDeleted(Site $site)
    {
        $host = $site->host;

        Bus::chain([
            // WordPressService::removeSwarm($site->host),
            WordPressService::removeCompose($site->host),
        ]);
    }

    public function handleSiteRestarted(Site $site)
    {
        Bus::chain([
            // WordPressService::noReplicaSwarm($site->host),
            // WordPressService::oneReplicaSwarm($site->host),
            WordPressService::restartCompose($site->host),
        ]);
    }

    public function subscribe($events): array
    {
        return [
            'eloquent.created: Domain\Sites\Models\Site' => 'handleSiteCreated',
            'eloquent.deleting: Domain\Sites\Models\Site' => 'handleSiteDeleted',
            'eloquent.restored: Domain\Sites\Models\Site' => 'handleSiteRestored',
            'eloquent.forceDeleted: Domain\Sites\Models\Site' => 'handleSiteForceDeleted',
            'eloquent.started: Domain\Sites\Models\Site' => 'handleSiteStarted',
            'eloquent.stopped: Domain\Sites\Models\Site' => 'handleSiteStopped',
            'eloquent.restarted: Domain\Sites\Models\Site' => 'handleSiteRestarted',
        ];
    }
}
