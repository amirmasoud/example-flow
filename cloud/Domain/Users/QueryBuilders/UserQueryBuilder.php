<?php

namespace Domain\Users\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class UserQueryBuilder extends Builder
{
    public function search(?string $search)
    {
        return $this->when($search,
            fn ($query, $search) => $query->where(
                fn ($query) => $query->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%")
            )
        );
    }

    public function verified(): UserQueryBuilder
    {
        return $this->whereNotNull('verified');
    }

    public function unverified(): UserQueryBuilder
    {
        return $this->whereNull('verified');
    }
}
