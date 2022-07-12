<?php

namespace Domain\Sites\QueryBuilders;

use Domain\Sites\Enums\SiteStatusEnum;
use Illuminate\Database\Eloquent\Builder;

class SiteQueryBuilder extends Builder
{
    public function search(?string $search)
    {
        return $this->when($search,
            fn ($query, $search) => $query->where(
                fn ($query) => $query->where('name', 'like', "%{$search}%")->orWhere('host', 'like', "%{$search}%")
            )
        );
    }

    public function healthy(): SiteQueryBuilder
    {
        return $this->where('status', SiteStatusEnum::UP->value);
    }

    public function unhealthy(): SiteQueryBuilder
    {
        return $this->where('status', '<>', SiteStatusEnum::UP->value);
    }
}
