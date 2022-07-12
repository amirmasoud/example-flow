<?php

namespace Domain\Users\Models;

use Domain\Users\QueryBuilders\RoleQueryBuilder;

class Role extends \Spatie\Permission\Models\Role
{
    public function newEloquentBuilder($query): RoleQueryBuilder
    {
        return new RoleQueryBuilder($query);
    }
}
