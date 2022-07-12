<?php

namespace Domain\Users\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class RoleQueryBuilder extends Builder
{
    public function search(?string $search)
    {
        return $this->when($search,
            fn ($query, $search) => $query->where(
                fn ($query) => $query->where('name', 'like', "%{$search}%")
            )
        );
    }
}
