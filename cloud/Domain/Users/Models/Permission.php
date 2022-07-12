<?php

namespace Domain\Users\Models;

use Domain\Users\QueryBuilders\PermissionQueryBuilder;

class Permission extends \Spatie\Permission\Models\Permission
{
    public function newEloquentBuilder($query): PermissionQueryBuilder
    {
        return new PermissionQueryBuilder($query);
    }
}
