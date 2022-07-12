<?php

namespace App\Dashboard\Resources\UI;

use Domain\Users\Models\Role;
use App\Dashboard\UI\Table\FieldTableUI;
use App\Dashboard\UI\Table\ActionTableUI;

class RoleTableResource extends BaseUI
{
    public function __construct(public Role $role = new Role)
    {
        parent::__construct($role);
    }

    public function toArray($request)
    {
        return [
            'fields' => [
                new FieldTableUI('name', 'Name'),
            ],
            'actions' => array_combine(
                ['edit', 'delete', 'create'],
                [
                    new ActionTableUI('edit', 'Edit', 'dashboard.users.roles.edit'),
                    new ActionTableUI('delete', 'Delete', 'dashboard.users.roles.destroy'),
                    new ActionTableUI('create', 'Create', 'dashboard.users.roles.create'),
                ]
            ),
        ];
    }
}
