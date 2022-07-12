<?php

namespace Domain\Sites;

use Domain\Sites\Enums\SiteStatusEnum;
use Domain\Sites\Models\Site;

/**
 * @method static up(Site $site)
 * @method static installing(Site $site)
 * @method static retrying(Site $site)
 * @method static failed(Site $site)
 * @method static starting(Site $site)
 * @method static stopping(Site $site)
 * @method static stopped(Site $site)
 * @method static restarting(Site $site)
 * @method static deleting(Site $site)
 */
class ChangeSiteStatus
{
    public static function __callStatic($name, $arguments): void
    {
        $site = $arguments[0] instanceof Site ? $arguments[0] : Site::findOrFail($arguments[0]);
        $status = SiteStatusEnum::tryFrom($name);

        (new self)->set($site, $status);
    }

    public function set(Site|int $site, SiteStatusEnum $status): void
    {
        $site->status = $status->value;
        $site->save();
    }
}
