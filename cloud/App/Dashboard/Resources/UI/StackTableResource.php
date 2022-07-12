<?php

namespace App\Dashboard\Resources\UI;

use App\Dashboard\UI\Table\ActionTableUI;
use App\Dashboard\UI\Table\FieldTableUI;
use Domain\Sites\Models\Stack;

class StackTableResource extends BaseUI
{
    public function __construct(public Stack $stack = new Stack())
    {
        parent::__construct($stack);
    }

    public function toArray($request)
    {
        return [
            'fields' => [
                new FieldTableUI('name', 'Name'),
                new FieldTableUI('type', 'Type'),
            ],
            'actions' => array_combine(
                ['edit', 'delete', 'create'],
                [
                    new ActionTableUI('edit', 'Edit', 'dashboard.sites.stacks.edit'),
                    new ActionTableUI('delete', 'Delete', 'dashboard.sites.stacks.destroy'),
                    new ActionTableUI('create', 'Create', 'dashboard.sites.stacks.create'),
                ]
            ),
        ];
    }
}
