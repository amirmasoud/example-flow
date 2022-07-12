<?php

namespace App\Dashboard\Resources\UI;

use App\Dashboard\UI\StatUI;
use Domain\Sites\Models\Site;

class SiteStatResource extends BaseUI
{
    public function __construct(public Site $site = new Site)
    {
        parent::__construct($site);
    }

    public function toArray($request)
    {
        $total = Site::withTrashed()->count();

        return [
            new StatUI('Total Sites', $total, $total, '12%', 'increase'),
            new StatUI('Healthy Sites', Site::healthy()->count(), $total, '12%', 'decrease'),
            new StatUI('Unhealthy Sites', Site::unhealthy()->count(), $total, '12%', 'decrease'),
        ];
    }
}
