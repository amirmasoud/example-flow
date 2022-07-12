<?php

namespace App\Dashboard\Resources\UI;

use App\Dashboard\UI\Table\ActionTableUI;
use App\Dashboard\UI\Table\FieldTableUI;
use Domain\Sites\Models\Site;

class ServerTableResource extends BaseUI
{
    public function __construct(public Site $site = new Site)
    {
        parent::__construct($site);
    }

    public function toArray($request)
    {
        return [
            'fields' => [
                new FieldTableUI('name', 'Name'),
                new FieldTableUI('price', 'Price'),
                new FieldTableUI('cpu', 'CPU'),
                new FieldTableUI('ram', 'RAM'),
                new FieldTableUI('ram_unit', ''),
                new FieldTableUI('disk', 'Disk'),
                new FieldTableUI('disk_unit', ''),
                new FieldTableUI('disk_type', ''),
                new FieldTableUI('status', 'Status'),
            ],
            'actions' => array_combine(
                ['edit', 'delete', 'create'],
                [
                    new ActionTableUI('edit', 'Edit', 'dashboard.sites.servers.edit'),
                    new ActionTableUI('delete', 'Delete', 'dashboard.sites.servers.destroy'),
                    new ActionTableUI('create', 'Create', 'dashboard.sites.servers.create'),
                ]
            ),
        ];
    }
}
