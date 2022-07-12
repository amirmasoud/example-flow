<?php

namespace App\Dashboard\Resources\UI;

use Domain\Users\Models\User;
use App\Dashboard\UI\Table\FieldTableUI;
use App\Dashboard\UI\Table\ActionTableUI;

class UserTableResource extends BaseUI
{
    public function __construct(public User $user = new User)
    {
        parent::__construct($user);
    }

    public function toArray($request)
    {
        return [
            'fields' => [
                new FieldTableUI('name', 'Name'),
                new FieldTableUI('email', 'Email'),
                new FieldTableUI('email_verified_at', 'Email Verified At'),
            ],
            'actions' => array_combine(
                ['edit', 'delete', 'create'],
                [
                    new ActionTableUI('edit', 'Edit', 'dashboard.users.edit'),
                    new ActionTableUI('delete', 'Delete', 'dashboard.users.destroy'),
                    new ActionTableUI('create', 'Create', 'dashboard.users.create'),
                ]
            ),
        ];
    }
}
